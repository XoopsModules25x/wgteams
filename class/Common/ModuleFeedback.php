<?php

namespace XoopsModules\Wgteams\Common;

/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * Feedback plugin for xoops modules
 *
 * @copyright      XOOPS Project  (https://xoops.org)
 * @license        GNU GPL 2 or later (https://www.gnu.org/licenses/gpl-2.0.html)
 * @author         Michael Beck <mambax7@gmailc.com>
 * @author         Wedega - Email:<webmaster@wedega.com>
 * @author         Fernando Santos (topet05) <fernando@mastop.com.br>
 */
\defined('XOOPS_ROOT_PATH') || die('Restricted access');

/**
 * Class Object ModuleFeedback
 */
class ModuleFeedback extends \XoopsObject
{
    public $name    = '';
    public $email   = '';
    public $site    = '';
    public $type    = '';
    public $content = '';

    /**
     * Constructor
     *
     * @param null
     */
    public function __construct()
    {
    }

    /**
     * @static function &getInstance
     *
     * @param null
     */
    public static function getInstance()
    {
        static $instance = false;
        if (!$instance) {
            $instance = new self();
        }
    }

    /**
     * @public function getFormFeedback:
     * provide form for sending a feedback to module author
     * @return \XoopsThemeForm
     */
    public function getFormFeedback()
    {
        $moduleDirName      = \basename(\dirname(__DIR__, 2));
        $moduleDirNameUpper = \mb_strtoupper($moduleDirName);
        // Get Theme Form
        \xoops_load('XoopsFormLoader');
        $form = new \XoopsThemeForm(\constant('_FB_FORM_TITLE'), 'formfeedback', 'feedback.php', 'post', true);
        $form->setExtra('enctype="multipart/form-data"');

        $recipient = new \XoopsFormText(\constant('_FB_RECIPIENT'), 'recipient', 50, 255, $GLOBALS['xoopsModule']->getInfo('author_mail'));
        $recipient->setExtra('disabled="disabled"');
        $form->addElement($recipient);
        $your_name = new \XoopsFormText(\constant('_FB_NAME'), 'your_name', 50, 255, $this->name);
        $your_name->setExtra('placeholder="' . \constant('_FB_NAME_PLACEHOLER') . '"');
        $form->addElement($your_name);
        $your_site = new \XoopsFormText(\constant('_FB_SITE'), 'your_site', 50, 255, $this->site);
        $your_site->setExtra('placeholder="' . \constant('_FB_SITE_PLACEHOLER') . '"');
        $form->addElement($your_site);
        $your_mail = new \XoopsFormText(\constant('_FB_MAIL'), 'your_mail', 50, 255, $this->email);
        $your_mail->setExtra('placeholder="' . \constant('_FB_MAIL_PLACEHOLER') . '"');
        $form->addElement($your_mail);

        $fbtypeSelect = new \XoopsFormSelect(\constant('_FB_TYPE'), 'fb_type', $this->type);
        $fbtypeSelect->addOption('');
        $fbtypeSelect->addOption(\constant('_FB_TYPE_SUGGESTION'), \constant('_FB_TYPE_SUGGESTION'));
        $fbtypeSelect->addOption(\constant('_FB_TYPE_BUGS'), \constant('_FB_TYPE_BUGS'));
        $fbtypeSelect->addOption(\constant('_FB_TYPE_TESTIMONIAL'), \constant('_FB_TYPE_TESTIMONIAL'));
        $fbtypeSelect->addOption(\constant('_FB_TYPE_FEATURES'), \constant('_FB_TYPE_FEATURES'));
        $fbtypeSelect->addOption(\constant('_FB_TYPE_OTHERS'), \constant('_FB_TYPE_OTHERS'));
        $form->addElement($fbtypeSelect, true);

        $editorConfigs           = [];
        $editorConfigs['name']   = 'fb_content';
        $editorConfigs['value']  = $this->content;
        $editorConfigs['rows']   = 5;
        $editorConfigs['cols']   = 40;
        $editorConfigs['width']  = '100%';
        $editorConfigs['height'] = '400px';
        $moduleHandler           = \xoops_getHandler('module');
        $module                  = $moduleHandler->getByDirname('system');
        $configHandler           = \xoops_getHandler('config');
        $config                  = &$configHandler->getConfigsByCat(0, $module->getVar('mid'));
        $editorConfigs['editor'] = $config['general_editor'];
        $editor                  = new \XoopsFormEditor(\constant('_FB_TYPE_CONTENT'), 'fb_content', $editorConfigs);
        $form->addElement($editor, true);

        $form->addElement(new \XoopsFormHidden('op', 'send'));
        $form->addElement(new \XoopsFormButtonTray('', \_SUBMIT, 'submit', '', false));

        return $form;
    }
}

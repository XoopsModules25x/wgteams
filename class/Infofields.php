<?php

namespace XoopsModules\Wgteams;

/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/
/**
 * wgTeams module for xoops
 *
 * @copyright       The XOOPS Project (https://xoops.org)
 * @license         GPL 2.0 or later
 * @package         wgteams
 * @author          Goffy - Wedega.com - Email:<webmaster@wedega.com> - Website:<https://wedega.com>
 */
\defined('XOOPS_ROOT_PATH') || exit('Restricted access');

/**
 * Class Infofields
 */
class Infofields extends \XoopsObject
{
    /**
     * @var mixed
     */
    private $helper = null;

    /**
     * Constructor
     *
     * @param null
     */
    public function __construct()
    {
        $this->helper = Helper::getInstance();
        $this->initVar('infofield_id', \XOBJ_DTYPE_INT);
        $this->initVar('infofield_name', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('infofield_submitter', \XOBJ_DTYPE_INT);
        $this->initVar('infofield_date_created', \XOBJ_DTYPE_INT);
    }

    /**
     * @static function getInstance
     * @param null
     * @return static
     */
    public static function getInstance()
    {
        static $instance;
        if (null === $instance) {
            $instance = new static();
        }

        return $instance;
    }

    /**
     * Get form
     *
     * @param bool|mixed $action
     * @return \XoopsThemeForm
     */
    public function getFormInfofields($action = false)
    {
        global $xoopsUser;

        if (false === $action) {
            $action = $_SERVER['REQUEST_URI'];
        }

        // Title
        $title = $this->isNew() ? \sprintf(_AM_WGTEAMS_INFOFIELD_ADD) : \sprintf(_AM_WGTEAMS_INFOFIELD_EDIT);
        // Get Theme Form
        \xoops_load('XoopsFormLoader');
        $form = new \XoopsThemeForm($title, 'form', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        // Form Text AddField_name
        $form->addElement(new \XoopsFormText(_AM_WGTEAMS_INFOFIELD_NAME, 'infofield_name', 50, 255, $this->getVar('infofield_name')), true);
        // Form Select User
        $submitter = $this->isNew() ? $xoopsUser->getVar('uid') : $this->getVar('infofield_submitter');
        $form->addElement(new \XoopsFormSelectUser(_AM_WGTEAMS_SUBMITTER, 'infofield_submitter', false, $submitter, 1, false));
        // Form Text Date Select
        $form->addElement(new \XoopsFormTextDateSelect(_AM_WGTEAMS_DATE_CREATE, 'infofield_date_created', '', $this->getVar('infofield_date_created')));
        // Send
        $form->addElement(new \XoopsFormHidden('op', 'save'));
        $form->addElement(new \XoopsFormButtonTray('', _SUBMIT, 'submit', '', false));

        return $form;
    }

    /**
     * Get Values
     * @param null $keys
     * @param null $format
     * @param null $maxDepth
     * @return array
     */
    public function getValuesInfofields($keys = null, $format = null, $maxDepth = null)
    {
        $ret                       = $this->getValues($keys, $format, $maxDepth);
        $ret['field_id']           = $this->getVar('infofield_id');
        $ret['field_name']         = $this->getVar('infofield_name');
        $ret['field_submitter']    = \XoopsUser::getUnameFromId($this->getVar('infofield_submitter'));
        $ret['field_date_created'] = \formatTimestamp($this->getVar('infofield_date_created'));

        return $ret;
    }

    /**
     * Returns an array representation of the object
     *
     * @return array
     **/
    public function toArray()
    {
        $ret  = [];
        $vars = &$this->getVars();
        foreach (\array_keys($vars) as $var) {
            $ret[$var] = $this->getVar($var);
        }

        return $ret;
    }
}

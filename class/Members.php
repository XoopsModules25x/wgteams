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
 * @since           1.0
 * @min_xoops       2.5.7
 * @author          Goffy - Wedega.com - Email:<webmaster@wedega.com> - Website:<https://wedega.com>
 * @version         $Id: 1.0 members.php 1 Sun 2015/12/27 23:18:00Z Goffy - Wedega $
 */

use XoopsModules\Wgteams;

defined('XOOPS_ROOT_PATH') || exit('Restricted access');

/**
 * Class WgteamsMembers
 */
class Members extends \XoopsObject
{

    /**
     * Constructor
     *
     * WgteamsMembers constructor.
     */
    public function __construct()
    {
        $this->helper = Wgteams\Helper::getInstance();
        $this->initVar('member_id', XOBJ_DTYPE_INT);
        $this->initVar('member_firstname', XOBJ_DTYPE_TXTBOX);
        $this->initVar('member_lastname', XOBJ_DTYPE_TXTBOX);
        $this->initVar('member_title', XOBJ_DTYPE_TXTBOX);
        $this->initVar('member_address', XOBJ_DTYPE_TXTAREA);
        $this->initVar('member_phone', XOBJ_DTYPE_TXTAREA);
        $this->initVar('member_email', XOBJ_DTYPE_TXTBOX);
        $this->initVar('member_image', XOBJ_DTYPE_TXTBOX);
        $this->initVar('member_uid', XOBJ_DTYPE_INT);
		$this->initVar('member_submitter', XOBJ_DTYPE_INT);
        $this->initVar('member_date_create', XOBJ_DTYPE_INT);
    }

    /**
    *  @static function getInstance
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
     * @param mixed $action
     * @return \XoopsThemeForm
     */
    public function getFormMembers($action = false)
    {
        global $xoopsUser;

        if (false === $action) {
            $action = $_SERVER['REQUEST_URI'];
        }
        // Title
        $title = $this->isNew() ? sprintf(_AM_WGTEAMS_MEMBER_ADD) : sprintf(_AM_WGTEAMS_MEMBER_EDIT);
        // Get Theme Form
        xoops_load('XoopsFormLoader');
        $form = new \XoopsThemeForm($title, 'form', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        // member handler
        //$membersHandler = $helper->getHandler('members');
        // Form Text memberFirstname
        $form->addElement(new \XoopsFormText(_AM_WGTEAMS_MEMBER_FIRSTNAME, 'member_firstname', 50, 255, $this->getVar('member_firstname')), true);
        // Form Text memberLastname
        $form->addElement(new \XoopsFormText(_AM_WGTEAMS_MEMBER_LASTNAME, 'member_lastname', 50, 255, $this->getVar('member_lastname')));
        // Form Text memberTitle
        $form->addElement(new \XoopsFormText(_AM_WGTEAMS_MEMBER_TITLE, 'member_title', 50, 255, $this->getVar('member_title')));
        // Form Text Area member_address
        $editor_configs           = [];
        $editor_configs['name']   = 'member_address';
        $editor_configs['value']  = $this->getVar('member_address', 'e');
        $editor_configs['rows']   = 5;
        $editor_configs['cols']   = 40;
        $editor_configs['width']  = '100%';
        $editor_configs['height'] = '400px';
        $editor_configs['editor'] = $this->helper->getConfig('wgteams_editor');
        $form->addElement(new \XoopsFormEditor(_AM_WGTEAMS_MEMBER_ADDRESS, 'member_address', $editor_configs));
        // Form Text Area member_phone
        $editor_configs           = [];
        $editor_configs['name']   = 'member_phone';
        $editor_configs['value']  = $this->getVar('member_phone', 'e');
        $editor_configs['rows']   = 5;
        $editor_configs['cols']   = 40;
        $editor_configs['width']  = '100%';
        $editor_configs['height'] = '400px';
        $editor_configs['editor'] = $this->helper->getConfig('wgteams_editor');
        $form->addElement(new \XoopsFormEditor(_AM_WGTEAMS_MEMBER_PHONE, 'member_phone', $editor_configs));
        // Form Text memberEmail
        $form->addElement(new \XoopsFormText(_AM_WGTEAMS_MEMBER_EMAIL, 'member_email', 50, 255, $this->getVar('member_email')));
        // Form Upload Image
        $getMemberImage = $this->getVar('member_image');
        $memberImage    = $getMemberImage ?: 'blank.gif';
        $imageDirectory = '/uploads/wgteams/members/images';

        $imageTray   = new \XoopsFormElementTray(_AM_WGTEAMS_MEMBER_IMAGE, '<br>');
        $imageSelect = new \XoopsFormSelect(_AM_WGTEAMS_FORM_IMAGE_EXIST, 'member_image', $memberImage, 5);
        $imageArray  = \XoopsLists::getImgListAsArray(XOOPS_ROOT_PATH . $imageDirectory);
        foreach ($imageArray as $image) {
            $imageSelect->addOption("{$image}", $image);
        }
        $imageSelect->setExtra("onchange='showImgSelected(\"image2\", \"member_image\", \"" . $imageDirectory . '", "", "' . XOOPS_URL . "\")'");
        $imageTray->addElement($imageSelect, false);
        $imageTray->addElement(new \XoopsFormLabel('', "<br><img src='" . XOOPS_URL . '/' . $imageDirectory . '/' . $memberImage . "' name='image2' id='image2' alt='' style='max-width:100px;' />"));
        // Form File
        $fileSelectTray = new \XoopsFormElementTray('', '<br>');
        $fileSelectTray->addElement(new \XoopsFormFile(_AM_WGTEAMS_FORM_UPLOAD_IMG, 'attachedfile', $this->helper->getConfig('wgteams_img_maxsize')));
        $fileSelectTray->addElement(new \XoopsFormLabel(_AM_WGTEAMS_MAX_FILESIZE .  $this->helper->getConfig('wgteams_img_maxsize')));
        $imageTray->addElement($fileSelectTray);
        $form->addElement($imageTray);
		// Form Select User
        $memberUid = $this->isNew() ? 0 : $this->getVar('member_uid');
		$form->addElement( new \XoopsFormSelectUser(_AM_WGTEAMS_MEMBER_UID . _AM_WGTEAMS_MEMBER_UID_DESC, 'member_uid', true, $memberUid, 1, false) );
        // Form Select User
        $submitter = $this->isNew() ? $xoopsUser->getVar('uid') : $this->getVar('member_submitter');
        $form->addElement(new \XoopsFormSelectUser(_AM_WGTEAMS_SUBMITTER, 'member_submitter', false, $submitter, 1, false));
        // Form Text Date Select
        $form->addElement(new \XoopsFormTextDateSelect(_AM_WGTEAMS_DATE_CREATE, 'member_date_create', '', $this->getVar('member_date_create')));
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
    public function getValuesMember($keys = null, $format = null, $maxDepth = null)
    {
		$ret                = $this->getValues($keys, $format, $maxDepth);
        $ret['id']          = $this->getVar('member_id');
        $ret['firstname']   = $this->getVar('member_firstname');
        $ret['lastname']    = $this->getVar('member_lastname');
        $ret['title']       = $this->getVar('member_title');
        $ret['address']     = $this->helper->truncateHtml($this->getVar('member_address', 'n'));
        $ret['phone']       = strip_tags($this->getVar('member_phone'));
        $ret['email']       = $this->getVar('member_email');
        $ret['image']       = $this->getVar('member_image');
		$ret['uid']         = 0;
		$ret['uid_text']    = '';
		if ( 0 < $this->getVar('member_uid') ) {
			$ret['uid']      = $this->getVar('member_uid');
			$ret['uid_text'] = \XoopsUser::getUnameFromId($this->getVar('member_uid'));
		}
		$ret['submitter']   = \XoopsUser::getUnameFromId($this->getVar('member_submitter'));
        $ret['date_create'] = formatTimestamp($this->getVar('member_date_create'));

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
        $vars =& $this->getVars();
        foreach (array_keys($vars) as $var) {
            $ret[$var] = $this->getVar($var);
        }

        return $ret;
    }
}

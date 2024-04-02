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
 * @version         $Id: 1.0 relations.php 1 Sun 2015/12/27 23:18:00Z Goffy - Wedega $
 */

use XoopsModules\Wgteams;

\defined('XOOPS_ROOT_PATH') || exit('Restricted access');

/**
 * Class Object Relations
 */
class Relations extends \XoopsObject
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
        $this->initVar('rel_id', \XOBJ_DTYPE_INT);
        $this->initVar('rel_team_id', \XOBJ_DTYPE_INT);
        $this->initVar('rel_member_id', \XOBJ_DTYPE_INT);
        $this->initVar('rel_info_1_field', \XOBJ_DTYPE_INT);
        $this->initVar('rel_info_1', \XOBJ_DTYPE_TXTAREA);
        $this->initVar('rel_info_2_field', \XOBJ_DTYPE_INT);
        $this->initVar('rel_info_2', \XOBJ_DTYPE_TXTAREA);
        $this->initVar('rel_info_3_field', \XOBJ_DTYPE_INT);
        $this->initVar('rel_info_3', \XOBJ_DTYPE_TXTAREA);
        $this->initVar('rel_info_4_field', \XOBJ_DTYPE_INT);
        $this->initVar('rel_info_4', \XOBJ_DTYPE_TXTAREA);
        $this->initVar('rel_info_5_field', \XOBJ_DTYPE_INT);
        $this->initVar('rel_info_5', \XOBJ_DTYPE_TXTAREA);
        $this->initVar('rel_weight', \XOBJ_DTYPE_INT);
        $this->initVar('rel_submitter', \XOBJ_DTYPE_INT);
        $this->initVar('rel_date_create', \XOBJ_DTYPE_INT);
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
     * @param mixed $action
     * @return \XoopsThemeForm
     */
    public function getFormRelations($action = false)
    {
        global $xoopsUser;
        
        if (false === $action) {
            $action = $_SERVER['REQUEST_URI'];
        }


        $infofieldsHandler = $this->helper->getHandler('Infofields');
        $teamsHandler      = $this->helper->getHandler('Teams');
        $membersHandler    = $this->helper->getHandler('Members');
        
        // $db           = \XoopsDatabaseFactory::getDatabaseConnection();
        // $infofieldsHandler = new Wgteams\InfofieldsHandler($db);
        // $teamsHandler = new Wgteams\TeamsHandler($db);
        // $membersHandler    = new Wgteams\MembersHandler($db);

        if (0 == $infofieldsHandler->getCountInfofields()) {
            \redirect_header('infofields.php', 3, _AM_WGTEAMS_THEREARENT_INFOFIELDS);
        }
        if (0 == $teamsHandler->getCountTeams()) {
            \redirect_header('teams.php', 3, _AM_WGTEAMS_THEREARENT_TEAMS);
        }
        if (0 == $membersHandler->getCountMembers()) {
            \redirect_header('members.php', 3, _AM_WGTEAMS_THEREARENT_MEMBERS);
        }

        // Title
        $title = $this->isNew() ? \sprintf(_AM_WGTEAMS_RELATION_ADD) : \sprintf(_AM_WGTEAMS_RELATION_EDIT);
        // Get Theme Form
        \xoops_load('XoopsFormLoader');
        $form = new \XoopsThemeForm($title, 'form', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        // Form select team
        $relTeam_idSelect = new \XoopsFormSelect(_AM_WGTEAMS_RELATION_TEAM_ID, 'rel_team_id', $this->getVar('rel_team_id'));
        $relTeam_idSelect->addOptionArray($teamsHandler->getList());
        $form->addElement($relTeam_idSelect, true);
        // Form select members
        $relmember_idSelect = new \XoopsFormSelect(_AM_WGTEAMS_RELATION_MEMBER_ID, 'rel_member_id', $this->getVar('rel_member_id'));
        $membersAll         = $membersHandler->getAllMembers();
        foreach (\array_keys($membersAll) as $i) {
            $relmember_idSelect->addOption($membersAll[$i]->getVar('member_id'), $membersAll[$i]->getVar('member_firstname') . ' ' . $membersAll[$i]->getVar('member_lastname'));
        }
        $form->addElement($relmember_idSelect, true);
        // Form infofield type 1
        $rel_info_1_field      = $this->isNew() ? 0 : $this->getVar('rel_info_1_field');
        $relInfo_1_fieldSelect = new \XoopsFormSelect(_AM_WGTEAMS_RELATION_INFO_1_FIELD, 'rel_info_1_field', $rel_info_1_field);
        $relInfo_1_fieldSelect->addOption(0, '-');
        $relInfo_1_fieldSelect->addOptionArray($infofieldsHandler->getList());
        $form->addElement($relInfo_1_fieldSelect);
        // Form infofield
        $editor_configs           = [];
        $editor_configs['name']   = 'rel_info_1';
        $editor_configs['value']  = $this->getVar('rel_info_1', 'e');
        $editor_configs['rows']   = 5;
        $editor_configs['cols']   = 40;
        $editor_configs['width']  = '100%';
        $editor_configs['height'] = '200px';
        $editor_configs['editor'] = $this->helper->getConfig('wgteams_editor');
        $form->addElement(new \XoopsFormEditor(_AM_WGTEAMS_RELATION_INFO_1, 'rel_info_1', $editor_configs));

        // Form infofield type 2
        $rel_info_2_field      = $this->isNew() ? 0 : $this->getVar('rel_info_2_field');
        $relInfo_2_fieldSelect = new \XoopsFormSelect(_AM_WGTEAMS_RELATION_INFO_2_FIELD, 'rel_info_2_field', $rel_info_2_field);
        $relInfo_2_fieldSelect->addOption(0, '-');
        $relInfo_2_fieldSelect->addOptionArray($infofieldsHandler->getList());
        $form->addElement($relInfo_2_fieldSelect);
        // Form infofield 2
        $editor_configs           = [];
        $editor_configs['name']   = 'rel_info_2';
        $editor_configs['value']  = $this->getVar('rel_info_2', 'e');
        $editor_configs['rows']   = 5;
        $editor_configs['cols']   = 40;
        $editor_configs['width']  = '100%';
        $editor_configs['height'] = '200px';
        $editor_configs['editor'] = $this->helper->getConfig('wgteams_editor');
        $form->addElement(new \XoopsFormEditor(_AM_WGTEAMS_RELATION_INFO_2, 'rel_info_2', $editor_configs));

        // Form infofield type 3
        $rel_info_3_field      = $this->isNew() ? 0 : $this->getVar('rel_info_3_field');
        $relInfo_3_fieldSelect = new \XoopsFormSelect(_AM_WGTEAMS_RELATION_INFO_3_FIELD, 'rel_info_3_field', $rel_info_3_field);
        $relInfo_3_fieldSelect->addOption(0, '-');
        $relInfo_3_fieldSelect->addOptionArray($infofieldsHandler->getList());
        $form->addElement($relInfo_3_fieldSelect);
        // Form infofield 3
        $editor_configs           = [];
        $editor_configs['name']   = 'rel_info_3';
        $editor_configs['value']  = $this->getVar('rel_info_3', 'e');
        $editor_configs['rows']   = 5;
        $editor_configs['cols']   = 40;
        $editor_configs['width']  = '100%';
        $editor_configs['height'] = '200px';
        $editor_configs['editor'] = $this->helper->getConfig('wgteams_editor');
        $form->addElement(new \XoopsFormEditor(_AM_WGTEAMS_RELATION_INFO_3, 'rel_info_3', $editor_configs));

        // Form infofield type 4
        $rel_info_4_field      = $this->isNew() ? 0 : $this->getVar('rel_info_4_field');
        $relinfo_4_fieldSelect = new \XoopsFormSelect(_AM_WGTEAMS_RELATION_INFO_4_FIELD, 'rel_info_4_field', $rel_info_4_field);
        $relinfo_4_fieldSelect->addOption(0, '-');
        $relinfo_4_fieldSelect->addOptionArray($infofieldsHandler->getList());
        $form->addElement($relinfo_4_fieldSelect);
        // Form infofield 4
        $editor_configs           = [];
        $editor_configs['name']   = 'rel_info_4';
        $editor_configs['value']  = $this->getVar('rel_info_4', 'e');
        $editor_configs['rows']   = 5;
        $editor_configs['cols']   = 40;
        $editor_configs['width']  = '100%';
        $editor_configs['height'] = '200px';
        $editor_configs['editor'] = $this->helper->getConfig('wgteams_editor');
        $form->addElement(new \XoopsFormEditor(_AM_WGTEAMS_RELATION_INFO_4, 'rel_info_4', $editor_configs));

        // Form infofield type 5
        $rel_info_5_field      = $this->isNew() ? 0 : $this->getVar('rel_info_5_field');
        $relinfo_5_fieldSelect = new \XoopsFormSelect(_AM_WGTEAMS_RELATION_INFO_5_FIELD, 'rel_info_5_field', $rel_info_5_field);
        $relinfo_5_fieldSelect->addOption(0, '-');
        $relinfo_5_fieldSelect->addOptionArray($infofieldsHandler->getList());
        $form->addElement($relinfo_5_fieldSelect);
        // Form infofield 5
        $editor_configs           = [];
        $editor_configs['name']   = 'rel_info_5';
        $editor_configs['value']  = $this->getVar('rel_info_5', 'e');
        $editor_configs['rows']   = 5;
        $editor_configs['cols']   = 40;
        $editor_configs['width']  = '100%';
        $editor_configs['height'] = '200px';
        $editor_configs['editor'] = $this->helper->getConfig('wgteams_editor');
        $form->addElement(new \XoopsFormEditor(_AM_WGTEAMS_RELATION_INFO_5, 'rel_info_5', $editor_configs));

        // Form Text RelWeight
        $relWeight = $this->isNew() ? '999' : $this->getVar('rel_weight');
        $form->addElement(new \XoopsFormHidden('rel_weight', $relWeight));
        // Form Select User
        $submitter = $this->isNew() ? $xoopsUser->getVar('uid') : $this->getVar('rel_submitter');
        $form->addElement(new \XoopsFormSelectUser(_AM_WGTEAMS_SUBMITTER, 'rel_submitter', false, $submitter, 1, false));
        // Form Text Date Select
        $form->addElement(new \XoopsFormTextDateSelect(_AM_WGTEAMS_DATE_CREATE, 'rel_date_create', '', $this->getVar('rel_date_create')));
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
    public function getValuesRelations($keys = null, $format = null, $maxDepth = null)
    {
        $helper              = Helper::getInstance();
        $ret                 = $this->getValues($keys, $format, $maxDepth);
        $ret['id']           = $this->getVar('rel_id');
        $ret['team_id']      = $this->getVar('rel_team_id');
        $ret['team_name']    = $this->helper->getHandler('teams')->get($this->getVar('rel_team_id'))->getVar('team_name');
        $ret['member_id']    = $this->getVar('rel_member_id');
        $ret['member_name']  = \trim($this->helper->getHandler('members')->get($this->getVar('rel_member_id'))->getVar('member_firstname') . ' ' . $this->helper->getHandler('members')->get($this->getVar('rel_member_id'))->getVar('member_lastname'));

        $infofields = [
            'info_1_field' => 'rel_info_1_field',
            'info_2_field' => 'rel_info_2_field',
            'info_3_field' => 'rel_info_3_field',
            'info_4_field' => 'rel_info_4_field',
            'info_5_field' => 'rel_info_5_field'
        ];

        foreach ($infofields as $key => $field) {
            $fieldId = $this->getVar($field);
            $infofield = $this->helper->getHandler('infofields')->get($fieldId);
            $ret[$key] = $infofield ? $infofield->getVar('infofield_name') : '';
            $ret[substr($key, 0, -6)] = $helper::truncateHtml($this->getVar(substr($key, 0, -6), 'n'));
        }

        $ret['weight']       = $this->getVar('rel_weight');
        $ret['submitter']    = \XoopsUser::getUnameFromId($this->getVar('rel_submitter'));
        $ret['date_create']  = \formatTimestamp($this->getVar('rel_date_create'));

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

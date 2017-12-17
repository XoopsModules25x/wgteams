<?php
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
defined('XOOPS_ROOT_PATH') || exit('Restricted access');

/**
 * Class Object WgteamsRelations
 */

class WgteamsRelations extends XoopsObject
{
    /**
    * @var mixed
    */
    private $wgteams = null;

    /**
     * Constructor
     *
     * @param null
     */
    public function __construct()
    {
        $this->wgteams = WgteamsHelper::getInstance();
        $this->initVar('rel_id', XOBJ_DTYPE_INT);
        $this->initVar('rel_team_id', XOBJ_DTYPE_INT);
        $this->initVar('rel_member_id', XOBJ_DTYPE_INT);
        $this->initVar('rel_info_1_field', XOBJ_DTYPE_INT);
        $this->initVar('rel_info_1', XOBJ_DTYPE_TXTAREA);
        $this->initVar('rel_info_2_field', XOBJ_DTYPE_INT);
        $this->initVar('rel_info_2', XOBJ_DTYPE_TXTAREA);
        $this->initVar('rel_info_3_field', XOBJ_DTYPE_INT);
        $this->initVar('rel_info_3', XOBJ_DTYPE_TXTAREA);
        $this->initVar('rel_info_4_field', XOBJ_DTYPE_INT);
        $this->initVar('rel_info_4', XOBJ_DTYPE_TXTAREA);
        $this->initVar('rel_info_5_field', XOBJ_DTYPE_INT);
        $this->initVar('rel_info_5', XOBJ_DTYPE_TXTAREA);
        $this->initVar('rel_weight', XOBJ_DTYPE_INT);
        $this->initVar('rel_submitter', XOBJ_DTYPE_INT);
        $this->initVar('rel_date_create', XOBJ_DTYPE_INT);
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
     * @return XoopsThemeForm
     */
    public function getFormRelations($action = false)
    {
        global $xoopsUser;
        if (false === $action) {
            $action = $_SERVER['REQUEST_URI'];
        }

        $infofieldsHandler = $this->wgteams->getHandler('infofields');
        $teamsHandler      = $this->wgteams->getHandler('teams');
        $membersHandler    = $this->wgteams->getHandler('members');

        if (0 == $infofieldsHandler->getCountInfofields()) {
            redirect_header('infofields.php', 3, _AM_WGTEAMS_THEREARENT_INFOFIELDS);
        }
        if (0 == $teamsHandler->getCountTeams()) {
            redirect_header('teams.php', 3, _AM_WGTEAMS_THEREARENT_TEAMS);
        }
        if (0 == $membersHandler->getCountMembers()) {
            redirect_header('members.php', 3, _AM_WGTEAMS_THEREARENT_MEMBERS);
        }

        // Title
        $title = $this->isNew() ? sprintf(_AM_WGTEAMS_RELATION_ADD) : sprintf(_AM_WGTEAMS_RELATION_EDIT);
        // Get Theme Form
        xoops_load('XoopsFormLoader');
        $form = new XoopsThemeForm($title, 'form', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        // Relations handler
        //$relationsHandler = $this->wgteams->getHandler('relations');
        // Form select team
        $relTeam_idSelect = new XoopsFormSelect(_AM_WGTEAMS_RELATION_TEAM_ID, 'rel_team_id', $this->getVar('rel_team_id'));
        $relTeam_idSelect->addOptionArray($teamsHandler->getList());
        $form->addElement($relTeam_idSelect, true);
        // Form select members
        $relmember_idSelect = new XoopsFormSelect(_AM_WGTEAMS_RELATION_MEMBER_ID, 'rel_member_id', $this->getVar('rel_member_id'));
        $membersAll         = $membersHandler->getAllMembers();
        foreach (array_keys($membersAll) as $i) {
            $relmember_idSelect->addOption($membersAll[$i]->getVar('member_id'), $membersAll[$i]->getVar('member_firstname') . ' ' . $membersAll[$i]->getVar('member_lastname'));
        }
        $form->addElement($relmember_idSelect, true);
        // Form infofield type 1
        $rel_info_1_field      = $this->isNew() ? 0 : $this->getVar('rel_info_1_field');
        $relInfo_1_fieldSelect = new XoopsFormSelect(_AM_WGTEAMS_RELATION_INFO_1_FIELD, 'rel_info_1_field', $rel_info_1_field);
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
        $editor_configs['height'] = '400px';
        $editor_configs['editor'] = $this->wgteams->getConfig('wgteams_editor');
        $form->addElement(new XoopsFormEditor(_AM_WGTEAMS_RELATION_INFO_1, 'rel_info_1', $editor_configs));

        // Form infofield type 2
        $rel_info_2_field      = $this->isNew() ? 0 : $this->getVar('rel_info_2_field');
        $relInfo_2_fieldSelect = new XoopsFormSelect(_AM_WGTEAMS_RELATION_INFO_2_FIELD, 'rel_info_2_field', $rel_info_2_field);
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
        $editor_configs['height'] = '400px';
        $editor_configs['editor'] = $this->wgteams->getConfig('wgteams_editor');
        $form->addElement(new XoopsFormEditor(_AM_WGTEAMS_RELATION_INFO_2, 'rel_info_2', $editor_configs));

        // Form infofield type 3
        $rel_info_3_field      = $this->isNew() ? 0 : $this->getVar('rel_info_3_field');
        $relInfo_3_fieldSelect = new XoopsFormSelect(_AM_WGTEAMS_RELATION_INFO_3_FIELD, 'rel_info_3_field', $rel_info_3_field);
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
        $editor_configs['height'] = '400px';
        $editor_configs['editor'] = $this->wgteams->getConfig('wgteams_editor');
        $form->addElement(new XoopsFormEditor(_AM_WGTEAMS_RELATION_INFO_3, 'rel_info_3', $editor_configs));

        // Form infofield type 4
        $rel_info_4_field      = $this->isNew() ? 0 : $this->getVar('rel_info_4_field');
        $relinfo_4_fieldSelect = new XoopsFormSelect(_AM_WGTEAMS_RELATION_INFO_4_FIELD, 'rel_info_4_field', $rel_info_4_field);
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
        $editor_configs['height'] = '400px';
        $editor_configs['editor'] = $this->wgteams->getConfig('wgteams_editor');
        $form->addElement(new XoopsFormEditor(_AM_WGTEAMS_RELATION_INFO_4, 'rel_info_4', $editor_configs));

        // Form infofield type 5
        $rel_info_5_field      = $this->isNew() ? 0 : $this->getVar('rel_info_5_field');
        $relinfo_5_fieldSelect = new XoopsFormSelect(_AM_WGTEAMS_RELATION_INFO_5_FIELD, 'rel_info_5_field', $rel_info_5_field);
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
        $editor_configs['height'] = '400px';
        $editor_configs['editor'] = $this->wgteams->getConfig('wgteams_editor');
        $form->addElement(new XoopsFormEditor(_AM_WGTEAMS_RELATION_INFO_5, 'rel_info_5', $editor_configs));

        // Form Text RelWeight
        $relWeight = $this->isNew() ? '0' : $this->getVar('rel_weight');
        $form->addElement(new XoopsFormHidden('rel_weight', $relWeight));
        // Form Select User
        $submitter = $this->isNew() ? $xoopsUser->getVar('uid') : $this->getVar('rel_submitter');
        $form->addElement(new XoopsFormSelectUser(_AM_WGTEAMS_SUBMITTER, 'rel_submitter', false, $submitter, 1, false));
        // Form Text Date Select
        $form->addElement(new XoopsFormTextDateSelect(_AM_WGTEAMS_DATE_CREATE, 'rel_date_create', '', $this->getVar('rel_date_create')));
        // Send
        $form->addElement(new XoopsFormHidden('op', 'save'));
        $form->addElement(new XoopsFormButtonTray('', _SUBMIT, 'submit', '', false));

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
        $wgteams             = WgteamsHelper::getInstance();
		$ret                 = $this->getValues($keys, $format, $maxDepth);
        $ret['id']           = $this->getVar('rel_id');
        $ret['team_id']      = $this->getVar('rel_team_id');
        $ret['team_name']    = $this->wgteams->getHandler('teams')->get($this->getVar('rel_team_id'))->getVar('team_name');
        $ret['member_id']    = $this->getVar('rel_member_id');
        $ret['member_name']  = trim($this->wgteams->getHandler('members')->get($this->getVar('rel_member_id'))->getVar('member_firstname') .
                                    ' ' . $this->wgteams->getHandler('members')->get($this->getVar('rel_member_id'))->getVar('member_lastname'));
        $ret['info_1_field'] = $this->wgteams->getHandler('infofields')->get($this->getVar('rel_info_1_field'))->getVar('infofield_name');
        $ret['info_1']       = $wgteams->truncateHtml($this->getVar('rel_info_1', 'n'));
        $ret['info_2_field'] = $this->wgteams->getHandler('infofields')->get($this->getVar('rel_info_2_field'))->getVar('infofield_name');
        $ret['info_2']       = $wgteams->truncateHtml($this->getVar('rel_info_2', 'n'));
        $ret['info_3_field'] = $this->wgteams->getHandler('infofields')->get($this->getVar('rel_info_3_field'))->getVar('infofield_name');
        $ret['info_3']       = $wgteams->truncateHtml($this->getVar('rel_info_3', 'n'));
        $ret['info_4_field'] = $this->wgteams->getHandler('infofields')->get($this->getVar('rel_info_4_field'))->getVar('infofield_name');
        $ret['info_4']       = $wgteams->truncateHtml($this->getVar('rel_info_4', 'n'));
        $ret['info_5_field'] = $this->wgteams->getHandler('infofields')->get($this->getVar('rel_info_5_field'))->getVar('infofield_name');
        $ret['info_5']       = $wgteams->truncateHtml($this->getVar('rel_info_5', 'n'));
        $ret['weight']       = $this->getVar('rel_weight');
        $ret['submitter']    = XoopsUser::getUnameFromId($this->getVar('rel_submitter'));
        $ret['date_create']  = formatTimestamp($this->getVar('rel_date_create'));

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

/**
 * Class Object Handler WgteamsRelations
 */

class WgteamsRelationsHandler extends XoopsPersistableObjectHandler
{
    /**
    * @var mixed
    */
    private $wgteams = null;

    /**
     * Constructor
     *
     * @param \XoopsDatabase $db
     */
    public function __construct(XoopsDatabase $db)
    {
        parent::__construct($db, 'wgteams_relations', 'wgteamsrelations', 'rel_id', 'rel_team_id');
        $this->wgteams = WgteamsHelper::getInstance();
    }

    /**
     * @param bool $isNew
     *
     * @return XoopsObject
     */
    public function create($isNew = true)
    {
        $temp = parent::create($isNew);
        return $temp; 
    }

    /**
     * retrieve a field
     *
     * @param  int $i field id
     * @param null $fields
     * @return mixed reference to the <a href='psi_element://TDMCreateFields'>TDMCreateFields</a> object
     *                object
     */
    public function get($i = null, $fields = null)
    {
        $temp =  parent::get($i, $fields);
        return $temp;
    }

    /**
     * get inserted id
     *
     * @param null
     * @return integer reference to the {@link TDMCreateFields} object
     */
    public function getInsertId()
    {
        $temp =  $this->db->getInsertId();
        return $temp;
    }

    /**
     * get IDs of objects matching a condition
     *
     * @param  CriteriaElement $criteria {@link CriteriaElement} to match
     * @return array  of object IDs
     */
    public function &getIds(CriteriaElement $criteria = null)
    {
        $temp =&  parent::getIds($criteria);
        return $temp;
    }

    /**
     * insert a new field in the database
     *
     * @param XoopsObject $field reference to the {@link TDMCreateFields} object
     * @param bool   $force
     *
     * @return bool FALSE if failed, TRUE if already present and unchanged or successful
     */
    public function insert(XoopsObject $field, $force = false)
    {
        if (!parent::insert($field, $force)) {
            return false;
        }

        return true;
    }

    /**
     * Get Count Relations
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return int
     */
    public function getCountRelations($start = 0, $limit = 0, $sort = 'rel_id', $order = 'ASC')
    {
        $criteria = new CriteriaCompo();
        $criteria->setSort($sort);
        $criteria->setOrder($order);
        $criteria->setStart($start);
        $criteria->setLimit($limit);

        return $this->getCount($criteria);
    }
    
    /**
     * Get Count Relations per Team
     * @param int    $team_id
     * @return int
     */
    public function getCountRelationsTeam($team_id = 0)
    {
        $criteria = new CriteriaCompo();
        $criteria->add(new Criteria('rel_team_id', $team_id));

        return $this->getCount($criteria);
    }

    /**
     * Get All Relations
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return array
     */
    public function getAllRelations($start = 0, $limit = 0, $sort = 'rel_team_id ASC, rel_weight ASC, rel_id', $order = 'ASC')
    {
        $criteria = new CriteriaCompo();
        $criteria->setSort($sort);
        $criteria->setOrder($order);
        $criteria->setStart($start);
        $criteria->setLimit($limit);

        return $this->getAll($criteria);
    }
}

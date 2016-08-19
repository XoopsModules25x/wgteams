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
 * @copyright       The XOOPS Project (http://xoops.org)
 * @license         GPL 2.0 or later
 * @package         wgteams
 * @since           1.0
 * @min_xoops       2.5.7
 * @author          Goffy - Wedega.com - Email:<webmaster@wedega.com> - Website:<http://wedega.com>
 * @version         $Id: 1.0 teams.php 1 Sun 2015/12/27 23:18:00Z Goffy - Wedega $
 */
defined('XOOPS_ROOT_PATH') || exit('Restricted access');

/**
 * Class Object WgteamsTeams
 */

class WgteamsTeams extends XoopsObject
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
        $this->initVar('team_id', XOBJ_DTYPE_INT);
        $this->initVar('team_name', XOBJ_DTYPE_TXTBOX);
        $this->initVar('team_descr', XOBJ_DTYPE_TXTAREA);
        $this->initVar('team_image', XOBJ_DTYPE_TXTBOX);
        $this->initVar('team_nb_cols', XOBJ_DTYPE_INT);
        $this->initVar('team_tablestyle', XOBJ_DTYPE_TXTBOX);
        $this->initVar('team_imagestyle', XOBJ_DTYPE_TXTBOX);
        $this->initVar('team_displaystyle', XOBJ_DTYPE_TXTBOX);
        $this->initVar('team_weight', XOBJ_DTYPE_INT);
        $this->initVar('team_online', XOBJ_DTYPE_INT);
        $this->initVar('team_submitter', XOBJ_DTYPE_INT);
        $this->initVar('team_date_create', XOBJ_DTYPE_INT);
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
    public function getFormTeams($action = false)
    {
        global $xoopsUser;
        
        if ($action === false) {
            $action = $_SERVER['REQUEST_URI'];
        }
        // Title
        $title = $this->isNew() ? sprintf(_AM_WGTEAMS_TEAM_ADD) : sprintf(_AM_WGTEAMS_TEAM_EDIT);
        // Get Theme Form
        xoops_load('XoopsFormLoader');
        $form = new XoopsThemeForm($title, 'form', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        // Teams handler
        //$teamsHandler = $this->wgteams->getHandler('teams');
        // Form Text TeamName
        $form->addElement(new XoopsFormText(_AM_WGTEAMS_TEAM_NAME, 'team_name', 50, 255, $this->getVar('team_name')), true);
        // Form Text Area team_descr
        $editor_configs = array();
        $editor_configs['name']   = 'team_descr';
        $editor_configs['value']  = $this->getVar('team_descr', 'e');
        $editor_configs['rows']   = 5;
        $editor_configs['cols']   = 40;
        $editor_configs['width']  = '100%';
        $editor_configs['height'] = '400px';
        $editor_configs['editor'] = $this->wgteams->getConfig('wgteams_editor');
        $form->addElement(new XoopsFormEditor(_AM_WGTEAMS_TEAM_DESCR, 'team_descr', $editor_configs));
        // Form Upload Image
        $getTeamImage   = $this->getVar('team_image');
        $teamImage      = $getTeamImage ?: 'blank.gif';
        $imageDirectory = '/uploads/wgteams/teams/images';
        //
        $imageTray   = new XoopsFormElementTray(_AM_WGTEAMS_TEAM_IMAGE, '<br>');
        $imageSelect = new XoopsFormSelect(_AM_WGTEAMS_FORM_IMAGE_EXIST, 'team_image', $teamImage, 5);
        $imageArray  = XoopsLists::getImgListAsArray(XOOPS_ROOT_PATH . $imageDirectory);
        foreach ($imageArray as $image) {
            $imageSelect->addOption("{$image}", $image);
        }
        $imageSelect->setExtra("onchange='showImgSelected(\"image2\", \"team_image\", \"".$imageDirectory."\", \"\", \"".XOOPS_URL."\")'");
        $imageTray->addElement($imageSelect, false);
        $imageTray->addElement(new XoopsFormLabel('', "<br><img src='".XOOPS_URL . '/' . $imageDirectory . '/' . $teamImage . "' name='image2' id='image2' alt='' style='max-width:100px;' />"));
        // Form File
        $fileSelectTray = new XoopsFormElementTray('', '<br>');
        $fileSelectTray->addElement(new XoopsFormFile(_AM_WGTEAMS_FORM_UPLOAD_IMG, 'attachedfile', $this->wgteams->getConfig('wgteams_img_maxsize')));
        $fileSelectTray->addElement(new XoopsFormLabel(_AM_WGTEAMS_MAX_FILESIZE .  $this->wgteams->getConfig('wgteams_img_maxsize')));
        $imageTray->addElement($fileSelectTray);
        $form->addElement($imageTray);
        // Form Text TeamNb_cols
        $teamNb_cols = $this->isNew() ? 2 : $this->getVar('team_nb_cols');
        $team_nb_colsSelect = new XoopsFormSelect(_AM_WGTEAMS_TEAM_NB_COLS, 'team_nb_cols', $teamNb_cols);
        $team_nb_colsSelect->addOption(1, '  1  ');
        $team_nb_colsSelect->addOption(2, '  2  ');
        $team_nb_colsSelect->addOption(3, '  3  ');
        $team_nb_colsSelect->addOption(4, '  4  ');
        $form->addElement($team_nb_colsSelect, false);
        // Form Text TeamTabletype
        $team_tablestyle = $this->isNew() ? 'default' : $this->getVar('team_tablestyle');
        $team_tablestyleSel = new XoopsFormSelect(_AM_WGTEAMS_TEAM_TABLESTYLE, 'team_tablestyle', $team_tablestyle);
        $team_tablestyleSel->addOption('default', _AM_WGTEAMS_TEAM_TABLESTYLE_DEF);
        $team_tablestyleSel->addOption('wgteams-bordered', _AM_WGTEAMS_TEAM_TABLESTYLE_BORDERED);
        $team_tablestyleSel->addOption('wgteams-striped', _AM_WGTEAMS_TEAM_TABLESTYLE_STRIPED);
        $team_tablestyleSel->addOption('wgteams-lined', _AM_WGTEAMS_TEAM_TABLESTYLE_LINED);
        $form->addElement($team_tablestyleSel, false);
        // Form Text TeamImagetype
        $team_imagestyle = $this->isNew() ? 'default' : $this->getVar('team_imagestyle');
        $team_imagestyleSel = new XoopsFormSelect(_AM_WGTEAMS_TEAM_IMAGESTYLE, 'team_imagestyle', $team_imagestyle);
        $team_imagestyleSel->addOption('default', _AM_WGTEAMS_TEAM_IMAGESTYLE_DEF);
        $team_imagestyleSel->addOption('img-circle', _AM_WGTEAMS_TEAM_IMAGESTYLE_CIRCLE);
        $team_imagestyleSel->addOption('img-rounded', _AM_WGTEAMS_TEAM_IMAGESTYLE_ROUNDED);
        $team_imagestyleSel->addOption('img-thumbnail', _AM_WGTEAMS_TEAM_IMAGESTYLE_THUMBNAIL);
        $form->addElement($team_imagestyleSel, false);
        // Form Text Teamdisplaystyle
        $team_displaystyle = $this->isNew() ? 'default' : $this->getVar('team_displaystyle');
        $team_displaystyleSel = new XoopsFormSelect(_AM_WGTEAMS_TEAM_DISPLAYSTYLE, 'team_displaystyle', $team_displaystyle);
        $team_displaystyleSel->addOption('left', _AM_WGTEAMS_TEAM_DISPLAYSTYLE_LEFT);
        $team_displaystyleSel->addOption('default', _AM_WGTEAMS_TEAM_DISPLAYSTYLE_DEF);
        $team_displaystyleSel->addOption('right', _AM_WGTEAMS_TEAM_DISPLAYSTYLE_RIGHT);
        $form->addElement($team_displaystyleSel, false);
        // Form Text TeamWeight
        $teamWeight = $this->isNew() ? '0' : $this->getVar('team_weight');
        $form->addElement(new XoopsFormHidden('team_weight', $teamWeight));
        // Form Radio Yes/No
        $teamOnline = $this->isNew() ? 0 : $this->getVar('team_online');
        $form->addElement(new XoopsFormRadioYN(_AM_WGTEAMS_TEAM_ONLINE, 'team_online', $teamOnline));
        // Form Select User
        $submitter = $this->isNew() ? $xoopsUser->getVar('uid') : $this->getVar('team_submitter');
        $form->addElement(new XoopsFormSelectUser(_AM_WGTEAMS_SUBMITTER, 'team_submitter', false, $submitter, 1, false));
        // Form Text Date Select
        $form->addElement(new XoopsFormTextDateSelect(_AM_WGTEAMS_DATE_CREATE, 'team_date_create', '', $this->getVar('team_date_create')));
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
    public function getValuesTeams($keys = null, $format = null, $maxDepth = null)
    {
        $ret                  = $this->getValues($keys, $format, $maxDepth);
        $ret['id']            = $this->getVar('team_id');
        $ret['name']          = strip_tags($this->getVar('team_name'));
        $ret['descr']         = strip_tags($this->getVar('team_descr'));
        $ret['image']         = $this->getVar('team_image');
        $ret['nb_cols']       = $this->getVar('team_nb_cols');
        $ret['tablestyle']    = $this->getVar('team_tablestyle');
        $ret['imagestyle']    = $this->getVar('team_imagestyle');
        $ret['displaystyle']  = $this->getVar('team_displaystyle');
        $ret['weight']        = $this->getVar('team_weight');
        $ret['online']        = $this->getVar('team_online') == 1 ? _YES : _NO;
        $ret['submitter']     = XoopsUser::getUnameFromId($this->getVar('team_submitter'));
        $ret['date_create']   = formatTimestamp($this->getVar('team_date_create'), 'M');

        return $ret;
    }

    /**
     * Returns an array representation of the object
     *
     * @return array
     **/
    public function toArray()
    {
        $ret = array();
        $vars =& $this->getVars();
        foreach (array_keys($vars) as $var) {
            $ret[$var] = $this->getVar($var);
        }

        return $ret;
    }
}

/**
 * Class Object Handler WgteamsTeams
 */

class WgteamsTeamsHandler extends XoopsPersistableObjectHandler
{
    /**
    * @var mixed
    */
    private $wgteams = null;

    /**
     * Constructor
     *
     * @param string $db
     */
    public function __construct(&$db)
    {
        parent::__construct($db, 'wgteams_teams', 'wgteamsteams', 'team_id', 'team_name');
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
        $temp = parent::get($i, $fields);
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
    public function insert(XoopsObject  $field, $force = false)
    {
        if (!parent::insert($field, $force)) {
            return false;
        }

        return true;
    }

    /**
     * Get Count Teams
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return int
     */
    public function getCountTeams($start = 0, $limit = 0, $sort = 'team_id', $order = 'ASC')
    {
        $criteria = new CriteriaCompo();
        $criteria->setSort($sort);
        $criteria->setOrder($order);
        $criteria->setStart($start);
        $criteria->setLimit($limit);

        return $this->getCount($criteria);
    }

    /**
     * Get All Teams
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return
     */
    public function getAllTeams($start = 0, $limit = 0, $sort = 'team_weight ASC, team_id', $order = 'ASC')
    {
        $criteria = new CriteriaCompo();
        $criteria->setSort($sort);
        $criteria->setOrder($order);
        $criteria->setStart($start);
        $criteria->setLimit($limit);

        return $this->getAll($criteria);
    }
}

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
 * @version         $Id: 1.0 infofields.php 1 Sun 2015/12/27 23:18:00Z Goffy - Wedega $
 */
defined('XOOPS_ROOT_PATH') || exit('Restricted access');


/**
 * Class WgteamsInfofields
 */
class WgteamsInfofields extends XoopsObject
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
        $this->initVar('infofield_id', XOBJ_DTYPE_INT);
        $this->initVar('infofield_name', XOBJ_DTYPE_TXTBOX);
        $this->initVar('infofield_submitter', XOBJ_DTYPE_INT);
        $this->initVar('infofield_date_created', XOBJ_DTYPE_INT);
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
     * @return XoopsThemeForm
     */
    public function getFormInfofields($action = false)
    {
        global $xoopsUser;

        if ($action === false) {
            $action = $_SERVER['REQUEST_URI'];
        }

        // Title
        $title = $this->isNew() ? sprintf(_AM_WGTEAMS_INFOFIELD_ADD) : sprintf(_AM_WGTEAMS_INFOFIELD_EDIT);
        // Get Theme Form
        xoops_load('XoopsFormLoader');
        $form = new XoopsThemeForm($title, 'form', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        // Infofields handler
        //$infofieldsHandler = $this->wgteams->getHandler('infofields');
        // Form Text AddField_name
        $form->addElement(new XoopsFormText(_AM_WGTEAMS_INFOFIELD_NAME, 'infofield_name', 50, 255, $this->getVar('infofield_name')), true);
        // Form Select User
        $submitter = $this->isNew() ? $xoopsUser->getVar('uid') : $this->getVar('infofield_submitter');
        $form->addElement(new XoopsFormSelectUser(_AM_WGTEAMS_SUBMITTER, 'infofield_submitter', false, $submitter, 1, false));
        // Form Text Date Select
        $form->addElement(new XoopsFormTextDateSelect(_AM_WGTEAMS_DATE_CREATE, 'infofield_date_created', '', $this->getVar('infofield_date_created')));
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
    public function getValuesInfofields($keys = null, $format = null, $maxDepth = null)
    {
        $ret                       = $this->getValues($keys, $format, $maxDepth);
        $ret['field_id']           = $this->getVar('infofield_id');
        $ret['field_name']         = $this->getVar('infofield_name');
        $ret['field_submitter']    = XoopsUser::getUnameFromId($this->getVar('infofield_submitter'));
        $ret['field_date_created'] = formatTimestamp($this->getVar('infofield_date_created'));

        return $ret;
    }

    /**
     * Returns an array representation of the object
     *
     * @return array
     **/
    public function toArray()
    {
        $ret  = array();
        $vars =& $this->getVars();
        foreach (array_keys($vars) as $var) {
            $ret[$var] = $this->getVar($var);
        }

        return $ret;
    }
}

/**
 * Class WgteamsInfofieldsHandler
 */
class WgteamsInfofieldsHandler extends XoopsPersistableObjectHandler
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
    public function __construct($db)
    {
        parent::__construct($db, 'wgteams_infofields', 'wgteamsinfofields', 'infofield_id', 'infofield_name');
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
        $temp = $this->db->getInsertId();
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
     * Get Count Infofields
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return int
     */
    public function getCountInfofields($start = 0, $limit = 0, $sort = 'infofield_id ASC, infofield_name', $order = 'ASC')
    {
        $criteria = new CriteriaCompo();
        $criteria->setSort($sort);
        $criteria->setOrder($order);
        $criteria->setStart($start);
        $criteria->setLimit($limit);

        return $this->getCount($criteria);
    }

    /**
     * Get All Infofields
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return
     */
    public function getAllInfofields($start = 0, $limit = 0, $sort = 'infofield_id ASC, infofield_name', $order = 'ASC')
    {
        $criteria = new CriteriaCompo();
        $criteria->setSort($sort);
        $criteria->setOrder($order);
        $criteria->setStart($start);
        $criteria->setLimit($limit);

        return $this->getAll($criteria);
    }
}

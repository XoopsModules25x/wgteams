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

\defined('XOOPS_ROOT_PATH') || die('Restricted access');

/**
 * Class MembersHandler
 */
class MembersHandler extends \XoopsPersistableObjectHandler
{
    /**
     * @var mixed
     */
    private $helper = null;

    /**
     * Constructor
     *
     * @param \XoopsDatabase $db
     */
    public function __construct(\XoopsDatabase $db)
    {
        parent::__construct($db, 'wgteams_members', Members::class, 'member_id', 'member_firstname');
        /** @var \XoopsModules\Wgteams\Helper $this ->helper */
        $this->helper = \XoopsModules\Wgteams\Helper::getInstance();
    }

    /**
     * @param bool $isNew
     *
     * @return \XoopsObject
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
     * @return int reference to the {@link TDMCreateFields} object
     */
    public function getInsertId()
    {
        $temp = $this->db->getInsertId();

        return $temp;
    }

    /**
     * get IDs of objects matching a condition
     *
     * @param \CriteriaElement $criteria {@link CriteriaElement}
     *                                   to match
     * @return array  of object IDs
     */
    public function &getIds(\CriteriaElement $criteria = null)
    {
        $temp = &parent::getIds($criteria);

        return $temp;
    }

    /**
     * insert a new field in the database
     *
     * @param \XoopsObject $field reference to the {@link TDMCreateFields}
     *                            object
     * @param bool         $force
     *
     * @return bool FALSE if failed, TRUE if already present and unchanged or successful
     */
    public function insert(\XoopsObject $field, $force = false)
    {
        if (!parent::insert($field, $force)) {
            return false;
        }

        return true;
    }

    /**
     * Get Count members
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return int
     */
    public function getCountMembers($start = 0, $limit = 0, $sort = 'member_id ASC, member_firstname', $order = 'ASC')
    {
        $criteria = new \CriteriaCompo();
        $criteria->setSort($sort);
        $criteria->setOrder($order);
        $criteria->setStart($start);
        $criteria->setLimit($limit);

        return $this->getCount($criteria);
    }

    /**
     * Get All members
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return array
     */
    public function getAllMembers($start = 0, $limit = 0, $sort = 'member_id ASC, member_firstname', $order = 'ASC')
    {
        $criteria = new \CriteriaCompo();
        $criteria->setSort($sort);
        $criteria->setOrder($order);
        $criteria->setStart($start);
        $criteria->setLimit($limit);

        return $this->getAll($criteria);
    }
}

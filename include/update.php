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
 * @version         $Id: 1.0 update.php 1 Wed 2016/01/27 16:54:11Z Goffy - Wedega $
 * @param mixed      $module
 * @param null|mixed $prev_version
 */
/**
 * @param      $module
 * @param null $prev_version
 *
 * @return bool|null
 */
function xoops_module_update_wgteams(&$module, $prev_version = null)
{
    // irmtfan bug fix: solve templates duplicate issue
    $ret = null;
    if ($prev_version < 10) {
        $ret = update_wgteams_v10($module);
    }
    $errors = $module->getErrors();
    if (!empty($errors)) {
        print_r($errors);
    }

    // maintenance of tables
    $ret = maintaintables($module);

    return $ret;
}

// irmtfan bug fix: solve templates duplicate issue
/**
 * @param $module
 *
 * @return bool
 */
function update_wgteams_v10(&$module)
{
    global $xoopsDB;
    $result = $xoopsDB->query('SELECT t1.tpl_id FROM '
                              . $GLOBALS['xoopsDB']->prefix('tplfile')
                              . ' t1, '
                              . $GLOBALS['xoopsDB']->prefix('tplfile')
                              . ' t2 WHERE t1.tpl_refid = t2.tpl_refid AND t1.tpl_module = t2.tpl_module AND t1.tpl_tplset=t2.tpl_tplset AND t1.tpl_file = t2.tpl_file AND t1.tpl_type = t2.tpl_type AND t1.tpl_id > t2.tpl_id');
    $tplids = [];
    while (false !== (list($tplid) = $xoopsDB->fetchRow($result))) {
        $tplids[] = $tplid;
    }
    if (count($tplids) > 0) {
        $tplfileHandler  = xoops_getHandler('tplfile');
        $duplicate_files = $tplfileHandler->getObjects(new \Criteria('tpl_id', '(' . implode(',', $tplids) . ')', 'IN'));

        if (count($duplicate_files) > 0) {
            foreach (array_keys($duplicate_files) as $i) {
                $tplfileHandler->delete($duplicate_files[$i]);
            }
        }
    }
    $sql = 'SHOW INDEX FROM ' . $xoopsDB->prefix('tplfile') . " WHERE KEY_NAME = 'tpl_refid_module_set_file_type'";
    if (!$result = $xoopsDB->queryF($sql)) {
        xoops_error($this->db->error() . '<br>' . $sql);

        return false;
    }
    $ret = [];
    while (false !== ($myrow = $xoopsDB->fetchArray($result))) {
        $ret[] = $myrow;
    }
    if (!empty($ret)) {
        $module->setErrors("'tpl_refid_module_set_file_type' unique index is exist. Note: check 'tplfile' table to be sure this index is UNIQUE because XOOPS CORE need it.");

        return true;
    }
    $sql = 'ALTER TABLE ' . $xoopsDB->prefix('tplfile') . ' ADD UNIQUE tpl_refid_module_set_file_type ( tpl_refid, tpl_module, tpl_tplset, tpl_file, tpl_type )';
    if (!$result = $xoopsDB->queryF($sql)) {
        xoops_error($xoopsDB->error() . '<br>' . $sql);
        $module->setErrors("'tpl_refid_module_set_file_type' unique index is not added to 'tplfile' table. Warning: do not use XOOPS until you add this unique index.");

        return false;
    }

    return true;
}

// irmtfan bug fix: solve templates duplicate issue

/**
 * repair errors in data (caused by former versions of wgteams)
 * @param mixed $module
 * @return bool
 */
function maintaintables(&$module)
{
    global $xoopsDB;
    $sql = 'DELETE '
           . $xoopsDB->prefix('wgteams_relations')
           . '.* FROM '
           . $xoopsDB->prefix('wgteams_relations')
           . ' LEFT JOIN '
           . $xoopsDB->prefix('wgteams_members')
           . ' ON '
           . $xoopsDB->prefix('wgteams_relations')
           . '.rel_member_id = '
           . $xoopsDB->prefix('wgteams_members')
           . '.member_id WHERE ((('
           . $xoopsDB->prefix('wgteams_members')
           . '.member_id) Is Null));';
    if (!$result = $xoopsDB->queryF($sql)) {
        xoops_error($xoopsDB->error() . '<br>' . $sql);
        $module->setErrors("Error maintain table 'wgteams_relations' concerning members");

        return false;
    }
    $sql = 'DELETE '
           . $xoopsDB->prefix('wgteams_relations')
           . '.* FROM '
           . $xoopsDB->prefix('wgteams_relations')
           . ' LEFT JOIN '
           . $xoopsDB->prefix('wgteams_teams')
           . ' ON '
           . $xoopsDB->prefix('wgteams_relations')
           . '.rel_team_id = '
           . $xoopsDB->prefix('wgteams_teams')
           . '.team_id WHERE ((('
           . $xoopsDB->prefix('wgteams_teams')
           . '.team_id) Is Null));';
    if (!$result = $xoopsDB->queryF($sql)) {
        xoops_error($xoopsDB->error() . '<br>' . $sql);
        $module->setErrors("Error maintain table 'wgteams_relations' concerning teams");

        return false;
    }

    return true;
}

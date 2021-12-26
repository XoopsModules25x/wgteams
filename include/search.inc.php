<?php

declare(strict_types=1);

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
 * @version         $Id: 1.0 search.inc.php 1 Sun 2015/12/27 23:18:01Z Goffy - Wedega $
 * @param $queryarray
 * @param $andor
 * @param $limit
 * @param $offset
 * @param $userid
 */

// search callback functions
function wgteams_search($queryarray, $andor, $limit, $offset, $userid)
{
    global $xoopsDB;
    $sql = "SELECT 'infofield_id', 'infofield_name' FROM " . $xoopsDB->prefix('wgteams_infofields') . ' WHERE infofield_id != 0';
    if (0 != $userid) {
        $sql .= ' AND infofield_submitter=' . (int)$userid;
    }
    if (is_array($queryarray) && $count = count($queryarray)) {
        $sql .= " AND ((a LIKE %$queryarray[0]%)";
        for ($i = 1; $i < $count; ++$i) {
            $sql .= " $andor ";
            $sql .= "(a LIKE %$queryarray[0]%)";
        }
        $sql .= ')';
    }
    $sql    .= " ORDER BY 'infofield_id' DESC";
    $result = $xoopsDB->query($sql, $limit, $offset);
    $ret    = [];
    $i      = 0;
    while (false !== ($myrow = $xoopsDB->fetchArray($result))) {
        $ret[$i]['image'] = 'assets/icons/32/blank.gif';
        $ret[$i]['link']  = 'infofields.php?infofield_id=' . $myrow['infofield_id'];
        $ret[$i]['title'] = $myrow['infofield_name'];
        ++$i;
    }
    unset($i);
}

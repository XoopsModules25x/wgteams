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
 * @author          Goffy - Wedega.com - Email:<webmaster@wedega.com> - Website:<http://wedega.com>
 * @version         $Id: 1.0 index.php 1 Sun 2015/12/27 23:18:01Z Goffy - Wedega $
 */
include __DIR__ . '/header.php';
// Count elements
$countTeams      = $teamsHandler->getCountTeams();
$countMembers    = $membersHandler->getCountMembers();
$countInfofields = $infofieldsHandler->getCountInfofields();
$countRelations  = $relationsHandler->getCountRelations();
// Template Index
$templateMain = 'wgteams_admin_index.tpl';
// InfoBox Statistics
$adminMenu->addInfoBox(_AM_WGTEAMS_STATISTICS);
// Info elements
$adminMenu->addInfoBoxLine(_AM_WGTEAMS_STATISTICS, '<label>' . _AM_WGTEAMS_THEREARE_TEAMS . '</label>', $countTeams);
$adminMenu->addInfoBoxLine(_AM_WGTEAMS_STATISTICS, '<label>' . _AM_WGTEAMS_THEREARE_MEMBERS . '</label>', $countMembers);
$adminMenu->addInfoBoxLine(_AM_WGTEAMS_STATISTICS, '<label>' . _AM_WGTEAMS_THEREARE_INFOFIELDS . '</label>', $countInfofields);
$adminMenu->addInfoBoxLine(_AM_WGTEAMS_STATISTICS, '<label>' . _AM_WGTEAMS_THEREARE_RELATIONS . '</label>', $countRelations);
// Upload Folders
$folder = array(
    WGTEAMS_UPLOAD_PATH . '/teams/',
    WGTEAMS_UPLOAD_PATH . '/members/');
// Uploads Folders Created
foreach (array_keys($folder) as $i) {
    $adminMenu->addConfigBoxLine($folder[$i], 'folder');
    $adminMenu->addConfigBoxLine(array($folder[$i], '777'), 'chmod');
}
// Render Index
echo $adminMenu->addNavigation('index.php');
echo $adminMenu->renderIndex();
include __DIR__ . '/footer.php';

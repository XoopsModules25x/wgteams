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
 * @version         $Id: 1.0 index.php 1 Sun 2015/12/27 23:18:01Z Goffy - Wedega $
 */
require __DIR__ . '/header.php';

$moduleDirName = basename(dirname(__DIR__));
$moduleDirNameUpper = mb_strtoupper($moduleDirName);

$utility      = new \XoopsModules\Wgteams\Utility();
$moduleHandler           = xoops_getHandler('module');
$module                  = $moduleHandler->getByDirname('wgteams');

echo "  - checkVerXoops:".$utility::checkVerXoops($module);



// Count elements
$countTeams      = $teamsHandler->getCountTeams();
$countMembers    = $membersHandler->getCountMembers();
$countInfofields = $infofieldsHandler->getCountInfofields();
$countRelations  = $relationsHandler->getCountRelations();
// Template Index
$templateMain = 'wgteams_admin_index.tpl';
// InfoBox Statistics
$adminObject->addInfoBox(_AM_WGTEAMS_STATISTICS);
// Info elements
$adminObject->addInfoBoxLine(sprintf('<label>' . _AM_WGTEAMS_THEREARE_TEAMS . '</label>', $countTeams), '');
$adminObject->addInfoBoxLine(sprintf('<label>' . _AM_WGTEAMS_THEREARE_MEMBERS . '</label>', $countMembers), '');
$adminObject->addInfoBoxLine(sprintf('<label>' . _AM_WGTEAMS_THEREARE_INFOFIELDS . '</label>', $countInfofields), '');
$adminObject->addInfoBoxLine(sprintf('<label>' . _AM_WGTEAMS_THEREARE_RELATIONS . '</label>', $countRelations), '');
// Upload Folders
$folder = [
    WGTEAMS_UPLOAD_PATH . '/teams/',
    WGTEAMS_UPLOAD_PATH . '/members/',
];
// Uploads Folders Created
foreach (array_keys($folder) as $i) {
    $adminObject->addConfigBoxLine($folder[$i], 'folder');
    $adminObject->addConfigBoxLine([$folder[$i], '777'], 'chmod');
}
// Render Index
$adminObject->displayNavigation(basename(__FILE__));
//------------- Test Data ----------------------------
if ($helper->getConfig('displaySampleButton')) {
    xoops_loadLanguage('admin/modulesadmin', 'system');
    require  dirname(__DIR__) . '/testdata/index.php';
    $adminObject->addItemButton(constant('CO_' . $moduleDirNameUpper . '_' . 'ADD_SAMPLEDATA'), '__DIR__ . /../../testdata/index.php?op=load', 'add');
    $adminObject->addItemButton(constant('CO_' . $moduleDirNameUpper . '_' . 'SAVE_SAMPLEDATA'), '__DIR__ . /../../testdata/index.php?op=save', 'add');
    //    $adminObject->addItemButton(constant('CO_' . $moduleDirNameUpper . '_' . 'EXPORT_SCHEMA'), '__DIR__ . /../../testdata/index.php?op=exportschema', 'add');
    $adminObject->displayButton('left', '');
}
//------------- End Test Data ----------------------------
$adminObject->displayIndex();

require __DIR__ . '/footer.php';

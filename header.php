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
 * @version         $Id: 1.0 header.php 1 Sun 2015/12/27 23:18:01Z Goffy - Wedega $
 */
include dirname(dirname(__DIR__)) . '/mainfile.php';
include __DIR__ . '/include/common.php';
$dirname = basename(__DIR__);
// Breadcrumbs
$xoBreadcrumbs   = array();
$xoBreadcrumbs[] = array('title' => $GLOBALS['xoopsModule']->getVar('name'), 'link' => WGTEAMS_URL . '/');
// Get instance of module
$wgteams           =& WgteamsHelper::getInstance();
$teamsHandler      =& $wgteams->getHandler('teams');
$membersHandler    =& $wgteams->getHandler('members');
$relationsHandler  =& $wgteams->getHandler('relations');
$infofieldsHandler =& $wgteams->getHandler('infofields');
// Permission
include_once XOOPS_ROOT_PATH . '/class/xoopsform/grouppermform.php';
$gperm_handler = xoops_getHandler('groupperm');
$groups        = XOOPS_GROUP_ANONYMOUS;
if (is_object($xoopsUser)) {
    $groups = $xoopsUser->getGroups();
}
//
$myts = MyTextSanitizer::getInstance();
if (!file_exists($style = WGTEAMS_URL . '/assets/css/style.css')) {
    return false;
}
//
$sysPathIcon16   = $GLOBALS['xoopsModule']->getInfo('sysicons16');
$sysPathIcon32   = $GLOBALS['xoopsModule']->getInfo('sysicons32');
$pathModuleAdmin = $GLOBALS['xoopsModule']->getInfo('dirmoduleadmin');
//
$modPathIcon16 = $xoopsModule->getInfo('modicons16');
$modPathIcon32 = $xoopsModule->getInfo('modicons32');
//
xoops_loadLanguage('modinfo', $dirname);
xoops_loadLanguage('main', $dirname);

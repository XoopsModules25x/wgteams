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
 * @version         $Id: 1.0 header.php 1 Sun 2015/12/27 23:18:01Z Goffy - Wedega $
 */
 
use XoopsModules\Wgteams\Helper;

include dirname(dirname(__DIR__)) . '/mainfile.php';
include __DIR__ . '/include/common.php';
$dirname = basename(__DIR__);
// Breadcrumbs
$xoBreadcrumbs   = [];
$xoBreadcrumbs[] = ['title' => $GLOBALS['xoopsModule']->getVar('name'), 'link' => WGTEAMS_URL . '/'];
// Get instance of module
$helper 		   = Helper::getInstance();
$teamsHandler      = $helper->getHandler('teams');
$membersHandler    = $helper->getHandler('members');
$relationsHandler  = $helper->getHandler('relations');
$infofieldsHandler = $helper->getHandler('infofields');
// Permission
include_once XOOPS_ROOT_PATH . '/class/xoopsform/grouppermform.php';
$gperm_handler = xoops_getHandler('groupperm');
if (is_object($xoopsUser)) {
    $groups = $xoopsUser->getGroups();
} else {
    $groups = XOOPS_GROUP_ANONYMOUS;
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

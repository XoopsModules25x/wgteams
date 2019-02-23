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
 * @version         $Id: 1.0 menu.php 1 Sun 2015/12/27 23:18:01Z Goffy - Wedega $
 */
$dirname                = basename(dirname(__DIR__));
$moduleHandler          = xoops_getHandler('module');
$xoopsModule            = \XoopsModule::getByDirname($dirname);
$moduleInfo             = $moduleHandler->get($xoopsModule->getVar('mid'));
$sysPathIcon32          = $moduleInfo->getInfo('sysicons32');
$i                      = 1;
$adminmenu[$i]['title'] = _MI_WGTEAMS_ADMENU1;
$adminmenu[$i]['link']  = 'admin/index.php';
$adminmenu[$i]['icon']  = $sysPathIcon32 . '/dashboard.png';
++$i;
$adminmenu[$i]['title'] = _MI_WGTEAMS_ADMENU2;
$adminmenu[$i]['link']  = 'admin/infofields.php';
$adminmenu[$i]['icon']  = 'assets/icons/32/infofields.png';
++$i;
$adminmenu[$i]['title'] = _MI_WGTEAMS_ADMENU3;
$adminmenu[$i]['link']  = 'admin/teams.php';
$adminmenu[$i]['icon']  = 'assets/icons/32/teams.png';
++$i;
$adminmenu[$i]['title'] = _MI_WGTEAMS_ADMENU4;
$adminmenu[$i]['link']  = 'admin/members.php';
$adminmenu[$i]['icon']  = 'assets/icons/32/members.png';
++$i;
$adminmenu[$i]['title'] = _MI_WGTEAMS_ADMENU5;
$adminmenu[$i]['link']  = 'admin/relations.php';
$adminmenu[$i]['icon']  = 'assets/icons/32/relations.png';
++$i;
$adminmenu[$i]['title'] = _MI_WGTEAMS_ABOUT;
$adminmenu[$i]['link']  = 'admin/about.php';
$adminmenu[$i]['icon']  = $sysPathIcon32 . '/about.png';
unset($i);

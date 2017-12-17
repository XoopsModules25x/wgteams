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
 * @version         $Id: 1.0 about.php 1 Sun 2015/12/27 23:18:01Z Goffy - Wedega $
 */
include __DIR__ .'/header.php';
$templateMain = 'wgteams_admin_about.tpl';
$GLOBALS['xoopsTpl']->assign('navigation', $adminMenu->addNavigation('about.php'));
$GLOBALS['xoopsTpl']->assign('about', $adminMenu->renderAbout('', false));
include __DIR__ .'/footer.php';

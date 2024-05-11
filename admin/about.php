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
 * @author          Goffy - Wedega.com - Email:<webmaster@wedega.com> - Website:<https://wedega.com>
 */
require __DIR__ . '/header.php';
$templateMain = 'wgteams_admin_about.tpl';
$GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('about.php'));
$GLOBALS['xoopsTpl']->assign('about', $adminObject->displayAbout('', false));
require __DIR__ . '/footer.php';

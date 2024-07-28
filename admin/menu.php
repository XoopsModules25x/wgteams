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

use XoopsModules\Wgteams;

$helper = Wgteams\Helper::getInstance();

$pathIcon32 = \Xmf\Module\Admin::menuIconPath('');
if (\is_object($helper->getModule())) {
    $pathModIcon32 = $helper->getModule()->getInfo('modicons32');
}
$adminmenu[] = [
    'title' => _MI_WGTEAMS_ADMENU1,
    'link'  => 'admin/index.php',
    'icon'  => 'assets/icons/32/dashboard.png'
];
$adminmenu[] = [
    'title' => _MI_WGTEAMS_ADMENU2,
    'link'  => 'admin/infofields.php',
    'icon'  => 'assets/icons/32/infofields.png'
];
$adminmenu[] = [
    'title' => _MI_WGTEAMS_ADMENU3,
    'link'  => 'admin/teams.php',
    'icon'  => 'assets/icons/32/teams.png'
];
$adminmenu[] = [
    'title' => _MI_WGTEAMS_ADMENU4,
    'link'  => 'admin/members.php',
    'icon'  => 'assets/icons/32/members.png'
];
$adminmenu[] = [
    'title' => _MI_WGTEAMS_ADMENU5,
    'link'  => 'admin/relations.php',
    'icon'  => 'assets/icons/32/relations.png'
];
$adminmenu[] = [
    'title' => _MI_WGTEAMS_ADMENU7,
    'link'  => 'admin/maintenance.php',
    'icon'  => 'assets/icons/32/maintenance.png'
];
$adminmenu[] = [
    'title' => _MI_WGTEAMS_ADMENU8,
    'link'  => 'admin/clone.php',
    'icon'  => 'assets/icons/32/clone.png'
];
$adminmenu[] = [
    'title' => _MI_WGTEAMS_ADMENU6,
    'link'  => 'admin/feedback.php',
    'icon'  => 'assets/icons/32/feedback.png'
];
$adminmenu[] = [
    'title' => _MI_WGTEAMS_ABOUT,
    'link'  => 'admin/about.php',
    'icon'  => 'assets/icons/32/about.png'
];

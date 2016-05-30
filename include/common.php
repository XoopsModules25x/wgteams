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
 * @version         $Id: 1.0 common.php 1 Sun 2015/12/27 23:18:02Z Goffy - Wedega $
 */
defined('XOOPS_ROOT_PATH') || exit('Restricted access');
if (!defined('WGTEAMS_MODULE_PATH')) {
    define('XOOPS_ICONS32_PATH', XOOPS_ROOT_PATH . '/Frameworks/moduleclasses/icons/32');
    define('XOOPS_ICONS32_URL', XOOPS_URL . '/Frameworks/moduleclasses/icons/32');
    define('WGTEAMS_DIRNAME', 'wgteams');
    define('WGTEAMS_PATH', XOOPS_ROOT_PATH . '/modules/' . WGTEAMS_DIRNAME);
    define('WGTEAMS_URL', XOOPS_URL . '/modules/' . WGTEAMS_DIRNAME);
    define('WGTEAMS_ICONS_PATH', WGTEAMS_PATH . '/assets/icons');
    define('WGTEAMS_ICONS_URL', WGTEAMS_URL . '/assets/icons');
    define('WGTEAMS_IMAGE_PATH', WGTEAMS_PATH . '/assets/images');
    define('WGTEAMS_IMAGE_URL', WGTEAMS_URL . '/assets/images');
    define('WGTEAMS_UPLOAD_PATH', XOOPS_UPLOAD_PATH . '/' . WGTEAMS_DIRNAME);
    define('WGTEAMS_UPLOAD_URL', XOOPS_UPLOAD_URL . '/' . WGTEAMS_DIRNAME);
    define('WGTEAMS_ADMIN', WGTEAMS_URL . '/admin/index.php');
    $local_logo = WGTEAMS_IMAGE_URL . '/wedega.png';
}
// module information
$copyright = "<a href='http://wedega.com' title='XOOPS on Wedega' target='_blank'>
                     <img src='" . $local_logo . "' alt='XOOPS on Wedega' /></a>";

include_once XOOPS_ROOT_PATH . '/class/xoopsrequest.php';
include_once WGTEAMS_PATH . '/class/helper.php';
include_once WGTEAMS_PATH . '/include/functions.php';

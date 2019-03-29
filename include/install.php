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
 * @version         $Id: 1.0 install.php 1 Sun 2015/12/27 23:18:01Z Goffy - Wedega $
 */
defined('XOOPS_ROOT_PATH') || die('Restricted access');
// Copy base file
$indexFile = XOOPS_UPLOAD_PATH . '/index.html';
$blankFile = XOOPS_UPLOAD_PATH . '/blank.gif';
// Making of "uploads/wgteams" folder
$wgteams = XOOPS_UPLOAD_PATH . '/wgteams';
if (!is_dir($wgteams)) {
    mkdir($wgteams, 0777);
}
chmod($wgteams, 0777);
copy($indexFile, $wgteams . '/index.html');

// Making of teams uploads folder
$folder = $wgteams . '/teams';
if (!is_dir($folder)) {
    mkdir($folder, 0777);
}
chmod($folder, 0777);
copy($indexFile, $folder . '/index.html');
$folder_img = $folder . '/images';
if (!is_dir($folder_img)) {
    mkdir($folder_img, 0777);
}
chmod($folder_img, 0777);
copy($indexFile, $folder_img . '/index.html');
copy($blankFile, $folder_img . '/blank.gif');

// Making of members uploads folder
$folder = $wgteams . '/members';
if (!is_dir($folder)) {
    mkdir($folder, 0777);
}
chmod($folder, 0777);
copy($indexFile, $folder . '/index.html');
$folder_img = $folder . '/images';
if (!is_dir($folder_img)) {
    mkdir($folder_img, 0777);
}
chmod($folder_img, 0777);
copy($indexFile, $folder_img . '/index.html');
copy($blankFile, $folder_img . '/blank.gif');

// ---------- Install Footer ---------- //

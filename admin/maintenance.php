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
 * wgGallery module for xoops
 *
 * @copyright      module for xoops
 * @license        GPL 2.0 or later
 * @package        wgteams
 * @since          1.0
 * @min_xoops      2.5.9
 * @author         Wedega - Email:<webmaster@wedega.com> - Website:<https://wedega.com>
 * @version        $Id: 1.0 albums.php 1 Mon 2018-03-19 10:04:49Z XOOPS Project (www.xoops.org) $
 */

use Xmf\Request;
use XoopsModules\Wgteams;
use XoopsModules\Wgteams\Constants;

require __DIR__ . '/header.php';

$op    = Request::getString('op', 'list');

$GLOBALS['xoopsTpl']->assign('wgteams_icon_url_16', WGTEAMS_ICONS_URL . '16/');

$maintainance_dui_desc = str_replace('%p', WGTEAMS_UPLOAD_PATH, _AM_WGTEAMS_MAINTENANCE_DELETE_UNUSED_DESC);
$GLOBALS['xoopsTpl']->assign('maintainance_dui_desc', $maintainance_dui_desc);
$maintainance_cs_desc = str_replace('%p', WGTEAMS_UPLOAD_PATH, _AM_WGTEAMS_MAINTENANCE_CHECK_SPACE_DESC);
$GLOBALS['xoopsTpl']->assign('maintainance_cs_desc', $maintainance_cs_desc);

switch ($op) {
    case 'unused_images_search':
        $unused = [];
        $errors = [];

        $directory = WGTEAMS_UPLOAD_PATH . '/teams/images';
        $url       = WGTEAMS_UPLOAD_URL . '/teams/images';
        if (false === getUnusedImages($unused, $directory, $url)) {
            $errors[] = _AM_WGTEAMS_MAINTENANCE_ERROR_READDIR . $directory;
        }
        $directory = WGTEAMS_UPLOAD_PATH . '/members/images';
        $url       = WGTEAMS_UPLOAD_URL . '/members/images';
        if (false === getUnusedImages($unused, $directory, $url)) {
            $errors[] = _AM_WGTEAMS_MAINTENANCE_ERROR_READDIR . $directory;
        }
        $directory = WGTEAMS_UPLOAD_PATH . '/temp';
        $url       = WGTEAMS_UPLOAD_URL . '/temp';
        if (false === getUnusedImages($unused, $directory, $url)) {
            $errors[] = _AM_WGTEAMS_MAINTENANCE_ERROR_READDIR . $directory;
        }

        $templateMain = 'wgteams_admin_maintenance.tpl';
        $unused_text  = '';
        $err_text     = '';
        if (count($errors) > 0) {
            foreach ($errors as $error) {
                $err_text .= '<br>' . $error;
            }
        }
        if (count($unused) === 0) {
            $unused_text = _AM_WGTEAMS_MAINTENANCE_DELETE_UNUSED_NONE;
        }
        $GLOBALS['xoopsTpl']->assign('result_unused', $unused);
        $GLOBALS['xoopsTpl']->assign('result_success', $unused_text);
        $GLOBALS['xoopsTpl']->assign('result_error', $err_text);
        $GLOBALS['xoopsTpl']->assign('show_unnused', true);
        $GLOBALS['xoopsTpl']->assign('show_result', true);
        break;
    case 'delete_unused_image':
        $del_img_path = Request::getString('del_img_path', 'none');
        if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                redirect_header('maintenance.php', 3, implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            unlink($del_img_path);
            if (file_exists($del_img_path)) {
                redirect_header('maintenance.php?op=unused_images_search', 2, _AM_WGTEAMS_MAINTENANCE_ERROR_DELETE . $del_img_path);
            } else {
                redirect_header('maintenance.php?op=unused_images_search', 2, _AM_WGTEAMS_MAINTENANCE_SUCCESS_DELETE . $del_img_path);
            }
        } else {
            xoops_confirm(['ok' => 1, 'op' => 'delete_unused_image'], $_SERVER['REQUEST_URI'], str_replace('%s', $del_img_path, _AM_WGTEAMS_FORM_SURE_DELETE));
        }
        break;

    case 'check_space':
        $success = [];
        $errors  = [];

        $path      = WGTEAMS_UPLOAD_PATH . '/teams/images';
        $disk_used = wgg_foldersize($path);
        $success[] = $path . ': ' . wgg_format_size($disk_used);
        $path      = WGTEAMS_UPLOAD_PATH . '/members/images';
        $disk_used = wgg_foldersize($path);
        $success[] = $path . ': ' . wgg_format_size($disk_used);
        $path      = WGTEAMS_UPLOAD_PATH . '/temp';
        $disk_used = wgg_foldersize($path);
        $success[] = $path . ': ' . wgg_format_size($disk_used);

        $templateMain = 'wgteams_admin_maintenance.tpl';
        $err_text     = '';
        if (count($errors) > 0) {
            $err_text = '<ul>';
            foreach ($errors as $error) {
                $err_text .= '<li>' . $error . '</li>';
            }
            $err_text .= '</ul>';
        }
        if (count($success) > 0) {
            $success_text = '<ul>';
            foreach ($success as $s) {
                $success_text .= '<li>' . $s . '</li>';
            }
            $success_text .= '</ul>';
        }

        $GLOBALS['xoopsTpl']->assign('result_success', $success_text);
        $GLOBALS['xoopsTpl']->assign('result_error', $err_text);
        $GLOBALS['xoopsTpl']->assign('show_checkspace', true);
        $GLOBALS['xoopsTpl']->assign('show_result', true);
        break;
    case 'list':
    default:
        $templateMain = 'wgteams_admin_maintenance.tpl';

        $GLOBALS['xoopsTpl']->assign('maintainance_dui_desc', $maintainance_dui_desc);
        $GLOBALS['xoopsTpl']->assign('show_unnused', true);
        $GLOBALS['xoopsTpl']->assign('show_checkspace', true);

        break;
}

/**
 * @param $val
 * @return float|int
 */
function returnCleanBytes($val)
{
    switch (mb_substr($val, -1)) {
        case 'K':
        case 'k':
            return (int)$val * 1024;
        case 'M':
        case 'm':
            return (int)$val * 1048576;
        case 'G':
        case 'g':
            return (int)$val * 1073741824;
        default:
            return $val;
    }
}

/**
 * get unused images of given directory
 * @param array  $unused
 * @param string $directory
 * @return bool
 */
function getUnusedImages(&$unused, $directory, $url)
{
    // Get instance of module
    /** @var \XoopsModules\Wgteams\Helper $helper */
    $helper        = \XoopsModules\Wgteams\Helper::getInstance();
    $membersHandler = $helper->getHandler('Members');
    $teamsHandler = $helper->getHandler('Teams');

    if (is_dir($directory)) {
        if ($handle = opendir($directory)) {
            while (false !== ($entry = readdir($handle))) {
                switch ($entry) {
                    case 'blank.gif':
                    case 'blank.png':
                    case 'index.html':
                    case 'noimage.png':
                    case 'anonymous.png':
                    case 'anonymous.jpg':
                    case '..':
                    case '.':
                        break;
                    case 'default':
                    default:
                        $crMemberImg = new \CriteriaCompo();
                        $crMemberImg->add(new \Criteria('member_image', $entry));
                        $imagesCount = $membersHandler->getCount($crMemberImg);
                        $crTeamImg    = new \CriteriaCompo();
                        $crTeamImg->add(new \Criteria('alb_image', $entry));
                        $imagesCount += $teamsHandler->getCount($crTeamImg);
                        if (0 == $imagesCount) {
                            $unused[] = ['name' => $entry, 'path' => $directory . '/' . $entry, 'url' => $url . '/' . $entry];
                        }
                        unset($crMemberImg);
                        unset($crTeamImg);
                        
                        break;
                }
            }
            closedir($handle);
        } else {
            return false;
        }
    } else {
        return false;
    }

    return true;
}

/**
 * get size of given directory
 * @param string $path
 * @return int
 */
function wgg_foldersize($path)
{
    $total_size = 0;
    $files      = scandir($path);

    foreach ($files as $t) {
        if (is_dir(rtrim($path, '/') . '/' . $t)) {
            if ('.' != $t && '..' != $t) {
                $size = wgg_foldersize(rtrim($path, '/') . '/' . $t);

                $total_size += $size;
            }
        } else {
            $size       = filesize(rtrim($path, '/') . '/' . $t);
            $total_size += $size;
        }
    }

    return $total_size;
}

/**
 * format size
 * @param int $size
 * @return string
 */
function wgg_format_size($size)
{
    $mod   = 1024;
    $units = explode(' ', 'B KB MB GB TB PB');
    for ($i = 0; $size > $mod; $i++) {
        $size /= $mod;
    }

    return round($size, 2) . ' ' . $units[$i];
}

require __DIR__ . '/footer.php';

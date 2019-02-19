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
 * @version         $Id: 1.0 xoops_version.php 1 Sun 2015/12/27 23:18:02Z Goffy - Wedega $
 */
defined('XOOPS_ROOT_PATH') || exit('Restricted access');

use XoopsModules\Wgteams;
use XoopsModules\Wgteams\Helper;
//
//$dirname = basename(__DIR__);
// ------------------- Informations ------------------- //
$modversion = [
    'name'                => _MI_WGTEAMS_NAME,
    'version'             => '1.10',
    'description'         => _MI_WGTEAMS_DESC,
    'author'              => 'Goffy - Wedega.com',
    'author_mail'         => 'webmaster@wedega.com',
    'author_website_url'  => 'https://wedega.com',
    'author_website_name' => 'XOOPS on Wedega',
    'credits'             => 'Goffy - Wedega',
    'license'             => 'GPL 2.0 or later',
    'license_url'         => 'www.gnu.org/licenses/gpl-2.0.html/',
    'help'                => 'page=help',
    //
    'release_info'        => 'release_info',
    'release_file'        => XOOPS_URL . '/modules/wgteams/docs/release_info file',
    'release_date'        => '2016/08/19',
    //
    'manual'              => 'link to manual file',
    'manual_file'         => XOOPS_URL . '/modules/wgteams/docs/install.txt',
    'min_php'             => '5.6',
    'min_xoops'           => '2.5.9',
    'min_admin'           => '1.1',
    'min_db'              => ['mysql' => '5.0.7', 'mysqli' => '5.0.7'],
    'image'               => 'assets/images/wgteams_logo.png',
    'dirname'             => 'wgteams',
    // Frameworks
    'dirmoduleadmin'      => 'Frameworks/moduleclasses/moduleadmin',
    'sysicons16'          => '../../Frameworks/moduleclasses/icons/16',
    'sysicons32'          => '../../Frameworks/moduleclasses/icons/32',
    // Local path icons
    'modicons16'          => 'assets/icons/16',
    'modicons32'          => 'assets/icons/32',
    //About
    'demo_site_url'       => 'https://xoops.wedega.com',
    'demo_site_name'      => 'XOOPS on Wedega',
    'support_url'         => 'https://myxoops.org',
    'support_name'        => '',
    'module_website_url'  => '',
    'module_website_name' => '',
    'release'             => '2018/06/14',
    'module_status'       => 'RC1',
    // Admin system menu
    'system_menu'         => 1,
    // Admin things
    'hasAdmin'            => 1,
    'adminindex'          => 'admin/index.php',
    'adminmenu'           => 'admin/menu.php',
    // Main things
    'hasMain'             => 1,
    // Install/Update
    'onInstall'           => 'include/install.php',
    'onUpdate'            => 'include/update.php'
];
// ------------------- Templates ------------------- //
// Admin
$modversion['templates'][] = ['file' => 'wgteams_admin_about.tpl', 'description' => '', 'type' => 'admin'];
$modversion['templates'][] = ['file' => 'wgteams_admin_header.tpl', 'description' => '', 'type' => 'admin'];
$modversion['templates'][] = ['file' => 'wgteams_admin_index.tpl', 'description' => '', 'type' => 'admin'];
$modversion['templates'][] = ['file' => 'wgteams_admin_teams.tpl', 'description' => '', 'type' => 'admin'];
$modversion['templates'][] = ['file' => 'wgteams_admin_members.tpl', 'description' => '', 'type' => 'admin'];
$modversion['templates'][] = ['file' => 'wgteams_admin_relations.tpl', 'description' => '', 'type' => 'admin'];
$modversion['templates'][] = ['file' => 'wgteams_admin_infofields.tpl', 'description' => '', 'type' => 'admin'];
$modversion['templates'][] = ['file' => 'wgteams_admin_labels.tpl', 'description' => '', 'type' => 'admin'];
$modversion['templates'][] = ['file' => 'wgteams_admin_footer.tpl', 'description' => '', 'type' => 'admin'];
// User
$modversion['templates'][] = ['file' => 'wgteams_header.tpl', 'description' => ''];
$modversion['templates'][] = ['file' => 'wgteams_teams.tpl', 'description' => ''];
$modversion['templates'][] = ['file' => 'wgteams_teams_list.tpl', 'description' => ''];
$modversion['templates'][] = ['file' => 'wgteams_members_list.tpl', 'description' => ''];
$modversion['templates'][] = ['file' => 'wgteams_member_default.tpl', 'description' => ''];
$modversion['templates'][] = ['file' => 'wgteams_member_left.tpl', 'description' => ''];
$modversion['templates'][] = ['file' => 'wgteams_member_right.tpl', 'description' => ''];
$modversion['templates'][] = ['file' => 'wgteams_breadcrumbs.tpl', 'description' => ''];
$modversion['templates'][] = ['file' => 'wgteams_footer.tpl', 'description' => ''];

$modversion['templates'][] = ['file' => 'wgteams_block_teamsmembers.tpl', 'description' => '', 'type' => 'block'];

// ------------------- Mysql ------------------- //
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
// Tables
$modversion['tables'][1] = 'wgteams_teams';
$modversion['tables'][2] = 'wgteams_members';
$modversion['tables'][3] = 'wgteams_relations';
$modversion['tables'][4] = 'wgteams_infofields';

// ------------------- Search ------------------- //
$modversion['hasSearch']      = 1;
$modversion['search']['file'] = 'include/search.inc.php';
$modversion['search']['func'] = 'wgteams_search';

// ------------------- Submenu ------------------- //
global $xoopsModule;
if (is_object($xoopsModule) && $xoopsModule->getVar('dirname') == $modversion['dirname']) {
    global $xoopsModuleConfig, $xoopsUser;

    $s = 0;

    $teamsHandler = $helper->getHandler('teams');

    $crit_teams = new CriteriaCompo();
    $crit_teams->add(new Criteria('team_online', '1'));
    $crit_teams->setSort('team_weight');
    $crit_teams->setOrder('ASC');
    $teamsAll = $teamsHandler->getAll($crit_teams);
    foreach (array_keys($teamsAll) as $i) {
        $s++;
        $modversion['sub'][$s]['name'] = $teamsAll[$i]->getVar('team_name');
        $modversion['sub'][$s]['url']  = 'index.php?team_id=' . $teamsAll[$i]->getVar('team_id');        
    }
}
// ------------------- Blocks ------------------- //
$modversion['blocks'][] = [
    'file'        => 'b_teamsmembers.php',
    'name'        => _MI_WGTEAMS_TEAMSMEMBERS_BLOCK,
    'description' => _MI_WGTEAMS_TEAMSMEMBERS_BLOCK_DESC,
    'show_func'   => 'b_wgteams_teamsmembers_show',
    'edit_func'   => 'b_wgteams_teamsmembers_edit',
    'options'     => 'showsingleteam|0',
    'template'    => 'wgteams_block_teamsmembers.tpl'
];

$modversion['blocks'][] = [
    'file'        => 'b_teams.php',
    'name'        => _MI_WGTEAMS_TEAMS_BLOCK,
    'description' => _MI_WGTEAMS_TEAMS_BLOCK_DESC,
    'show_func'   => 'b_wgteams_teams_show',
    'edit_func'   => '',
    'options'     => 'showlistofteams|0',
    'template'    => 'wgteams_block_teams.tpl'
];

// ------------------- Config ------------------- //
$modversion['config'][] = [
    'name'        => 'keywords',
    'title'       => '_MI_WGTEAMS_KEYWORDS',
    'description' => '_MI_WGTEAMS_KEYWORDS_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'text',
    'default'     => 'wgteams, teams, members, relations, infofields'
];

$modversion['config'][] = [
    'name'        => 'adminpager',
    'title'       => '_MI_WGTEAMS_ADMIN_PAGER',
    'description' => '_MI_WGTEAMS_ADMIN_PAGER_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 10
];

$modversion['config'][] = [
    'name'        => 'userpager',
    'title'       => '_MI_WGTEAMS_USER_PAGER',
    'description' => '_MI_WGTEAMS_USER_PAGER_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 10
];

// start page for module
$modversion['config'][] = [
    'name'        => 'startpage',
    'title'       => '_MI_WGTEAMS_STARTPAGE',
    'description' => '_MI_WGTEAMS_STARTPAGE_DESC',
    'formtype'    => 'select',
    'valuetype'   => 'array',
    'default'     => 1,
    'options'     => [_MI_WGTEAMS_STARTPAGE_LIST => 1, _MI_WGTEAMS_STARTPAGE_ALL => 2, _MI_WGTEAMS_STARTPAGE_FIRST => 3]
];

// Editor
xoops_load('xoopseditorhandler');
$editorHandler          = XoopsEditorHandler::getInstance();
$modversion['config'][] = [
    'name'        => 'wgteams_editor',
    'title'       => '_MI_WGTEAMS_EDITOR',
    'description' => '_MI_WGTEAMS_EDITOR_DESC',
    'formtype'    => 'select',
    'valuetype'   => 'text',
    'options'     => array_flip($editorHandler->getList()),
    'default'     => 'dhtmltextarea'
];

//Uploads : max size for image upload 
$modversion['config'][] = [
    'name'        => 'wgteams_img_maxsize',
    'title'       => '_MI_WGTEAMS_IMG_MAXSIZE',
    'description' => '_MI_WGTEAMS_IMG_MAXSIZE_DESC',
    'formtype'    => 'select',
    'valuetype'   => 'text',
    'default'     => 3145728,
    'options'     => [
        '0.5 MB' => 524288,
        '1 MB'   => 1048576,
        '1.5 MB' => 1572864,
        '2 MB'   => 2097152,
        '2.5 MB' => 2621440,
        '3 MB'   => 3145728,
        '3.5 MB' => 3670016,
        '4 MB'   => 4194304,
        '4.5 MB' => 4718592,
        '5 MB'   => 5242880,
        '5.5 MB' => 5767168,
        '6 MB'   => 6291456,
        '6.5 MB' => 6815744,
        '7 MB'   => 7340032,
        '7.5 MB' => 7864320,
        '8 MB'   => 8388608,
        '8.5 MB' => 8912896,
        '9 MB'   => 9437184,
        '9.5 MB' => 9961472,
        '10 MB'  => 10485760,
    ],
];

//Uploads : mimetypes of images
$modversion['config'][] = [
    'name'        => 'wgteams_img_mimetypes',
    'title'       => '_MI_WGTEAMS_IMG_MIMETYPES',
    'description' => '_MI_WGTEAMS_IMG_MIMETYPES_DESC',
    'formtype'    => 'select_multi',
    'valuetype'   => 'array',
    'default'     => ['image/gif', 'image/jpeg', 'image/png', 'image/jpg'],
    'options'     => [
        'bmp'   => 'image/bmp',
        'gif'   => 'image/gif',
        'pjpeg' => 'image/pjpeg',
        'jpeg'  => 'image/jpeg',
        'jpg'   => 'image/jpg',
        'jpe'   => 'image/jpe',
        'png'   => 'image/png'
    ]
];

$modversion['config'][] = [
    'name'        => 'wgteams_labels',
    'title'       => '_MI_WGTEAMS_LABELS',
    'description' => '_MI_WGTEAMS_LABELS_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1
];

$modversion['config'][] = [
    'name'        => 'wgteams_showbreadcrumbs',
    'title'       => '_MI_WGTEAMS_SHOWBREADCRUMBS',
    'description' => '_MI_WGTEAMS_SHOWBREADCRUMBS_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1
];

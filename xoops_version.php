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
 * @version         $Id: 1.0 xoops_version.php 1 Sun 2015/12/27 23:18:02Z Goffy - Wedega $
 */
defined('XOOPS_ROOT_PATH') || exit('Restricted access');
//
//$dirname = basename(__DIR__);
// ------------------- Informations ------------------- //
$modversion = array(
    'name'                => _MI_WGTEAMS_NAME,
    'version'             => '1.08',
    'description'         => _MI_WGTEAMS_DESC,
    'author'              => 'Goffy - Wedega.com',
    'author_mail'         => 'webmaster@wedega.com',
    'author_website_url'  => 'http://wedega.com',
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
    'min_php'             => '5.5',
    'min_xoops'           => '2.5.7',
    'min_admin'           => '1.1',
    'min_db'              => array('mysql' => '5.0.7', 'mysqli' => '5.0.7'),
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
    'demo_site_url'       => 'http://xoops.wedega.com',
    'demo_site_name'      => 'XOOPS on Wedega',
    'support_url'         => '',
    'support_name'        => '',
    'module_website_url'  => '',
    'module_website_name' => '',
    'release'             => '2016/08/19',
    'module_status'       => 'RC 4',
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
    'onUpdate'            => 'include/update.php');
// ------------------- Templates ------------------- //
// Admin
$modversion['templates'][] = array('file' => 'wgteams_admin_about.tpl', 'description' => '', 'type' => 'admin');
$modversion['templates'][] = array('file' => 'wgteams_admin_header.tpl', 'description' => '', 'type' => 'admin');
$modversion['templates'][] = array('file' => 'wgteams_admin_index.tpl', 'description' => '', 'type' => 'admin');
$modversion['templates'][] = array('file' => 'wgteams_admin_teams.tpl', 'description' => '', 'type' => 'admin');
$modversion['templates'][] = array('file' => 'wgteams_admin_members.tpl', 'description' => '', 'type' => 'admin');
$modversion['templates'][] = array('file' => 'wgteams_admin_relations.tpl', 'description' => '', 'type' => 'admin');
$modversion['templates'][] = array('file' => 'wgteams_admin_infofields.tpl', 'description' => '', 'type' => 'admin');
$modversion['templates'][] = array('file' => 'wgteams_admin_labels.tpl', 'description' => '', 'type' => 'admin');
$modversion['templates'][] = array('file' => 'wgteams_admin_footer.tpl', 'description' => '', 'type' => 'admin');
// User
$modversion['templates'][] = array('file' => 'wgteams_header.tpl', 'description' => '');
$modversion['templates'][] = array('file' => 'wgteams_teams.tpl', 'description' => '');
$modversion['templates'][] = array('file' => 'wgteams_teams_list.tpl', 'description' => '');
$modversion['templates'][] = array('file' => 'wgteams_members_list.tpl', 'description' => '');
$modversion['templates'][] = array('file' => 'wgteams_member_default.tpl', 'description' => '');
$modversion['templates'][] = array('file' => 'wgteams_member_left.tpl', 'description' => '');
$modversion['templates'][] = array('file' => 'wgteams_member_right.tpl', 'description' => '');
$modversion['templates'][] = array('file' => 'wgteams_breadcrumbs.tpl', 'description' => '');
$modversion['templates'][] = array('file' => 'wgteams_footer.tpl', 'description' => '');

$modversion['templates'][] = array('file' => 'wgteams_block_teamsmembers.tpl', 'description' => '', 'type' => 'block');

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

    $wgteams      = WgteamsHelper::getInstance();
    $teamsHandler = $wgteams->getHandler('teams');

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
$modversion['blocks'][] = array(
    'file'        => 'b_teamsmembers.php',
    'name'        => _MI_WGTEAMS_TEAMSMEMBERS_BLOCK,
    'description' => _MI_WGTEAMS_TEAMSMEMBERS_BLOCK_DESC,
    'show_func'   => 'b_wgteams_teamsmembers_show',
    'edit_func'   => 'b_wgteams_teamsmembers_edit',
    'options'     => 'showsingleteam|0',
    'template'    => 'wgteams_block_teamsmembers.tpl');

$modversion['blocks'][] = array(
    'file'        => 'b_teams.php',
    'name'        => _MI_WGTEAMS_TEAMS_BLOCK,
    'description' => _MI_WGTEAMS_TEAMS_BLOCK_DESC,
    'show_func'   => 'b_wgteams_teams_show',
    'edit_func'   => '',
    'options'     => 'showlistofteams|0',
    'template'    => 'wgteams_block_teams.tpl');

// ------------------- Config ------------------- //
$modversion['config'][] = array(
    'name'        => 'keywords',
    'title'       => '_MI_WGTEAMS_KEYWORDS',
    'description' => '_MI_WGTEAMS_KEYWORDS_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'text',
    'default'     => 'wgteams, teams, members, relations, infofields');

$modversion['config'][] = array(
    'name'        => 'adminpager',
    'title'       => '_MI_WGTEAMS_ADMIN_PAGER',
    'description' => '_MI_WGTEAMS_ADMIN_PAGER_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 10);

$modversion['config'][] = array(
    'name'        => 'userpager',
    'title'       => '_MI_WGTEAMS_USER_PAGER',
    'description' => '_MI_WGTEAMS_USER_PAGER_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 10);

// start page for module
$modversion['config'][] = array(
    'name'        => 'startpage',
    'title'       => '_MI_WGTEAMS_STARTPAGE',
    'description' => '_MI_WGTEAMS_STARTPAGE_DESC',
    'formtype'    => 'select',
    'valuetype'   => 'array',
    'default'     => 1,
    'options'     => array(_MI_WGTEAMS_STARTPAGE_LIST => 1, _MI_WGTEAMS_STARTPAGE_ALL => 2, _MI_WGTEAMS_STARTPAGE_FIRST => 3));

// Editor
xoops_load('xoopseditorhandler');
$editorHandler          = XoopsEditorHandler::getInstance();
$modversion['config'][] = array(
    'name'        => 'wgteams_editor',
    'title'       => '_MI_WGTEAMS_EDITOR',
    'description' => '_MI_WGTEAMS_EDITOR_DESC',
    'formtype'    => 'select',
    'valuetype'   => 'text',
    'options'     => array_flip($editorHandler->getList()),
    'default'     => 'dhtmltextarea'
);

//Uploads : max size for image upload 
$modversion['config'][] = array(
    'name'        => 'wgteams_img_maxsize',
    'title'       => '_MI_WGTEAMS_IMG_MAXSIZE',
    'description' => '_MI_WGTEAMS_IMG_MAXSIZE_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 10485760); // 1 MB

//Uploads : mimetypes of images
$modversion['config'][] = array(
    'name'        => 'wgteams_img_mimetypes',
    'title'       => '_MI_WGTEAMS_IMG_MIMETYPES',
    'description' => '_MI_WGTEAMS_IMG_MIMETYPES_DESC',
    'formtype'    => 'select_multi',
    'valuetype'   => 'array',
    'default'     => array('image/gif', 'image/jpeg', 'image/png', 'image/jpg'),
    'options'     => array(
        'bmp'   => 'image/bmp',
        'gif'   => 'image/gif',
        'pjpeg' => 'image/pjpeg',
        'jpeg'  => 'image/jpeg',
        'jpg'   => 'image/jpg',
        'jpe'   => 'image/jpe',
        'png'   => 'image/png'
    ));

$modversion['config'][] = array(
    'name'        => 'wgteams_labels',
    'title'       => '_MI_WGTEAMS_LABELS',
    'description' => '_MI_WGTEAMS_LABELS_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1);

$modversion['config'][] = array(
    'name'        => 'wgteams_showbreadcrumbs',
    'title'       => '_MI_WGTEAMS_SHOWBREADCRUMBS',
    'description' => '_MI_WGTEAMS_SHOWBREADCRUMBS_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1);

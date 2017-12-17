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
 * @version         $Id: 1.0 modinfo.php 1 Sun 2015/12/27 23:18:01Z Goffy - Wedega $
 */
// ---------------- Admin Main ----------------
define('_MI_WGTEAMS_NAME', 'wgTeams');
define('_MI_WGTEAMS_DESC', 'This module shows your team(s) and team members');
// ---------------- Admin Menu ----------------
define('_MI_WGTEAMS_ADMENU1', 'Dashboard');
define('_MI_WGTEAMS_ADMENU3', 'Teams');
define('_MI_WGTEAMS_ADMENU4', 'Members');
define('_MI_WGTEAMS_ADMENU2', 'Infofields');
define('_MI_WGTEAMS_ADMENU5', 'Relations');
define('_MI_WGTEAMS_ABOUT', 'About');
// ---------------- Admin Nav ----------------
define('_MI_WGTEAMS_ADMIN_PAGER', 'Admin pager');
define('_MI_WGTEAMS_ADMIN_PAGER_DESC', 'Admin per page list');
// User
define('_MI_WGTEAMS_USER_PAGER', 'User pager');
define('_MI_WGTEAMS_USER_PAGER_DESC', 'User per page list');
// Submenu
define('_MI_WGTEAMS_SMNAME1', 'teams');
// Blocks
define('_MI_WGTEAMS_TEAMSMEMBERS_BLOCK', 'Team/Members block');
define('_MI_WGTEAMS_TEAMSMEMBERS_BLOCK_DESC', 'Show all Teams with related members in a block');
define('_MI_WGTEAMS_TEAMS_BLOCK', 'Block Teams');
define('_MI_WGTEAMS_TEAMS_BLOCK_DESC', 'Show a list of the teams');
// Config
define('_MI_WGTEAMS_EDITOR', 'Editor');
define('_MI_WGTEAMS_EDITOR_DESC', 'Select the Editor to use');
define('_MI_WGTEAMS_KEYWORDS', 'Keywords');
define('_MI_WGTEAMS_KEYWORDS_DESC', 'Insert here the keywords (separate by comma)');
define('_MI_WGTEAMS_IMG_MAXSIZE', 'Max size');
define('_MI_WGTEAMS_IMG_MAXSIZE_DESC', 'Set a number of max size uploads file in byte');
define('_MI_WGTEAMS_IMG_MIMETYPES', 'Mime Types');
define('_MI_WGTEAMS_IMG_MIMETYPES_DESC', 'Set the mime types selected');
define('_MI_WGTEAMS_STARTPAGE', 'Start page');
define('_MI_WGTEAMS_STARTPAGE_DESC', 'Define, what should be shown when calling the module (index.php)');
define('_MI_WGTEAMS_STARTPAGE_LIST', 'An overview with all teams (but without members)');
define('_MI_WGTEAMS_STARTPAGE_ALL', 'All teams with all members');
define('_MI_WGTEAMS_STARTPAGE_FIRST', 'The first team');
define('_MI_WGTEAMS_LABELS', 'Show labels');
define('_MI_WGTEAMS_LABELS_DESC', "Please decide, whether there should be a label before the information, e.g. before the name the label 'first and last name' will be shown. If you select 'No', only the name himself, the phone number himself an so one will be shown");
define('_MI_WGTEAMS_SHOWBREADCRUMBS', 'Show breadcrumbs-navigation');
define('_MI_WGTEAMS_SHOWBREADCRUMBS_DESC', 'Please decide, whether a breadcrumbs-navigation should be shown.');
// ---------------- End ----------------


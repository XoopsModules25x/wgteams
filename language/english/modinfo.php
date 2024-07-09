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
 * @author          Goffy - Wedega.com - Email:<webmaster@wedega.com> - Website:<https://wedega.com>
 */
 
require_once __DIR__ . '/common.php';

// ---------------- Admin Main ----------------
\define('_MI_WGTEAMS_NAME', 'wgTeams');
\define('_MI_WGTEAMS_DESC', 'This module shows your team(s) and team members');
// ---------------- Admin Menu ----------------
\define('_MI_WGTEAMS_ADMENU1', 'Dashboard');
\define('_MI_WGTEAMS_ADMENU3', 'Teams');
\define('_MI_WGTEAMS_ADMENU4', 'Members');
\define('_MI_WGTEAMS_ADMENU2', 'Infofields');
\define('_MI_WGTEAMS_ADMENU5', 'Relations');
\define('_MI_WGTEAMS_ADMENU6', 'Feedback');
\define('_MI_WGTEAMS_ADMENU7', 'Maintenance');
\define('_MI_WGTEAMS_ADMENU8', 'Clone');
\define('_MI_WGTEAMS_ABOUT', 'About');
// ---------------- Admin Nav ----------------
\define('_MI_WGTEAMS_ADMIN_PAGER', 'Admin pager');
\define('_MI_WGTEAMS_ADMIN_PAGER_DESC', 'Admin per page list');
// User
\define('_MI_WGTEAMS_USER_PAGER', 'User pager');
\define('_MI_WGTEAMS_USER_PAGER_DESC', 'User per page list');
// Submenu
\define('_MI_WGTEAMS_SMNAME1', 'teams');
// Blocks
\define('_MI_WGTEAMS_TEAMSMEMBERS_BLOCK', 'Team/Members block default');
\define('_MI_WGTEAMS_TEAMSMEMBERS_BLOCK_DESC', 'Show all teams with related members in a block');
\define('_MI_WGTEAMS_TEAMS_BLOCK', 'Teams  block');
\define('_MI_WGTEAMS_TEAMS_BLOCK_DESC', 'Show a list of the teams');
\define('_MI_WGTEAMS_TEAMSMEMBERS_BLOCK_EXTENDED', 'Team/Members block extended');
\define('_MI_WGTEAMS_TEAMSMEMBERS_BLOCK_EXTENDED_DESC', 'Show all teams with related members in a block');
// Config
\define('_MI_WGTEAMS_EDITOR', 'Editor');
\define('_MI_WGTEAMS_EDITOR_DESC', 'Select the Editor to use');
\define('_MI_WGTEAMS_KEYWORDS', 'Keywords');
\define('_MI_WGTEAMS_KEYWORDS_DESC', 'Insert here the keywords (separate by comma)');
\define('_MI_WGTEAMS_IMG_MAXSIZE', 'Max size');
\define('_MI_WGTEAMS_IMG_MAXSIZE_DESC', 'Set a number of max size uploads file');
\define('_MI_WGTEAMS_SIZE_MB', 'MB');
\define('_MI_WGTEAMS_IMG_MIMETYPES', 'Mime Types');
\define('_MI_WGTEAMS_IMG_MIMETYPES_DESC', 'Set the mime types selected');
\define('_MI_WGTEAMS_MAXWIDTH', 'Maximum width upload');
\define('_MI_WGTEAMS_MAXWIDTH_DESC', 'Set the max width which is allowed for uploading images (in pixel)<br>0 means that images keep original size<br>If original image is smaller the image will be not enlarged');
\define('_MI_WGTEAMS_MAXHEIGHT', 'Maximum height upload');
\define('_MI_WGTEAMS_MAXHEIGHT_DESC', 'Set the max height which is allowed for uploading images (in pixel)<br>0 means that images keep original size<br>If original image is smaller the image will be not enlarged');
\define('_MI_WGTEAMS_MAXWIDTH_IMGEDITOR', 'Maximum width upload');
\define('_MI_WGTEAMS_MAXWIDTH_IMGEDITOR_DESC', 'Set the max width which is allowed for uploading images (in pixel)<br>0 means that images keep original size<br>If original image is smaller the image will be not enlarged');
\define('_MI_WGTEAMS_MAXHEIGHT_IMGEDITOR', 'Maximum height upload');
\define('_MI_WGTEAMS_MAXHEIGHT_IMGEDITOR_DESC', 'Set the max height which is allowed for uploading images (in pixel)<br>0 means that images keep original size<br>If original image is smaller the image will be not enlarged');
\define('_MI_WGTEAMS_STARTPAGE', 'Start page');
\define('_MI_WGTEAMS_STARTPAGE_DESC', 'Define, what should be shown when calling the module (index.php)');
\define('_MI_WGTEAMS_STARTPAGE_LIST', 'An overview with all teams (but without members)');
\define('_MI_WGTEAMS_STARTPAGE_ALL', 'All teams with all members');
\define('_MI_WGTEAMS_STARTPAGE_FIRST', 'The first team');
\define('_MI_WGTEAMS_SHOW_TEAMNAME', 'Show team name');
\define('_MI_WGTEAMS_SHOW_TEAMNAME_DESC', "Please decide, whether the team name should be shown or not");
\define('_MI_WGTEAMS_LABELS_MEMBER', 'Show labels for member information');
\define('_MI_WGTEAMS_LABELS_MEMBER_DESC', "Please decide, whether there should be a label before the member information, e.g. before the name the label 'first and last name' will be shown. If you select 'No', only the name himself, the phone number himself an so one will be shown");
\define('_MI_WGTEAMS_LABELS_INFOFIELD', 'Show labels for infofields');
\define('_MI_WGTEAMS_LABELS_INFOFIELD_DESC', "Please decide, whether there should be a label before the information from additional infofields. If you select 'No', only the information itself will be shown");
\define('_MI_WGTEAMS_SHOWBREADCRUMBS', 'Show breadcrumbs-navigation');
\define('_MI_WGTEAMS_SHOWBREADCRUMBS_DESC', 'Please decide, whether a breadcrumbs-navigation should be shown.');
\define('_MI_WGTEAMS_SHOWCOPYRIGHT', 'Show copyright');
\define('_MI_WGTEAMS_SHOWCOPYRIGHT_DESC', 'You can remove the copyright from the wgteams pages, but a backlinks to www.wedega.com is expected, anywhere on your site');
//version 2.0.2
\define('_MI_WGTEAMS_USEDETAILS', 'Use details');
\define('_MI_WGTEAMS_USEDETAILS_DESC', 'Decide whether you want to show information details of members');
\define('_MI_WGTEAMS_USEDETAILS_NONE', 'Do not use feature details. All information will be shown always');
\define('_MI_WGTEAMS_USEDETAILS_TAB', 'Show details on new tab');
\define('_MI_WGTEAMS_USEDETAILS_MODAL', 'Show details on modal window');
// ---------------- End ----------------



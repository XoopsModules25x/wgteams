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
 * @version         $Id: 1.0 admin.php 1 Sun 2015/12/27 23:18:01Z Goffy - Wedega $
 */
// ---------------- Admin Index ----------------
define('_AM_WGTEAMS_STATISTICS', "Statistics");
// There are
define('_AM_WGTEAMS_THEREARE_TEAMS', "There are <span class='bold'>%s</span> teams in the database");
define('_AM_WGTEAMS_THEREARE_MEMBERS', "There are <span class='bold'>%s</span> members in the database");
define('_AM_WGTEAMS_THEREARE_RELATIONS', "There are <span class='bold'>%s</span> relations in the database");
define('_AM_WGTEAMS_THEREARE_INFOFIELDS', "There are <span class='bold'>%s</span> infofields in the database");
// ---------------- Admin Files ----------------
// There aren't
define('_AM_WGTEAMS_THEREARENT_TEAMS', "There aren't teams");
define('_AM_WGTEAMS_THEREARENT_MEMBERS', "There aren't members");
define('_AM_WGTEAMS_THEREARENT_RELATIONS', "There aren't relations");
define('_AM_WGTEAMS_THEREARENT_INFOFIELDS', "There aren't infofields");
// Save/Delete
define('_AM_WGTEAMS_FORM_OK', "Successfully saved");
define('_AM_WGTEAMS_FORM_DELETE_OK', "Successfully deleted");
define('_AM_WGTEAMS_FORM_SURE_DELETE', "Are you sure to delete: <b><span style='color : Red;'>%s </span></b>");
define('_AM_WGTEAMS_FORM_SURE_RENEW', "Are you sure to update: <b><span style='color : Red;'>%s </span></b>");
// Lists
define('_AM_WGTEAMS_TEAMS_LIST', "List of Teams");
define('_AM_WGTEAMS_MEMBERS_LIST', "List of members");
define('_AM_WGTEAMS_RELATIONS_LIST', "List of Relations");
define('_AM_WGTEAMS_INFOFIELDS_LIST', "List of Infofields");
// ---------------- Admin Classes ----------------
// Team add/edit
define('_AM_WGTEAMS_TEAM_ADD', "Add Team");
define('_AM_WGTEAMS_TEAM_EDIT', "Edit Team");
// Elements of Team
define('_AM_WGTEAMS_TEAM_ID', "Id");
define('_AM_WGTEAMS_TEAM_NAME', "Team name");
define('_AM_WGTEAMS_TEAM_DESCR', "Team descr");
define('_AM_WGTEAMS_TEAM_IMAGE', "Team image");
define('_AM_WGTEAMS_TEAM_NB_COLS', "Nb cols");
define('_AM_WGTEAMS_TEAM_TABLESTYLE', "Table styles");
define('_AM_WGTEAMS_TEAM_IMAGESTYLE', "Image styles");
define('_AM_WGTEAMS_TEAM_DISPLAYSTYLE', "Position of member image");
define('_AM_WGTEAMS_TEAM_WEIGHT', "Weight");
define('_AM_WGTEAMS_TEAM_ONLINE', "Online");
// options _AM_WGTEAMS_TEAM_TABLESTYLE
define('_AM_WGTEAMS_TEAM_TABLESTYLE_DEF', "Default (use default styles)");
define('_AM_WGTEAMS_TEAM_TABLESTYLE_BORDERED', "Bordered (Adds border on all sides of the table and cells)");
define('_AM_WGTEAMS_TEAM_TABLESTYLE_STRIPED', "Striped (Adds zebra-striping to any table row)");
define('_AM_WGTEAMS_TEAM_TABLESTYLE_LINED', "Lined (Add the rows a border top)");
// options _AM_WGTEAMS_TEAM_IMAGESTYLE
define('_AM_WGTEAMS_TEAM_IMAGESTYLE_DEF', "Default (use default image styles)");
define('_AM_WGTEAMS_TEAM_IMAGESTYLE_CIRCLE', "Circle (Shapes the image to a circle)");
define('_AM_WGTEAMS_TEAM_IMAGESTYLE_ROUNDED', "Rounded (Adds rounded corners to an image)");
define('_AM_WGTEAMS_TEAM_IMAGESTYLE_THUMBNAIL', "Thumbnail (Shapes the image to a thumbnail)");
// options _AM_WGTEAMS_TEAM_DISPLAYSTYLE
define('_AM_WGTEAMS_TEAM_DISPLAYSTYLE_LEFT', "Left (on the left side)");
define('_AM_WGTEAMS_TEAM_DISPLAYSTYLE_DEF', "Default (on the top)");
define('_AM_WGTEAMS_TEAM_DISPLAYSTYLE_RIGHT', "Right (on the right side)");

// member add/edit
define('_AM_WGTEAMS_MEMBER_ADD', "Add member");
define('_AM_WGTEAMS_MEMBER_EDIT', "Edit member");
// Elements of member
define('_AM_WGTEAMS_MEMBER_ID', "Id");
define('_AM_WGTEAMS_MEMBER_FIRSTNAME', "Firstname");
define('_AM_WGTEAMS_MEMBER_LASTNAME', "Lastname");
define('_AM_WGTEAMS_MEMBER_TITLE', "Title");
define('_AM_WGTEAMS_MEMBER_ADDRESS', "Address");
define('_AM_WGTEAMS_MEMBER_PHONE', "Phone");
define('_AM_WGTEAMS_MEMBER_EMAIL', "Email");
define('_AM_WGTEAMS_MEMBER_IMAGE', "Image");
// Relation add/edit
define('_AM_WGTEAMS_RELATION_ADD', "Add Relation");
define('_AM_WGTEAMS_RELATION_EDIT', "Edit Relation");
// Elements of Relation
define('_AM_WGTEAMS_RELATION_ID', "Id");
define('_AM_WGTEAMS_RELATION_TEAM_ID', "Teams");
define('_AM_WGTEAMS_RELATION_MEMBER_ID', "Members");
define('_AM_WGTEAMS_RELATION_INFO_1_FIELD', "Name Info 1");
define('_AM_WGTEAMS_RELATION_INFO_1', "Info 1");
define('_AM_WGTEAMS_RELATION_INFO_2_FIELD', "Name Info 2");
define('_AM_WGTEAMS_RELATION_INFO_2', "Info 2");
define('_AM_WGTEAMS_RELATION_INFO_3_FIELD', "Name Info 3");
define('_AM_WGTEAMS_RELATION_INFO_3', "Info 3");
define('_AM_WGTEAMS_RELATION_INFO_4_FIELD', "Name Info 4");
define('_AM_WGTEAMS_RELATION_INFO_4', "Info 4");
define('_AM_WGTEAMS_RELATION_INFO_5_FIELD', "Name Info 5");
define('_AM_WGTEAMS_RELATION_INFO_5', "Info 5");
define('_AM_WGTEAMS_RELATION_WEIGHT', "Weight");
// Infofield add/edit
define('_AM_WGTEAMS_INFOFIELD_ADD', "Add Infofield");
define('_AM_WGTEAMS_INFOFIELD_EDIT', "Edit Infofield");
// Elements of Infofield
define('_AM_WGTEAMS_INFOFIELD_ID', "Field id");
define('_AM_WGTEAMS_INFOFIELD_NAME', "Field name");
// General
define('_AM_WGTEAMS_FORM_UPLOAD', "Upload file");
define('_AM_WGTEAMS_FORM_UPLOAD_IMG', "Upload image");
define('_AM_WGTEAMS_FORM_IMAGE_PATH', "Files in %s ");
define('_AM_WGTEAMS_FORM_IMAGE_EXIST', "Existing images");
define('_AM_WGTEAMS_FORM_ACTION', "Action");
define('_AM_WGTEAMS_FORM_EDIT', "Modification");
define('_AM_WGTEAMS_FORM_DELETE', "Clear");
define('_AM_WGTEAMS_SUBMITTER', "Submitter");
define('_AM_WGTEAMS_DATE_CREATE', "Date create");
// ---------------- Admin Others ----------------
define('_AM_WGTEAMS_MAINTAINEDBY', " is maintained by ");
// ---------------- End ----------------

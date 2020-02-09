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
 * @version         $Id: 1.0 admin.php 1 Sun 2015/12/27 23:18:01Z Goffy - Wedega $
 */
 
require_once __DIR__ . '/common.php';
require_once __DIR__ . '/modinfo.php';

// ---------------- Admin Index ----------------
define('_AM_WGTEAMS_STATISTICS', 'Statistics');
// There are
define('_AM_WGTEAMS_THEREARE_TEAMS', "There are <span class='bold'>%s</span> teams in the database");
define('_AM_WGTEAMS_THEREARE_MEMBERS', "There are <span class='bold'>%s</span> members in the database");
define('_AM_WGTEAMS_THEREARE_RELATIONS', "There are <span class='bold'>%s</span> relations in the database");
define('_AM_WGTEAMS_THEREARE_INFOFIELDS', "There are <span class='bold'>%s</span> infofields in the database");
// ---------------- Admin Files ----------------
// There aren't
define('_AM_WGTEAMS_THEREARENT_TEAMS', 'There are no teams');
define('_AM_WGTEAMS_THEREARENT_MEMBERS', 'There are no members');
define('_AM_WGTEAMS_THEREARENT_RELATIONS', 'There are no relations');
define('_AM_WGTEAMS_THEREARENT_INFOFIELDS', 'There are no infofields');
// Save/Delete
define('_AM_WGTEAMS_FORM_OK', 'Successfully saved');
define('_AM_WGTEAMS_FORM_DELETE_OK', 'Successfully deleted');
define('_AM_WGTEAMS_FORM_SURE_DELETE', "Are you sure to delete: <b><span style='color : Red;'>%s </span></b>");
define('_AM_WGTEAMS_FORM_SURE_RENEW', "Are you sure to update: <b><span style='color : Red;'>%s </span></b>");
// Lists
define('_AM_WGTEAMS_TEAMS_LIST', 'List of Teams');
define('_AM_WGTEAMS_MEMBERS_LIST', 'List of members');
define('_AM_WGTEAMS_RELATIONS_LIST', 'List of Relations');
define('_AM_WGTEAMS_INFOFIELDS_LIST', 'List of Infofields');
// ---------------- Admin Classes ----------------
// Team add/edit
define('_AM_WGTEAMS_TEAM_ADD', 'Add Team');
define('_AM_WGTEAMS_TEAM_EDIT', 'Edit Team');
// Elements of Team
define('_AM_WGTEAMS_TEAM_ID', 'Id');
define('_AM_WGTEAMS_TEAM_NAME', 'Team name');
define('_AM_WGTEAMS_TEAM_DESCR', 'Team descr');
define('_AM_WGTEAMS_TEAM_IMAGE', 'Team image');
define('_AM_WGTEAMS_TEAM_IMAGES', 'Images teams');
define('_AM_WGTEAMS_TEAM_NB_COLS', 'Nb cols');
define('_AM_WGTEAMS_TEAM_TABLESTYLE', 'Table styles');
define('_AM_WGTEAMS_TEAM_IMAGESTYLE', 'Image styles');
define('_AM_WGTEAMS_TEAM_DISPLAYSTYLE', 'Position of member image');
define('_AM_WGTEAMS_TEAM_WEIGHT', 'Weight');
define('_AM_WGTEAMS_TEAM_ONLINE', 'Online');
// options _AM_WGTEAMS_TEAM_TABLESTYLE
define('_AM_WGTEAMS_TEAM_TABLESTYLE_DEF', 'Default (use default styles)');
define('_AM_WGTEAMS_TEAM_TABLESTYLE_BORDERED', 'Bordered (Adds border on all sides of the table and cells)');
define('_AM_WGTEAMS_TEAM_TABLESTYLE_STRIPED', 'Striped (Adds zebra-striping to any table row)');
define('_AM_WGTEAMS_TEAM_TABLESTYLE_LINED', 'Lined (Add the rows a border top)');
// options _AM_WGTEAMS_TEAM_IMAGESTYLE
define('_AM_WGTEAMS_TEAM_IMAGESTYLE_DEF', 'Default (use default image styles)');
define('_AM_WGTEAMS_TEAM_IMAGESTYLE_CIRCLE', 'Circle (Shapes the image to a circle)');
define('_AM_WGTEAMS_TEAM_IMAGESTYLE_ROUNDED', 'Rounded (Adds rounded corners to an image)');
define('_AM_WGTEAMS_TEAM_IMAGESTYLE_THUMBNAIL', 'Thumbnail (Shapes the image to a thumbnail)');
// options _AM_WGTEAMS_TEAM_DISPLAYSTYLE
define('_AM_WGTEAMS_TEAM_DISPLAYSTYLE_LEFT', 'Left (on the left side)');
define('_AM_WGTEAMS_TEAM_DISPLAYSTYLE_DEF', 'Default (on the top)');
define('_AM_WGTEAMS_TEAM_DISPLAYSTYLE_RIGHT', 'Right (on the right side)');
define('_AM_WGTEAMS_TEAM_RELSCOUNT', 'Number of members');
// member add/edit
define('_AM_WGTEAMS_MEMBER_ADD', 'Add member');
define('_AM_WGTEAMS_MEMBER_EDIT', 'Edit member');
// Elements of member
define('_AM_WGTEAMS_MEMBER_ID', 'Id');
define('_AM_WGTEAMS_MEMBER_FIRSTNAME', 'Firstname');
define('_AM_WGTEAMS_MEMBER_LASTNAME', 'Lastname');
define('_AM_WGTEAMS_MEMBER_TITLE', 'Title');
define('_AM_WGTEAMS_MEMBER_ADDRESS', 'Address');
define('_AM_WGTEAMS_MEMBER_PHONE', 'Phone');
define('_AM_WGTEAMS_MEMBER_EMAIL', 'Email');
define('_AM_WGTEAMS_MEMBER_IMAGE', 'Image');
define('_AM_WGTEAMS_MEMBER_IMAGES', 'Images members');
define('_AM_WGTEAMS_MEMBER_UID', 'Xoops User Id');
define('_AM_WGTEAMS_MEMBER_UID_DESC', "<br><span style='font-size:90%'>You can link the member with a xoops user account and a button for opening your profile will be shown.<br>If you select 'Guest' no button will appear.</span>");
// Relation add/edit
define('_AM_WGTEAMS_RELATION_ADD', 'Add Relation');
define('_AM_WGTEAMS_RELATION_EDIT', 'Edit Relation');
// Elements of Relation
define('_AM_WGTEAMS_RELATION_ID', 'Id');
define('_AM_WGTEAMS_RELATION_TEAM_ID', 'Teams');
define('_AM_WGTEAMS_RELATION_MEMBER_ID', 'Members');
define('_AM_WGTEAMS_RELATION_INFO_1_FIELD', 'Name Info 1');
define('_AM_WGTEAMS_RELATION_INFO_1', 'Info 1');
define('_AM_WGTEAMS_RELATION_INFO_2_FIELD', 'Name Info 2');
define('_AM_WGTEAMS_RELATION_INFO_2', 'Info 2');
define('_AM_WGTEAMS_RELATION_INFO_3_FIELD', 'Name Info 3');
define('_AM_WGTEAMS_RELATION_INFO_3', 'Info 3');
define('_AM_WGTEAMS_RELATION_INFO_4_FIELD', 'Name Info 4');
define('_AM_WGTEAMS_RELATION_INFO_4', 'Info 4');
define('_AM_WGTEAMS_RELATION_INFO_5_FIELD', 'Name Info 5');
define('_AM_WGTEAMS_RELATION_INFO_5', 'Info 5');
define('_AM_WGTEAMS_RELATION_WEIGHT', 'Weight');
define('_AM_WGTEAMS_RELATION_DELETE', "Do you really want to delete '%n' from '%t'");

// Infofield add/edit
define('_AM_WGTEAMS_INFOFIELD_ADD', 'Add Infofield');
define('_AM_WGTEAMS_INFOFIELD_EDIT', 'Edit Infofield');
// Elements of Infofield
define('_AM_WGTEAMS_INFOFIELD_ID', 'Field id');
define('_AM_WGTEAMS_INFOFIELD_NAME', 'Field name');
// General
define('_AM_WGTEAMS_FORM_UPLOAD', 'Upload file');
define('_AM_WGTEAMS_FORM_UPLOAD_IMG', 'Upload new image');
define('_AM_WGTEAMS_FORM_IMAGE_PATH', 'Files in %s ');
define('_AM_WGTEAMS_FORM_IMAGE_EXIST', 'Existing images');
define('_AM_WGTEAMS_FORM_ACTION', 'Action');
define('_AM_WGTEAMS_FORM_EDIT', 'Modification');
define('_AM_WGTEAMS_FORM_DELETE', 'Clear');
define('_AM_WGTEAMS_SUBMITTER', 'Submitter');
define('_AM_WGTEAMS_DATE_CREATE', 'Date create');
define('_AM_WGTEAMS_FORM_SELTEAM', 'Select Team');
define('_AM_WGTEAMS_RELATIONS_NOTEAM', 'There are no relations for selected team');
define('_AM_WGTEAMS_RELATIONS_NOTEAMSEL', 'No team selected');
// ---------------- Admin Others ----------------
define('_AM_WGTEAMS_MAINTAINEDBY', " is maintained by <a href='https://wedega.com'>https://wedega.com</a> und <a href='https://xoops.wedega.com'>https://xoops.wedega.com</a>");
define('_AM_WGTEAMS_MAX_FILESIZE', 'Max File Size');
// image editor
define('_AM_WGTEAMS_IMG_EDITOR', 'Image editor');
define('_AM_WGTEAMS_IMG_EDITOR_CREATE', 'Create image');
define('_AM_WGTEAMS_IMG_EDITOR_APPLY', 'Apply');
define('_AM_WGTEAMS_IMG_EDITOR_IMAGE_EDIT', 'Edit album image');
define('_AM_WGTEAMS_IMG_EDITOR_CURRENT', 'Current');
define('_AM_WGTEAMS_IMG_EDITOR_USE_EXISTING', 'Use existing image');
define('_AM_WGTEAMS_IMG_EDITOR_GRID', 'Create an image grid');
define('_AM_WGTEAMS_IMG_EDITOR_GRID4', 'Use 4 images');
define('_AM_WGTEAMS_IMG_EDITOR_GRID6', 'Use 6 images');
define('_AM_WGTEAMS_IMG_EDITOR_GRID_SRC1', 'Select image 1');
define('_AM_WGTEAMS_IMG_EDITOR_GRID_SRC2', 'Select image 2');
define('_AM_WGTEAMS_IMG_EDITOR_GRID_SRC3', 'Select image 3');
define('_AM_WGTEAMS_IMG_EDITOR_GRID_SRC4', 'Select image 4');
define('_AM_WGTEAMS_IMG_EDITOR_GRID_SRC5', 'Select image 5');
define('_AM_WGTEAMS_IMG_EDITOR_GRID_SRC6', 'Select image 6');
define('_AM_WGTEAMS_IMG_EDITOR_CROP', 'Crop image');
define('_AM_WGTEAMS_IMG_EDITOR_CROP_MOVE', 'Move');
define('_AM_WGTEAMS_IMG_EDITOR_CROP_ZOOMIN', 'Zoom in');
define('_AM_WGTEAMS_IMG_EDITOR_CROP_ZOOMOUT', 'Zomm out');
define('_AM_WGTEAMS_IMG_EDITOR_CROP_MOVE_LEFT', 'Move left');
define('_AM_WGTEAMS_IMG_EDITOR_CROP_MOVE_RIGHT', 'Move right');
define('_AM_WGTEAMS_IMG_EDITOR_CROP_MOVE_UP', 'Move up');
define('_AM_WGTEAMS_IMG_EDITOR_CROP_MOVE_DOWN', 'Move down');
define('_AM_WGTEAMS_IMG_EDITOR_CROP_ROTATE_LEFT', 'Rotate left');
define('_AM_WGTEAMS_IMG_EDITOR_CROP_ROTATE_RIGHT', 'Rotate right');
define('_AM_WGTEAMS_IMG_EDITOR_CROP_FLIP_HORIZONTAL', 'Flip horizontal');
define('_AM_WGTEAMS_IMG_EDITOR_CROP_FLIP_VERTICAL', 'Flip vertical');
define('_AM_WGTEAMS_IMG_EDITOR_CROP_ASPECTRATIO', 'Aspect ratio');
define('_AM_WGTEAMS_IMG_EDITOR_CROP_ASPECTRATIO_FREE', 'Free');
define('_AM_WGTEAMS_IMG_EDITOR_CURRENT2', 'Source of current image');
define('_AM_WGTEAMS_IMG_EDITOR_RESXY', 'Resolution');
define('_AM_WGTEAMS_IMG_EDITOR_UPLOAD', 'Conditions for uploading images');
define('_AM_WGTEAMS_IMG_EDITOR_RESIZE', 'Resize image automatically');
define('_AM_WGTEAMS_IMG_EDITOR_RESIZE_DESC', 'Resize image automatically to default dimension (width max. %w px / height max. %h px): ');
define('_AM_WGTEAMS_FORM_ERROR_INVALID_ID', 'Invalid ID');
//1.10
define('_AM_WGTEAMS_MAINTENANCE_TYP', 'Typ of maintenance');
define('_AM_WGTEAMS_MAINTENANCE_DESC', 'Description');
define('_AM_WGTEAMS_MAINTENANCE_RESULTS', 'Results');
define('_AM_WGTEAMS_MAINTENANCE_SUCCESS_DELETE', 'Successfully deleted: ');
define('_AM_WGTEAMS_MAINTENANCE_ERROR_DELETE', 'Error when deleting: ');
define('_AM_WGTEAMS_MAINTENANCE_ERROR_READDIR', 'Error when reading directory: ');
define('_AM_WGTEAMS_MAINTENANCE_DELETE_UNUSED', 'Cleanup image directory');
define('_AM_WGTEAMS_MAINTENANCE_DELETE_UNUSED_DESC', 'Show all currently unused images from following directories:<ul>
<li>%p/teams/images/</li>
<li>%p/members/images/</li>
<li>%p/temp/</li>
</ul>');
define('_AM_WGTEAMS_MAINTENANCE_DELETE_UNUSED_NONE', 'No unused images found');
define('_AM_WGTEAMS_EXEC', 'Execute');
define('_AM_WGTEAMS_MAINTENANCE_CHECK_SPACE', 'Check used space in upload directory');
define('_AM_WGTEAMS_MAINTENANCE_CHECK_SPACE_DESC', 'Following upload directories will be checked in order to get used space:<ul>
<li>%p/teams/images/</li>
<li>%p/members/images/</li>
<li>%p/temp/</li>
</ul>');

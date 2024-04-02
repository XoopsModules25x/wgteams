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
 * @copyright module for xoops
 * @license   GPL 2.0 or later
 * @package   wgTeams
 * @since     1.0
 * @min_xoops 2.5.7
 * @author    Wedega - Email:<webmaster@wedega.com> - Website:<https://wedega.com>
 * @version   $Id: 1.0 main.php 1 Mon 2018-03-19 10:04:56Z XOOPS Project (www.xoops.org) $
 */
 
$moduleDirName = \basename(\dirname(__DIR__, 2));
$moduleDirNameUpper = \mb_strtoupper($moduleDirName);

// General
\define('CO_' . $moduleDirNameUpper . '_' . 'CONFIRM', 'Confirm');
//Sample Data
\define('CO_' . $moduleDirNameUpper . '_' . 'ADD_SAMPLEDATA', 'Import Sample Data (will delete ALL current data)');
\define('CO_' . $moduleDirNameUpper . '_' . 'SAMPLEDATA_SUCCESS', 'Sample Date uploaded successfully');
\define('CO_' . $moduleDirNameUpper . '_' . 'SAVE_SAMPLEDATA', 'Export Tables to YAML');
\define('CO_' . $moduleDirNameUpper . '_' . 'SAVE_SAMPLEDATA_SUCCESS', 'Export Tables to YAML successfully');
\define('CO_' . $moduleDirNameUpper . '_' . 'SHOW_SAMPLE_BUTTON', 'Show Sample Button?');
\define('CO_' . $moduleDirNameUpper . '_' . 'SHOW_SAMPLE_BUTTON_DESC', 'If yes, the "Add Sample Data" button will be visible to the Admin. It is Yes as a default for first installation.');
\define('CO_' . $moduleDirNameUpper . '_' . 'EXPORT_SCHEMA', 'Export DB Schema to YAML');
\define('CO_' . $moduleDirNameUpper . '_' . 'EXPORT_SCHEMA_SUCCESS', 'Export DB Schema to YAML was a success');
\define('CO_' . $moduleDirNameUpper . '_' . 'EXPORT_SCHEMA_ERROR', 'ERROR: Export of DB Schema to YAML failed');
\define('CO_' . $moduleDirNameUpper . '_' . 'ADD_SAMPLEDATA_OK', 'Are you sure to Import Sample Data? (It will delete ALL current data)');
\define('CO_' . $moduleDirNameUpper . '_' . 'HIDE_SAMPLEDATA_BUTTONS', 'Hide the Import buttons)');
\define('CO_' . $moduleDirNameUpper . '_' . 'SHOW_SAMPLEDATA_BUTTONS', 'Show the Import buttons)');

//Menu
\define('CO_' . $moduleDirNameUpper . '_' . 'ADMENU_MIGRATE', 'Migrate');
\define('CO_' . $moduleDirNameUpper . '_' . 'FOLDER_YES', 'Folder "%s" exist');
\define('CO_' . $moduleDirNameUpper . '_' . 'FOLDER_NO', 'Folder "%s" does not exist. Create the specified folder with CHMOD 777.');
\define('CO_' . $moduleDirNameUpper . '_' . 'SHOW_DEV_TOOLS', 'Show Development Tools Button?');
\define('CO_' . $moduleDirNameUpper . '_' . 'SHOW_DEV_TOOLS_DESC', 'If yes, the "Migrate" Tab and other Development tools will be visible to the Admin.');

//Latest Version Check
\define('CO_' . $moduleDirNameUpper . '_' . 'NEW_VERSION', 'New Version: ');
\define('CO_' . $moduleDirNameUpper . '_' . 'ERROR_BAD_XOOPS', 'Minimum XOOPS required: %s (your version is %s)');

// Admin link
\define('_CO_' . $moduleDirNameUpper . '_ADMIN', 'Admin');

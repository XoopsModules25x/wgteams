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
 * @package         wgteams
 * @author          Goffy - Wedega.com - Email:<webmaster@wedega.com> - Website:<https://wedega.com>
 */

$moduleDirName = \basename(\dirname(__DIR__, 2));
$moduleDirNameUpper = \mb_strtoupper($moduleDirName);

// General
\define('CO_' . $moduleDirNameUpper . '_' . 'CONFIRM', 'Bestätigen');
//Sample Data
\define('CO_' . $moduleDirNameUpper . '_' . 'ADD_SAMPLEDATA', 'Importe Beispieldaten (ALLE vorhandenen Daten werden gelöscht)');
\define('CO_' . $moduleDirNameUpper . '_' . 'SAMPLEDATA_SUCCESS', 'Beispieldaten erfolgreich geladen');
\define('CO_' . $moduleDirNameUpper . '_' . 'SAVE_SAMPLEDATA', 'Exportiere Tabellen nach YAML');
\define('CO_' . $moduleDirNameUpper . '_' . 'SAVE_SAMPLEDATA_SUCCESS', 'Tabellen-Export nach YAML erfolgreich');
\define('CO_' . $moduleDirNameUpper . '_' . 'SHOW_SAMPLE_BUTTON', 'Schaltfläche Import Beispieldaten anzeigen?');
\define('CO_' . $moduleDirNameUpper . '_' . 'SHOW_SAMPLE_BUTTON_DESC', 'Falls Ja, dann wird die Schaltfläche "Importe Beispieldaten" im Adminbereich sichtbar. Diese Option ist nach der Installation standardmäßig aktiviert.');
\define('CO_' . $moduleDirNameUpper . '_' . 'EXPORT_SCHEMA', 'Exportiere DB Schema nach YAML');
\define('CO_' . $moduleDirNameUpper . '_' . 'EXPORT_SCHEMA_SUCCESS', 'Export DB Schema nach YAML erfolgreich abgeschlossen');
\define('CO_' . $moduleDirNameUpper . '_' . 'EXPORT_SCHEMA_ERROR', 'Fehler: Export DB Schema nach YAML fehlgeschlagen');
\define('CO_' . $moduleDirNameUpper . '_' . 'ADD_SAMPLEDATA_OK', 'Sind Sie sicher, Beispieldaten zu importieren? (ALLE vorhandenen Daten werden gelöscht)');
\define('CO_' . $moduleDirNameUpper . '_' . 'HIDE_SAMPLEDATA_BUTTONS', 'Hide the Import buttons)');
\define('CO_' . $moduleDirNameUpper . '_' . 'SHOW_SAMPLEDATA_BUTTONS', 'Show the Import buttons)');

//Menu
\define('CO_' . $moduleDirNameUpper . '_' . 'ADMENU_MIGRATE', 'Migrate');
\define('CO_' . $moduleDirNameUpper . '_' . 'FOLDER_YES', 'Folder "%s" exist');
\define('CO_' . $moduleDirNameUpper . '_' . 'FOLDER_NO', 'Folder "%s" does not exist. Create the specified folder with CHMOD 777.');
\define('CO_' . $moduleDirNameUpper . '_' . 'SHOW_DEV_TOOLS', 'Show Development Tools Button?');
\define('CO_' . $moduleDirNameUpper . '_' . 'SHOW_DEV_TOOLS_DESC', 'If yes, the "Migrate" Tab and other Development tools will be visible to the Admin.');

//Latest Version Check
\define('CO_' . $moduleDirNameUpper . '_' . 'NEW_VERSION', 'Neue Version: ');
\define('CO_' . $moduleDirNameUpper . '_' . 'ERROR_BAD_XOOPS', 'Sie benötigen mindestens Version %s (Ihre derzeitige Version ist %s)');

// Admin link
\define('_CO_' . $moduleDirNameUpper . '_ADMIN', 'Admininistration');

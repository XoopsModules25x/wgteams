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
 
// ---------------- Main ----------------
\define('_MA_WGTEAMS_INDEX', 'Startseite');
\define('_MA_WGTEAMS_TITLE', 'wgTeams');
\define('_MA_WGTEAMS_DESC', 'Dieses Modul dient zur Präsentation Ihrer Teams');
\define('_MA_WGTEAMS_INDEX_DESC', 'Willkommen auf der Startseite Ihres neuen Moduls wgTeams!');
\define('_MA_WGTEAMS_NO_PDF_LIBRARY', "Libraries TCPDF nicht vorhanden, bitte in 'root/Frameworks' hochladen");
\define('_MA_WGTEAMS_NO', 'Nein');
\define('_MA_WGTEAMS_READMORE', 'Mehr lesen...');
// ---------------- Contents ----------------
// Team
\define('_MA_WGTEAMS_TEAM', 'Team');
\define('_MA_WGTEAMS_TEAMS', 'Teams');
\define('_MA_WGTEAMS_TEAMS_TITLE', 'Team-Titel');
\define('_MA_WGTEAMS_TEAM_DESC', 'Team Beschreibung');
\define('_MA_WGTEAMS_TEAMS_NODATA', 'Zur Zeit sind keine Teams zur Anzeige vorhanden');
// member
\define('_MA_WGTEAMS_MEMBER', 'Mitglied');
\define('_MA_WGTEAMS_MEMBERS', 'Mitglieder');
// Caption of members
\define('_MA_WGTEAMS_MEMBER_ID', 'Id');
\define('_MA_WGTEAMS_MEMBER_NAME', 'Name');
\define('_MA_WGTEAMS_MEMBER_FIRSTNAME', 'Vorname');
\define('_MA_WGTEAMS_MEMBER_LASTNAME', 'Familienname');
\define('_MA_WGTEAMS_MEMBER_TITLE', 'Titel');
\define('_MA_WGTEAMS_MEMBER_ADDRESS', 'Adresse');
\define('_MA_WGTEAMS_MEMBER_PHONE', 'Telefon');
\define('_MA_WGTEAMS_MEMBER_EMAIL', 'E-Mail');
\define('_MA_WGTEAMS_MEMBER_IMAGE', 'Bild');
\define('_MA_WGTEAMS_MEMBER_UID', 'Profil anzeigen');
// ---------------- End ----------------


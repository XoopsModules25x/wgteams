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
define('_AM_WGTEAMS_STATISTICS', 'Statistiken');
// There are
define('_AM_WGTEAMS_THEREARE_TEAMS', "Es gibt <span class='bold'>%s</span> Teams in der Datenbank");
define('_AM_WGTEAMS_THEREARE_MEMBERS', "Es gibt <span class='bold'>%s</span> Mitglieder in der Datenbank");
define('_AM_WGTEAMS_THEREARE_RELATIONS', "Es gibt <span class='bold'>%s</span> Beziehungen in der Datenbank");
define('_AM_WGTEAMS_THEREARE_INFOFIELDS', "Es gibt <span class='bold'>%s</span> Infofelder in der Datenbank");
// ---------------- Admin Files ----------------
// Es gibtn't
define('_AM_WGTEAMS_THEREARENT_TEAMS', 'Es gibt keine Teams');
define('_AM_WGTEAMS_THEREARENT_MEMBERS', 'Es gibt keine Mitglieder');
define('_AM_WGTEAMS_THEREARENT_RELATIONS', 'Es gibt keine Beziehungen');
define('_AM_WGTEAMS_THEREARENT_INFOFIELDS', 'Es gibt keine Infofelder');
// Save/Delete
define('_AM_WGTEAMS_FORM_OK', 'Erfolgreich gespeichert');
define('_AM_WGTEAMS_FORM_DELETE_OK', 'Erfolgreich gelöscht');
define('_AM_WGTEAMS_FORM_SURE_DELETE', "Wollen Sie <b><span style='color : Red;'>%s </span></b> wirklich löschen?");
define('_AM_WGTEAMS_FORM_SURE_RENEW', "Wollen sie <b><span style='color : Red;'>%s </span></b> wirklich aktualisieren");
// Lists
define('_AM_WGTEAMS_TEAMS_LIST', 'Teamliste');
define('_AM_WGTEAMS_MEMBERS_LIST', 'Mitgliederliste');
define('_AM_WGTEAMS_RELATIONS_LIST', 'Liste der Beziehungen');
define('_AM_WGTEAMS_INFOFIELDS_LIST', 'Liste der Infofelder');
// ---------------- Admin Classes ----------------
// Team add/edit
define('_AM_WGTEAMS_TEAM_ADD', 'Neues Team hinzufügen');
define('_AM_WGTEAMS_TEAM_EDIT', 'Team bearbeiten');
// Elements of Team
define('_AM_WGTEAMS_TEAM_ID', 'Id');
define('_AM_WGTEAMS_TEAM_NAME', 'Team-Name');
define('_AM_WGTEAMS_TEAM_DESCR', 'Team Beschreibung');
define('_AM_WGTEAMS_TEAM_IMAGE', 'Team Bild');
define('_AM_WGTEAMS_TEAM_IMAGES', 'Bilder Teams');
define('_AM_WGTEAMS_TEAM_NB_COLS', 'Anzahl Spalten');
define('_AM_WGTEAMS_TEAM_TABLESTYLE', 'Tabellenstyles');
define('_AM_WGTEAMS_TEAM_IMAGESTYLE', 'Bildstyles');
define('_AM_WGTEAMS_TEAM_DISPLAYSTYLE', 'Position des Mitgliedsbildes');
define('_AM_WGTEAMS_TEAM_WEIGHT', 'Reihung');
define('_AM_WGTEAMS_TEAM_ONLINE', 'Online');
// options _AM_WGTEAMS_TEAM_TABLESTYLE
define('_AM_WGTEAMS_TEAM_TABLESTYLE_DEF', 'Standard (Verwendung der Standardstyles)');
define('_AM_WGTEAMS_TEAM_TABLESTYLE_BORDERED', 'Bordered (fügt der Tabelle und den Zellen einen Rahmen hinzu)');
define('_AM_WGTEAMS_TEAM_TABLESTYLE_STRIPED', 'Striped (fügt allen Zeilen einen abwechselnd gestreiften Hintergrund hinzu)');
define('_AM_WGTEAMS_TEAM_TABLESTYLE_LINED', 'Lined (fügt den Zeilen einen oberen Rahmen hinzu');
// options _AM_WGTEAMS_TEAM_IMAGESTYLE
define('_AM_WGTEAMS_TEAM_IMAGESTYLE_DEF', 'Standard (Verwendung der Standard-Bildstyles)');
define('_AM_WGTEAMS_TEAM_IMAGESTYLE_CIRCLE', 'Circle (zeigt das Bild in Kreisform)');
define('_AM_WGTEAMS_TEAM_IMAGESTYLE_ROUNDED', 'Rounded (zeigt das Bild mit abgerundeten Ecken)');
define('_AM_WGTEAMS_TEAM_IMAGESTYLE_THUMBNAIL', 'Thumbnail (zeigt das Bild als Vorschaubild)');
// options _AM_WGTEAMS_TEAM_DISPLAYSTYLE
define('_AM_WGTEAMS_TEAM_DISPLAYSTYLE_LEFT', 'Links (auf der linken Seite des Textes)');
define('_AM_WGTEAMS_TEAM_DISPLAYSTYLE_DEF', 'Standard (oberhalb des Textes)');
define('_AM_WGTEAMS_TEAM_DISPLAYSTYLE_RIGHT', 'Rechts (auf der rechten Seite)');
define('_AM_WGTEAMS_TEAM_RELSCOUNT', 'Anzahl Mitglieder');
// member add/edit
define('_AM_WGTEAMS_MEMBER_ADD', 'Neues Mitglied hinzufügen');
define('_AM_WGTEAMS_MEMBER_EDIT', 'Mitglied bearbeiten');
// Elements of members
define('_AM_WGTEAMS_MEMBER_ID', 'Id');
define('_AM_WGTEAMS_MEMBER_FIRSTNAME', 'Vorname');
define('_AM_WGTEAMS_MEMBER_LASTNAME', 'Familienname');
define('_AM_WGTEAMS_MEMBER_TITLE', 'Titel');
define('_AM_WGTEAMS_MEMBER_ADDRESS', 'Adresse');
define('_AM_WGTEAMS_MEMBER_PHONE', 'Telefon');
define('_AM_WGTEAMS_MEMBER_EMAIL', 'E-Mail');
define('_AM_WGTEAMS_MEMBER_IMAGE', 'Bild');
define('_AM_WGTEAMS_MEMBER_IMAGES', 'Bilder Mitglieder');
define('_AM_WGTEAMS_MEMBER_UID', 'Xoops User Id');
define('_AM_WGTEAMS_MEMBER_UID_DESC', "<br><span style='font-size:90%'>Sie können das Mitglied direkt mit einem Xoops-User-Konto verknüpfen und ein entsprechender Link zum Öffnen des Profils wird angezeigt.<br>Wenn Sie 'Gast' auswählen dann erscheint keine Button.</span>");
// Relation add/edit
define('_AM_WGTEAMS_RELATION_ADD', 'Neue Beziehung erstellen');
define('_AM_WGTEAMS_RELATION_EDIT', 'Beziehung bearbeiten');
// Elements of Relation
define('_AM_WGTEAMS_RELATION_ID', 'Id');
define('_AM_WGTEAMS_RELATION_TEAM_ID', 'Teams');
define('_AM_WGTEAMS_RELATION_MEMBER_ID', 'Mitglieder');
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
define('_AM_WGTEAMS_RELATION_WEIGHT', 'Reihung');
define('_AM_WGTEAMS_RELATION_DELETE', "Wollen Sie '%n' aus '%t' wirklich entfernen");

// Infofield add/edit
define('_AM_WGTEAMS_INFOFIELD_ADD', 'Neues Infofeld erstellen');
define('_AM_WGTEAMS_INFOFIELD_EDIT', 'Infofeld bearbeiten');
// Elements of Infofield
define('_AM_WGTEAMS_INFOFIELD_ID', 'Feld-Id');
define('_AM_WGTEAMS_INFOFIELD_NAME', 'Feldname');
// General
define('_AM_WGTEAMS_FORM_UPLOAD', 'Datei hochladen');
define('_AM_WGTEAMS_FORM_UPLOAD_IMG', 'Neues Bild hochladen');
define('_AM_WGTEAMS_FORM_IMAGE_PATH', 'Dateien in %s ');
define('_AM_WGTEAMS_FORM_IMAGE_EXIST', 'Vorhandene Bilder');
define('_AM_WGTEAMS_FORM_ACTION', 'Aktion');
define('_AM_WGTEAMS_FORM_EDIT', 'Ändern');
define('_AM_WGTEAMS_FORM_DELETE', 'Löschen');
define('_AM_WGTEAMS_SUBMITTER', 'Ersteller');
define('_AM_WGTEAMS_DATE_CREATE', 'erstellt am');
// ---------------- Admin Others ----------------
define('_AM_WGTEAMS_MAINTAINEDBY', " wird unterstützt durch <a href='https://wedega.com'>https://wedega.com</a> und <a href='https://xoops.wedega.com'>https://xoops.wedega.com</a>");
define('_AM_WGTEAMS_MAX_FILESIZE', 'Maximale Dateigröße');
// image editor
define('_AM_WGTEAMS_IMG_EDITOR', 'Bildbearbeitung');
define('_AM_WGTEAMS_IMG_EDITOR_CREATE', 'Bild erstellen');
define('_AM_WGTEAMS_IMG_EDITOR_APPLY', 'Anwenden');
define('_AM_WGTEAMS_IMG_EDITOR_IMAGE_EDIT', 'Albumbild bearbeiten');
define('_AM_WGTEAMS_IMG_EDITOR_CURRENT', 'Aktuell');
define('_AM_WGTEAMS_IMG_EDITOR_USE_EXISTING', 'Vorhandenes Bild verwenden');
define('_AM_WGTEAMS_IMG_EDITOR_GRID', 'Bildercollage erstellen');
define('_AM_WGTEAMS_IMG_EDITOR_GRID4', '4 Bilder verwenden');
define('_AM_WGTEAMS_IMG_EDITOR_GRID6', '6 Bilder verwenden');
define('_AM_WGTEAMS_IMG_EDITOR_GRID_SRC1', 'Bild 1 auswählen');
define('_AM_WGTEAMS_IMG_EDITOR_GRID_SRC2', 'Bild 2 auswählen');
define('_AM_WGTEAMS_IMG_EDITOR_GRID_SRC3', 'Bild 3 auswählen');
define('_AM_WGTEAMS_IMG_EDITOR_GRID_SRC4', 'Bild 4 auswählen');
define('_AM_WGTEAMS_IMG_EDITOR_GRID_SRC5', 'Bild 5 auswählen');
define('_AM_WGTEAMS_IMG_EDITOR_GRID_SRC6', 'Bild 6 auswählen');
define('_AM_WGTEAMS_IMG_EDITOR_CROP', 'Bild zuschneiden');
define('_AM_WGTEAMS_IMG_EDITOR_CROP_MOVE', 'Verschieben');
define('_AM_WGTEAMS_IMG_EDITOR_CROP_ZOOMIN', 'Hineinzoomen');
define('_AM_WGTEAMS_IMG_EDITOR_CROP_ZOOMOUT', 'Herauszoomen');
define('_AM_WGTEAMS_IMG_EDITOR_CROP_MOVE_LEFT', 'Nach links verschieben');
define('_AM_WGTEAMS_IMG_EDITOR_CROP_MOVE_RIGHT', 'Nach rechts verschieben');
define('_AM_WGTEAMS_IMG_EDITOR_CROP_MOVE_UP', 'Nach oben verschieben');
define('_AM_WGTEAMS_IMG_EDITOR_CROP_MOVE_DOWN', 'Nach unten verschieben');
define('_AM_WGTEAMS_IMG_EDITOR_CROP_ROTATE_LEFT', 'Links drehen');
define('_AM_WGTEAMS_IMG_EDITOR_CROP_ROTATE_RIGHT', 'Rechts drehen');
define('_AM_WGTEAMS_IMG_EDITOR_CROP_FLIP_HORIZONTAL', 'Horizontal spiegeln');
define('_AM_WGTEAMS_IMG_EDITOR_CROP_FLIP_VERTICAL', 'Vertikal spiegeln');
define('_AM_WGTEAMS_IMG_EDITOR_CROP_ASPECTRATIO', 'Seitenverhältnis');
define('_AM_WGTEAMS_IMG_EDITOR_CROP_ASPECTRATIO_FREE', 'Frei');
define('_AM_WGTEAMS_IMG_EDITOR_CURRENT2', 'Quelle für aktuelles Bild');
define('_AM_WGTEAMS_IMG_EDITOR_RESXY', 'Auflösung');
define('_AM_WGTEAMS_IMG_EDITOR_UPLOAD', 'Voraussetzungen für Bilderupload');
define('_AM_WGTEAMS_IMG_EDITOR_RESIZE', 'Bild automatisch verkleinern');
define('_AM_WGTEAMS_IMG_EDITOR_RESIZE_DESC', 'Bild automatisch auf folgende Standardwerte verkleinern: Breite max. %w px / Höhe max. %h px');
define('_AM_WGTEAMS_FORM_ERROR_INVALID_ID', 'Invalid ID');

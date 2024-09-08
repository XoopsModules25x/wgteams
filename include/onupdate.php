<?php

declare(strict_types=1);

/*
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright    XOOPS Project https://xoops.org/
 * @license      GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @package         wgteams
 * @author          Goffy - Wedega.com - Email:<webmaster@wedega.com> - Website:<https://wedega.com>
 */

use XoopsModules\Wgteams;
use XoopsModules\Wgteams\Common\ {
    Configurator,
    Migrate,
    MigrateHelper
};

if ((!\defined('XOOPS_ROOT_PATH')) || !($GLOBALS['xoopsUser'] instanceof \XoopsUser)
    || !$GLOBALS['xoopsUser']->IsAdmin()) {
    exit('Restricted access' . PHP_EOL);
}

/**
 * Prepares system prior to attempting to install module
 * @param \XoopsModule $module {@link XoopsModule}
 *
 * @return bool true if ready to install, false if not
 */
function xoops_module_pre_update_wgteams(\XoopsModule $module)
{
    $utility = new Wgteams\Utility();

    $xoopsSuccess = $utility::checkVerXoops($module);
    $phpSuccess   = $utility::checkVerPhp($module);

    return $xoopsSuccess && $phpSuccess;
}

/**
 * Performs tasks required during update of the module
 * @param \XoopsModule $module {@link XoopsModule}
 * @param null        $previousVersion
 *
 * @return bool true if update successful, false if not
 */
function xoops_module_update_wgteams(\XoopsModule $module, $previousVersion = null)
{
    $moduleDirName = $module->dirname();


    $ret = wgteams_check_db($module);

    //check upload directory
    require_once __DIR__ . '/oninstall.php';
    $ret = xoops_module_install_wgteams($module);

    // update DB corresponding to sql/mysql.sql
    $configurator = new Configurator();
    $migrate = new Migrate($configurator);

    $fileSql = \XOOPS_ROOT_PATH . '/modules/' . $moduleDirName . '/sql/mysql.sql';
    // ToDo: add function setDefinitionFile to .\class\libraries\vendor\xoops\xmf\src\Database\Migrate.php
    // Todo: once we are using setDefinitionFile this part has to be adapted
    //$fileYaml = \XOOPS_ROOT_PATH . '/modules/' . $moduleDirName . '/sql/update_' . $moduleDirName . '_migrate.yml';
    //try {
    //$migrate->setDefinitionFile('update_' . $moduleDirName);
    //} catch (\Exception $e) {
    // as long as this is not done default file has to be created
    $moduleVersionOld = $module->getInfo('version');
    $moduleVersionNew = \str_replace(['.', '-'], '_', $moduleVersionOld);
    $fileYaml = \XOOPS_ROOT_PATH . '/modules/' . $moduleDirName . "/sql/{$moduleDirName}_{$moduleVersionNew}_migrate.yml";
    //}

    // create a schema file based on sql/mysql.sql
    $migratehelper = new MigrateHelper($fileSql, $fileYaml);
    if (!$migratehelper->createSchemaFromSqlfile()) {
        \xoops_error('Error: creation schema file failed!');
        return false;
    }

    //create copy for XOOPS 2.5.11 Beta 1 and older versions
    $fileYaml2 = \XOOPS_ROOT_PATH . '/modules/' . $moduleDirName . "/sql/{$moduleDirName}_{$moduleVersionOld}_migrate.yml";
    \copy($fileYaml, $fileYaml2);

    // run standard procedure for db migration
    $migrate->synchronizeSchema();
    
    // maintenance of tables
    $ret = maintaintables($module);

    return $ret;
}

/**
 * repair errors in data (caused by former versions of wgteams)
 * @param mixed $module
 * @return bool
 */
function maintaintables(&$module)
{
    global $xoopsDB;
    $sql = 'DELETE '
           . $xoopsDB->prefix('wgteams_relations')
           . '.* FROM '
           . $xoopsDB->prefix('wgteams_relations')
           . ' LEFT JOIN '
           . $xoopsDB->prefix('wgteams_members')
           . ' ON '
           . $xoopsDB->prefix('wgteams_relations')
           . '.rel_member_id = '
           . $xoopsDB->prefix('wgteams_members')
           . '.member_id WHERE ((('
           . $xoopsDB->prefix('wgteams_members')
           . '.member_id) Is Null));';
    if (!$result = $xoopsDB->queryF($sql)) {
        xoops_error($xoopsDB->error() . '<br>' . $sql);
        $module->setErrors("Error maintain table 'wgteams_relations' concerning members");

        return false;
    }
    $sql = 'DELETE '
           . $xoopsDB->prefix('wgteams_relations')
           . '.* FROM '
           . $xoopsDB->prefix('wgteams_relations')
           . ' LEFT JOIN '
           . $xoopsDB->prefix('wgteams_teams')
           . ' ON '
           . $xoopsDB->prefix('wgteams_relations')
           . '.rel_team_id = '
           . $xoopsDB->prefix('wgteams_teams')
           . '.team_id WHERE ((('
           . $xoopsDB->prefix('wgteams_teams')
           . '.team_id) Is Null));';
    if (!$result = $xoopsDB->queryF($sql)) {
        xoops_error($xoopsDB->error() . '<br>' . $sql);
        $module->setErrors("Error maintain table 'wgteams_relations' concerning teams");

        return false;
    }

    return true;
}

/**
 * @param $module
 *
 * @return bool
 */
function wgteams_check_db($module)
{
    $ret = true;
    //insert here code for database check

    /*
    // Example: update table (add new field)
    $table   = $GLOBALS['xoopsDB']->prefix('wgteams_images');
    $field   = 'img_exif';
    $check   = $GLOBALS['xoopsDB']->queryF('SHOW COLUMNS FROM `' . $table . "` LIKE '" . $field . "'");
    $numRows = $GLOBALS['xoopsDB']->getRowsNum($check);
    if (!$numRows) {
        $sql = "ALTER TABLE `$table` ADD `$field` TEXT NULL AFTER `img_state`;";
        if (!$result = $GLOBALS['xoopsDB']->queryF($sql)) {
            xoops_error($GLOBALS['xoopsDB']->error() . '<br>' . $sql);
            $module->setErrors("Error when adding '$field' to table '$table'.");
            $ret = false;
        }
    }

    // Example: create new table
    $table   = $GLOBALS['xoopsDB']->prefix('wgteams_categories');
    $check   = $GLOBALS['xoopsDB']->queryF("SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='$table'");
    $numRows = $GLOBALS['xoopsDB']->getRowsNum($check);
    if (!$numRows) {
        // create new table 'wgteams_categories'
        $sql = "CREATE TABLE `$table` (
                  `cat_id`        INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
                  `cat_text`      VARCHAR(100)    NOT NULL DEFAULT '',
                  `cat_date`      INT(8)          NOT NULL DEFAULT '0',
                  `cat_submitter` INT(8)          NOT NULL DEFAULT '0',
                  PRIMARY KEY (`cat_id`)
                ) ENGINE=InnoDB;";
        if (!$result = $GLOBALS['xoopsDB']->queryF($sql)) {
            xoops_error($GLOBALS['xoopsDB']->error() . '<br>' . $sql);
            $module->setErrors("Error when creating table '$table'.");
            $ret = false;
        }
    }
    */
    return $ret;
}

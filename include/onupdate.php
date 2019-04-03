<?php
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
 * @package
 * @since
 * @author       XOOPS Development Team
 */

use XoopsModules\Wgteams;

if ((!defined('XOOPS_ROOT_PATH')) || !($GLOBALS['xoopsUser'] instanceof \XoopsUser)
    || !$GLOBALS['xoopsUser']->IsAdmin()) {
    exit('Restricted access' . PHP_EOL);
}

/**
 * @param string $tablename
 *
 * @return bool
 */
function tableExists($tablename)
{
    $result = $GLOBALS['xoopsDB']->queryF("SHOW TABLES LIKE '$tablename'");

    return ($GLOBALS['xoopsDB']->getRowsNum($result) > 0) ? true : false;
}

/**
 * Prepares system prior to attempting to install module
 * @param \XoopsModule $module {@link XoopsModule}
 *
 * @return bool true if ready to install, false if not
 */
function xoops_module_pre_update_wgteams(\XoopsModule $module)
{
    $moduleDirName = basename(dirname(__DIR__));
    /** @var Wgteams\Helper $helper */
    /** @var Wgteams\Utility $utility */
    $helper  = Wgteams\Helper::getInstance();
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
    $moduleDirName      = basename(dirname(__DIR__));
    $moduleDirNameUpper = mb_strtoupper($moduleDirName);

    /** @var Wgteams\Helper $helper */
    /** @var Wgteams\Utility $utility */
    /** @var Wgteams\Common\Configurator $configurator */
    $helper       = Wgteams\Helper::getInstance();
    $utility      = new Wgteams\Utility();
    $configurator = new Wgteams\Common\Configurator();

	//  ---  DELETE OLD FILES ---------------
	if (count($configurator->oldFiles) > 0) {
		//    foreach (array_keys($GLOBALS['uploadFolders']) as $i) {
		foreach (array_keys($configurator->oldFiles) as $i) {
			$tempFile = $GLOBALS['xoops']->path('modules/' . $moduleDirName . $configurator->oldFiles[$i]);
			if (is_file($tempFile)) {
				unlink($tempFile);
			}
		}
	}

	//  ---  DELETE OLD FOLDERS ---------------
	xoops_load('XoopsFile');
	if (count($configurator->oldFolders) > 0) {
		//    foreach (array_keys($GLOBALS['uploadFolders']) as $i) {
		foreach (array_keys($configurator->oldFolders) as $i) {
			$tempFolder = $GLOBALS['xoops']->path('modules/' . $moduleDirName . $configurator->oldFolders[$i]);
			/* @var XoopsObjectHandler $folderHandler */
			$folderHandler = \XoopsFile::getHandler('folder', $tempFolder);
			$folderHandler->delete($tempFolder);
		}
	}

	//  ---  CREATE FOLDERS ---------------
	if (count($configurator->uploadFolders) > 0) {
		//    foreach (array_keys($GLOBALS['uploadFolders']) as $i) {
		foreach (array_keys($configurator->uploadFolders) as $i) {
			$utility::createFolder($configurator->uploadFolders[$i]);
		}
	}

	//  ---  COPY blank.png FILES ---------------
	if (count($configurator->copyBlankFiles) > 0) {
		$file = dirname(__DIR__) . '/assets/images/blank.png';
		foreach (array_keys($configurator->copyBlankFiles) as $i) {
			$dest = $configurator->copyBlankFiles[$i] . '/blank.png';
			$utility::copyFile($file, $dest);
		}
	}

	//delete .html entries from the tpl table
	$sql = 'DELETE FROM ' . $GLOBALS['xoopsDB']->prefix('tplfile') . " WHERE `tpl_module` = '" . $module->getVar('dirname', 'n') . '\' AND `tpl_file` LIKE \'%.html%\'';
	$GLOBALS['xoopsDB']->queryF($sql);
	
	// maintenance of tables
    $ret = maintaintables($module);

    return true;
}

/**
 * repair errors in data (caused by former versions of wgteams)
 * @param: $module
 *
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

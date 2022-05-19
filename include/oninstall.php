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
 * @package
 * @since
 * @author       XOOPS Development Team
 */

use XoopsModules\Wgteams;
use XoopsModules\Wgteams\Common;

/**
 * Prepares system prior to attempting to install module
 * @param \XoopsModule $module {@link XoopsModule}
 *
 * @return bool true if ready to install, false if not
 */
function xoops_module_pre_install_wgteams(\XoopsModule $module)
{
    require \dirname(__DIR__) . '/preloads/autoloader.php';

    $utility      = new \XoopsModules\Wgteams\Utility();
    $xoopsSuccess = $utility::checkVerXoops($module);
    $phpSuccess   = $utility::checkVerPhp($module);

    if (false !== $xoopsSuccess && false !== $phpSuccess) {
        $moduleTables = &$module->getInfo('tables');
        foreach ($moduleTables as $table) {
            $GLOBALS['xoopsDB']->queryF('DROP TABLE IF EXISTS ' . $GLOBALS['xoopsDB']->prefix($table) . ';');
        }
    }

    return $xoopsSuccess && $phpSuccess;
}

/**
 * Performs tasks required during installation of the module
 * @param \XoopsModule $module {@link XoopsModule}
 *
 * @return bool true if installation successful, false if not
 */
function xoops_module_install_wgteams(\XoopsModule $module)
{
    require_once \dirname(__DIR__, 3) . '/mainfile.php';

    $moduleDirName      = \basename(\dirname(__DIR__));

    $helper       = Wgteams\Helper::getInstance();
    $utility      = new Wgteams\Utility();
    $configurator = new Wgteams\Common\Configurator();
    
    // Load language files
    $helper->loadLanguage('admin');
    $helper->loadLanguage('modinfo');
    $helper->loadLanguage('common');


    //  ---  CREATE FOLDERS ---------------
    if (\count($configurator->uploadFolders) > 0) {
        //    foreach (\array_keys($GLOBALS['uploadFolders']) as $i) {
        foreach (\array_keys($configurator->uploadFolders) as $i) {
            $utility::createFolder($configurator->uploadFolders[$i]);
            chmod($configurator->uploadFolders[$i], 0777);
        }
    }

    //  ---  COPY blank.png FILES ---------------
    if (\count($configurator->copyBlankFiles) > 0) {
        $file = \dirname(__DIR__) . '/assets/images/blank.gif';
        foreach (\array_keys($configurator->copyBlankFiles) as $i) {
            $dest = $configurator->copyBlankFiles[$i] . '/blank.gif';
            $utility::copyFile($file, $dest);
        }
    }
    
        //  ---  DELETE OLD FILES ---------------
    if (\count($configurator->oldFiles) > 0) {
        foreach (\array_keys($configurator->oldFiles) as $i) {
            $tempFile = $GLOBALS['xoops']->path('modules/' . $moduleDirName . $configurator->oldFiles[$i]);
            if (\is_file($tempFile)) {
                \unlink($tempFile);
            }
        }
    }

    //  ---  DELETE OLD FOLDERS ---------------
    \xoops_load('XoopsFile');
    if (\count($configurator->oldFolders) > 0) {
        foreach (\array_keys($configurator->oldFolders) as $i) {
            $tempFolder = $GLOBALS['xoops']->path('modules/' . $moduleDirName . $configurator->oldFolders[$i]);
            /* @var XoopsObjectHandler $folderHandler */
            $folderHandler = \XoopsFile::getHandler('folder', $tempFolder);
            $folderHandler->delete($tempFolder);
        }
    }

    //delete .html entries from the tpl table
    $sql = 'DELETE FROM ' . $GLOBALS['xoopsDB']->prefix('tplfile') . " WHERE `tpl_module` = '" . $module->getVar('dirname', 'n') . "' AND `tpl_file` LIKE '%.html%'";
    $GLOBALS['xoopsDB']->queryF($sql);

    return true;
}

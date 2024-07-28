<?php

declare(strict_types=1);

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

use XoopsModules\Wgteams\{
    Helper,
    TeamsHandler,
    MembersHandler,
    RelationsHandler,
    InfofieldsHandler
};

require \dirname(__DIR__, 3) . '/include/cp_header.php';
$thisPath = \dirname(__DIR__);
require_once $thisPath . '/include/common.php';
$pathIcon16      = '../' . $GLOBALS['xoopsModule']->getInfo('sysicons16');
$pathIcon32      = '../' . $GLOBALS['xoopsModule']->getInfo('sysicons32');
$pathModuleAdmin = $GLOBALS['xoopsModule']->getInfo('dirmoduleadmin');
$pathModIcon16   = $GLOBALS['xoopsModule']->getInfo('modicons16');
$pathModIcon32   = $GLOBALS['xoopsModule']->getInfo('modicons32');
// Get instance of module
$helper            = Helper::getInstance();
$db                = \XoopsDatabaseFactory::getDatabaseConnection();
$teamsHandler      = new TeamsHandler($db); //$helper->getHandler('Teams');
$membersHandler    = new MembersHandler($db); //$helper->getHandler('Members');
$relationsHandler  = new RelationsHandler($db); //$helper->getHandler('Relations');
$infofieldsHandler = new InfofieldsHandler($db); //$helper->getHandler('Infofields');

$myts = \MyTextSanitizer::getInstance();
if (!isset($xoopsTpl) || !\is_object($xoopsTpl)) {
    require_once \XOOPS_ROOT_PATH . '/class/template.php';
    $xoopsTpl = new \XoopsTpl();
}

//Load languages
$helper->loadLanguage('admin');
$helper->loadLanguage('modinfo');

/** @var Xmf\Module\Admin $adminObject */
$adminObject = \Xmf\Module\Admin::getInstance();

xoops_cp_header();

// System icons path
$xoopsTpl->assign('pathIcon16', $pathIcon16);
$xoopsTpl->assign('pathIcon32', $pathIcon32);
// Local icons path

$xoopsTpl->assign('pathModIcon16', \XOOPS_URL . '/modules/' . $moduleDirName . '/' . $pathModIcon16);
$xoopsTpl->assign('pathModIcon32', \XOOPS_URL . '/modules/' . $moduleDirName . '/' . $pathModIcon32);

//load stylesheets and jquery for sortable
$GLOBALS['xoTheme']->addStylesheet(\WGTEAMS_URL . '/assets/css/admin/style.css');
$GLOBALS['xoTheme']->addScript(\WGTEAMS_URL . '/assets/js/jquery.js');
$GLOBALS['xoTheme']->addScript(\WGTEAMS_URL . '/assets/js/jquery-ui.js');
//$GLOBALS['xoTheme']->addScript(\WGTEAMS_URL . '/assets/js/sortable.js');

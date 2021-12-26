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
 * @since           1.0
 * @min_xoops       2.5.7
 * @author          Goffy - Wedega.com - Email:<webmaster@wedega.com> - Website:<https://wedega.com>
 * @version         $Id: 1.0 header.php 1 Sun 2015/12/27 23:18:01Z Goffy - Wedega $
 */

use XoopsModules\Wgteams;

require dirname(dirname(__DIR__)) . '/mainfile.php';
require __DIR__ . '/include/common.php';
$dirname = basename(__DIR__);
// Breadcrumbs
$xoBreadcrumbs   = [];
// Get instance of module
$db                = \XoopsDatabaseFactory::getDatabaseConnection();
$teamsHandler      = new Wgteams\TeamsHandler($db);
$membersHandler    = new Wgteams\MembersHandler($db);
$relationsHandler  = new Wgteams\RelationsHandler($db);
$infofieldsHandler = new Wgteams\InfofieldsHandler($db);

// Permission
require_once XOOPS_ROOT_PATH . '/class/xoopsform/grouppermform.php';
$grouppermHandler = xoops_getHandler('groupperm');
if (is_object($xoopsUser)) {
    $groups = $xoopsUser->getGroups();
} else {
    $groups = XOOPS_GROUP_ANONYMOUS;
}

$myts = \MyTextSanitizer::getInstance();
if (!file_exists($style = WGTEAMS_URL . '/assets/css/style.css')) {
    return false;
}

$pathIcon16      = $GLOBALS['xoopsModule']->getInfo('sysicons16');
$pathIcon32      = $GLOBALS['xoopsModule']->getInfo('sysicons32');
$pathModuleAdmin = $GLOBALS['xoopsModule']->getInfo('dirmoduleadmin');

$pathModIcon16 = $xoopsModule->getInfo('modicons16');
$pathModIcon32 = $xoopsModule->getInfo('modicons32');

xoops_loadLanguage('modinfo', $dirname);
xoops_loadLanguage('main', $dirname);

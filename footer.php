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
 * @version         $Id: 1.0 footer.php 1 Sun 2015/12/27 23:18:01Z Goffy - Wedega $
 */
$GLOBALS['xoopsTpl']->assign('xoBreadcrumbs', $xoBreadcrumbs);

$pathIcon16 = $GLOBALS['xoopsModule']->getInfo('sysicons16');
$pathIcon32 = $GLOBALS['xoopsModule']->getInfo('sysicons32');
$GLOBALS['xoopsTpl']->assign('pathIcon32', $pathIcon32);
$GLOBALS['xoopsTpl']->assign('wgteams_url', \WGTEAMS_URL);
$GLOBALS['xoopsTpl']->assign('adv', xoops_getModuleOption('advertise', $dirname));

$GLOBALS['xoopsTpl']->assign('bookmarks', xoops_getModuleOption('bookmarks', $dirname));
$GLOBALS['xoopsTpl']->assign('fbcomments', xoops_getModuleOption('fbcomments', $dirname));

$GLOBALS['xoopsTpl']->assign('admin', \WGTEAMS_ADMIN);
if ($helper->getConfig('show_copyright')) {
    $GLOBALS['xoopsTpl']->assign('copyright', $copyright);
}
// User footer
require_once \XOOPS_ROOT_PATH . '/footer.php';

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
 * @author          Goffy - Wedega.com - Email:<webmaster@wedega.com> - Website:<http://wedega.com>
 * @version         $Id: 1.0 infofields.php 1 Sun 2015/12/27 23:18:00Z Goffy - Wedega $
 */
include __DIR__ . '/header.php';
// It recovered the value of argument op in URL$ 
$op = XoopsRequest::getString('op', 'list');
// Request infofield_id
$addField_id = XoopsRequest::getInt('infofield_id', 0);
// Switch options
switch ($op) {
    case 'list':
    default:
        $start        = XoopsRequest::getInt('start', 0);
        $limit        = XoopsRequest::getInt('limit', $wgteams->getConfig('adminpager'));
        $templateMain = 'wgteams_admin_infofields.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminMenu->addNavigation('infofields.php'));
        $adminMenu->addItemButton(_AM_WGTEAMS_INFOFIELD_ADD, 'infofields.php?op=new', 'add');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminMenu->renderButton());
        $infofieldsCount = $infofieldsHandler->getCountInfofields();
        $infofieldsAll   = $infofieldsHandler->getAllInfofields($start, $limit);
        $GLOBALS['xoopsTpl']->assign('infofields_count', $infofieldsCount);
        $GLOBALS['xoopsTpl']->assign('wgteams_url', WGTEAMS_URL);
        $GLOBALS['xoopsTpl']->assign('wgteams_upload_url', WGTEAMS_UPLOAD_URL);
        // Table view
        if ($infofieldsCount > 0) {
            foreach (array_keys($infofieldsAll) as $i) {
                $infofield = $infofieldsAll[$i]->getValuesInfofields();
                $GLOBALS['xoopsTpl']->append('infofields_list', $infofield);
                unset($infofield);
            }
            if ($infofieldsCount > $limit) {
                include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
                $pagenav = new XoopsPageNav($infofieldsCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
            }
        } else {
            $GLOBALS['xoopsTpl']->assign('error', _AM_WGTEAMS_THEREARENT_INFOFIELDS);
        }
        break;

    case 'new':
        $templateMain = 'wgteams_admin_infofields.tpl';
        $adminMenu->addItemButton(_AM_WGTEAMS_INFOFIELDS_LIST, 'infofields.php', 'list');
        $GLOBALS['xoopsTpl']->assign('navigation', $adminMenu->addNavigation('infofields.php'));
        $GLOBALS['xoopsTpl']->assign('buttons', $adminMenu->renderButton());
        // Get Form
        $infofieldsObj = $infofieldsHandler->create();
        $form          = $infofieldsObj->getFormInfofields();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;

    case 'save':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header('infofields.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if (isset($addField_id)) {
            $infofieldsObj = $infofieldsHandler->get($addField_id);
        } else {
            $infofieldsObj = $infofieldsHandler->create();
        }
        // Set Vars
        // Set Var infofield_name
        $infofieldsObj->setVar('infofield_name', $_POST['infofield_name']);
        // Set Var infofield_submitter
        $infofieldsObj->setVar('infofield_submitter', $_POST['infofield_submitter']);
        // Set Var infofield_date_created
        $infofieldsObj->setVar('infofield_date_created', time());
        // Insert Data
        if ($infofieldsHandler->insert($infofieldsObj)) {
            redirect_header('infofields.php?op=list', 2, _AM_WGTEAMS_FORM_OK);
        }
        // Get Form
        $GLOBALS['xoopsTpl']->assign('error', $infofieldsObj->getHtmlErrors());
        $form = $infofieldsObj->getFormInfofields();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;

    case 'edit':
        $templateMain = 'wgteams_admin_infofields.tpl';
        $adminMenu->addItemButton(_AM_WGTEAMS_INFOFIELD_ADD, 'infofields.php?op=new', 'add');
        $adminMenu->addItemButton(_AM_WGTEAMS_INFOFIELDS_LIST, 'infofields.php', 'list');
        $GLOBALS['xoopsTpl']->assign('navigation', $adminMenu->addNavigation('infofields.php'));
        $GLOBALS['xoopsTpl']->assign('buttons', $adminMenu->renderButton());
        // Get Form
        $infofieldsObj = $infofieldsHandler->get($addField_id);
        $form          = $infofieldsObj->getFormInfofields();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;

    case 'delete':
        $infofieldsObj = $infofieldsHandler->get($addField_id);
        if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                redirect_header('infofields.php', 3, implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($infofieldsHandler->delete($infofieldsObj)) {
                redirect_header('infofields.php', 3, _AM_WGTEAMS_FORM_DELETE_OK);
            } else {
                $GLOBALS['xoopsTpl']->assign('error', $infofieldsObj->getHtmlErrors());
            }
        } else {
            xoops_confirm(array('ok' => 1, 'infofield_id' => $addField_id, 'op' => 'delete'), $_SERVER['REQUEST_URI'], sprintf(_AM_WGTEAMS_FORM_SURE_DELETE, $infofieldsObj->getVar('infofield_name')));
        }
        break;
}

include __DIR__ . '/footer.php';

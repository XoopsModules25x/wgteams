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

use Xmf\Request;

require __DIR__ . '/header.php';
// It recovered the value of argument op in URL$
$op = Request::getString('op', 'list');
// Request infofield_id
$addField_id = Request::getInt('infofield_id');
// Switch options
switch ($op) {
    case 'list':
    default:
        $start        = Request::getInt('start');
        $limit        = Request::getInt('limit', $helper->getConfig('adminpager'));
        $templateMain = 'wgteams_admin_infofields.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('infofields.php'));
        $adminObject->addItemButton(_AM_WGTEAMS_INFOFIELD_ADD, 'infofields.php?op=new');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left', ''));
        $infofieldsCount = $infofieldsHandler->getCountInfofields();
        $infofieldsAll   = $infofieldsHandler->getAllInfofields($start, $limit);
        $GLOBALS['xoopsTpl']->assign('infofields_count', $infofieldsCount);
        $GLOBALS['xoopsTpl']->assign('wgteams_url', \WGTEAMS_URL);
        $GLOBALS['xoopsTpl']->assign('wgteams_upload_url', \WGTEAMS_UPLOAD_URL);
        // Table view
        if ($infofieldsCount > 0) {
            foreach (\array_keys($infofieldsAll) as $i) {
                $infofield = $infofieldsAll[$i]->getValuesInfofields();
                $GLOBALS['xoopsTpl']->append('infofields_list', $infofield);
                unset($infofield);
            }
            if ($infofieldsCount > $limit) {
                require_once \XOOPS_ROOT_PATH . '/class/pagenav.php';
                $pagenav = new \XoopsPageNav($infofieldsCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav());
            }
        } else {
            $GLOBALS['xoopsTpl']->assign('error', _AM_WGTEAMS_THEREARENT_INFOFIELDS);
        }
        break;
    case 'new':
        $templateMain = 'wgteams_admin_infofields.tpl';
        $adminObject->addItemButton(_AM_WGTEAMS_INFOFIELDS_LIST, 'infofields.php', 'list');
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('infofields.php'));
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left', ''));
        // Get Form
        $infofieldsObj = $infofieldsHandler->create();
        $form          = $infofieldsObj->getFormInfofields();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'save':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            \redirect_header('infofields.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if (isset($addField_id)) {
            $infofieldsObj = $infofieldsHandler->get($addField_id);
        } else {
            $infofieldsObj = $infofieldsHandler->create();
        }
        // Set Vars
        $infofieldsObj->setVar('infofield_name', Request::getString('infofield_name'));
        $infofieldsObj->setVar('infofield_class', Request::getInt('infofield_class'));
        $infofieldsObj->setVar('infofield_submitter', Request::getInt('infofield_submitter'));
        $infofieldsObj->setVar('infofield_date_created', \time());
        // Insert Data
        if ($infofieldsHandler->insert($infofieldsObj)) {
            \redirect_header('infofields.php?op=list', 2, _AM_WGTEAMS_FORM_OK);
        }
        // Get Form
        $GLOBALS['xoopsTpl']->assign('error', $infofieldsObj->getHtmlErrors());
        $form = $infofieldsObj->getFormInfofields();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'edit':
        $templateMain = 'wgteams_admin_infofields.tpl';
        $adminObject->addItemButton(_AM_WGTEAMS_INFOFIELD_ADD, 'infofields.php?op=new');
        $adminObject->addItemButton(_AM_WGTEAMS_INFOFIELDS_LIST, 'infofields.php', 'list');
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('infofields.php'));
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left', ''));
        // Get Form
        $infofieldsObj = $infofieldsHandler->get($addField_id);
        $form          = $infofieldsObj->getFormInfofields();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'delete':
        $infofieldsObj = $infofieldsHandler->get($addField_id);
        if (1 == Request::getInt('ok', 0)) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                \redirect_header('infofields.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            // Get the handler for Relations
            $relationsHandler = $helper->getHandler('Relations');

            // Get all Relations objects
            $allRelations = $relationsHandler->getAll();

            // Go through all Relations objects
            foreach ($allRelations as $relation) {
                $relationModified = false;

                // Check each rel_info_X_field
                for ($i = 1; $i <= 5; $i++) {
                    $infoFieldVar = 'rel_info_' . $i . '_field';
                    $infoVar = 'rel_info_' . $i;

                    // If the Relation has the Infofield that is being deleted, clear the corresponding rel_info_X field
                    if ($relation->getVar($infoFieldVar) == $addField_id) {
                        $relation->setVar($infoFieldVar, 0);
                        $relation->setVar($infoVar, '');
                        $relationModified = true;
                    }
                }

                // If the Relation was modified, update it in the database
                if ($relationModified) {
                    $relationsHandler->insert($relation);
                }
            }

            if ($infofieldsHandler->delete($infofieldsObj)) {
                \redirect_header('infofields.php', 3, _AM_WGTEAMS_FORM_DELETE_OK);
            } else {
                $GLOBALS['xoopsTpl']->assign('error', $infofieldsObj->getHtmlErrors());
            }
        } else {
            xoops_confirm(['ok' => 1, 'infofield_id' => $addField_id, 'op' => 'delete'], $_SERVER['REQUEST_URI'], \sprintf(_AM_WGTEAMS_FORM_SURE_DELETE, $infofieldsObj->getVar('infofield_name')));
        }
        break;
}

require __DIR__ . '/footer.php';

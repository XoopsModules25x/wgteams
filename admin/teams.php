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
 * @version         $Id: 1.0 teams.php 1 Sun 2015/12/27 23:18:00Z Goffy - Wedega $
 */

use Xmf\Request;
use XoopsModules\Wgteams;

require __DIR__ . '/header.php';
// It recovered the value of argument op in URL$
$op = Request::getString('op', 'list');
// Request team_id
$teamId = Request::getInt('team_id', 0);
// Switch options
switch ($op) {
    case 'list':
    default:
        $GLOBALS['xoTheme']->addScript(\WGTEAMS_URL . '/assets/js/sortable-teams.js');
        $start        = Request::getInt('start', 0);
        $limit        = Request::getInt('limit', $helper->getConfig('adminpager'));
        $templateMain = 'wgteams_admin_teams.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('teams.php'));
        $adminObject->addItemButton(_AM_WGTEAMS_TEAM_ADD, 'teams.php?op=new', 'add');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left', ''));
        $teamsCount = $teamsHandler->getCountTeams();
        $teamsAll   = $teamsHandler->getAllTeams($start, $limit);
        $GLOBALS['xoopsTpl']->assign('teams_count', $teamsCount);
        $GLOBALS['xoopsTpl']->assign('wgteams_url', \WGTEAMS_URL);
        $GLOBALS['xoopsTpl']->assign('wgteams_upload_url', \WGTEAMS_UPLOAD_URL);
        $GLOBALS['xoopsTpl']->assign('wgteams_icons_url', \WGTEAMS_ICONS_URL);
        // Table view
        if ($teamsCount > 0) {
            foreach (\array_keys($teamsAll) as $i) {
                $team = $teamsAll[$i]->getValuesTeams();
                if ('blank.gif' == $team['image']) {
                    $team['image'] = false;
                } else {
                    $image = \WGTEAMS_UPLOAD_PATH . '/teams/images/' . $team['image'];
                    $team['image_resxy'] = '0 x 0';
                    if (\file_exists($image)) {
                        $size = \getimagesize($image);
                        $team['image_resxy'] = $size[0] . ' x ' . $size[1];
                    }
                }
                $crit_rels = new \CriteriaCompo();
                $crit_rels->add(new \Criteria('rel_team_id', $team['team_id']));
                $team['relscount'] = $relationsHandler->getCount($crit_rels);
                $GLOBALS['xoopsTpl']->append('teams_list', $team);
                unset($team);
            }
            if ($teamsCount > $limit) {
                require_once \XOOPS_ROOT_PATH . '/class/pagenav.php';
                $pagenav = new \XoopsPageNav($teamsCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
            }
        } else {
            $GLOBALS['xoopsTpl']->assign('error', _AM_WGTEAMS_THEREARENT_TEAMS);
        }
        break;
    case 'set_onoff':
        if (isset($teamId)) {
            $teamsObj = $teamsHandler->get($teamId);
            // get Var team_online
            $team_online = (1 == $teamsObj->getVar('team_online')) ? '0' : '1';
            // Set Var team_online
            $teamsObj->setVar('team_online', $team_online);
            if ($teamsHandler->insert($teamsObj, true)) {
                \redirect_header('teams.php?op=list', 2, _AM_WGTEAMS_FORM_OK);
            }
        } else {
            echo 'invalid params';
        }
        break;
    case 'new':
        $templateMain = 'wgteams_admin_teams.tpl';
        $adminObject->addItemButton(_AM_WGTEAMS_TEAMS_LIST, 'teams.php', 'list');
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('teams.php'));
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left', ''));
        // Get Form
        $teamsObj = $teamsHandler->create();
        $form     = $teamsObj->getFormTeams();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'save':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            \redirect_header('teams.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if (isset($teamId)) {
            $teamsObj = $teamsHandler->get($teamId);
        } else {
            $teamsObj = $teamsHandler->create();
        }
        // Set Vars
        // Set Var team_name
        $teamsObj->setVar('team_name', $_POST['team_name']);
        // Set Var team_descr
        $teamsObj->setVar('team_descr', $_POST['team_descr']);
        // Set Var team_image
        require_once \XOOPS_ROOT_PATH . '/class/uploader.php';
        $fileName       = $_FILES['attachedfile']['name'];
        $imageMimetype  = $_FILES['attachedfile']['type'];
        $uploaderErrors = '';
        $maxwidth  = $helper->getConfig('maxwidth');
        $maxheight = $helper->getConfig('maxheight');
        $uploader = new \XoopsMediaUploader(\WGTEAMS_UPLOAD_PATH . '/teams/images', $helper->getConfig('wgteams_img_mimetypes'), $helper->getConfig('wgteams_img_maxsize'), $maxwidth, $maxheight);
        if ($uploader->fetchMedia($_POST['xoops_upload_file'][0])) {
            $extension = \preg_replace('/^.+\.([^.]+)$/sU', '', $fileName);
            $imgName   = mb_substr(\str_replace(' ', '', $_POST['team_name']), 0, 20) . '_' . $extension;
            $uploader->setPrefix($imgName);
            $uploader->fetchMedia($_POST['xoops_upload_file'][0]);
            if (!$uploader->upload()) {
                $uploaderErrors = $uploader->getErrors();
            } else {
                $savedFilename = $uploader->getSavedFileName();
                $teamsObj->setVar('team_image', $savedFilename);
                // resize image
                $img_resize = Request::getInt('img_resize', 0);
                if (1 == $img_resize) {
                    $imgHandler                = new Wgteams\Resizer();
                    $maxwidth_imgeditor        = (int)$helper->getConfig('maxwidth_imgeditor');
                    $maxheight_imgeditor       = (int)$helper->getConfig('maxheight_imgeditor');
                    $imgHandler->sourceFile    = \WGTEAMS_UPLOAD_PATH . '/teams/images/' . $savedFilename;
                    $imgHandler->endFile       = \WGTEAMS_UPLOAD_PATH . '/teams/images/' . $savedFilename;
                    $imgHandler->imageMimetype = $imageMimetype;
                    $imgHandler->maxWidth      = $maxwidth_imgeditor;
                    $imgHandler->maxHeight     = $maxheight_imgeditor;
                    $result = $imgHandler->resizeImage();
                    $teamsObj->setVar('team_image', $savedFilename);
                }
            }
        } else {
            if ($fileName > '') {
                $uploaderErrors = $uploader->getErrors();
            }
            $teamsObj->setVar('team_image', Request::getString('team_image'));
        }
        // Set Var team_nb_cols
        $teamsObj->setVar('team_nb_cols', $_POST['team_nb_cols']);
        // Set Var team_tablestyle
        $teamsObj->setVar('team_tablestyle', $_POST['team_tablestyle']);
        // Set Var team_imagestyle
        $teamsObj->setVar('team_imagestyle', $_POST['team_imagestyle']);
        // Set Var team_displaystyle
        $teamsObj->setVar('team_displaystyle', $_POST['team_displaystyle']);
        // Set Var team_weight
        $teamsObj->setVar('team_weight', $_POST['team_weight']);
        // Set Var team_online
        $teamsObj->setVar('team_online', ((1 == $_REQUEST['team_online']) ? '1' : '0'));
        // Set Var team_submitter
        $teamsObj->setVar('team_submitter', $_POST['team_submitter']);
        // Set Var team_date_create
        $teamsObj->setVar('team_date_create', \time());
        // Insert Data
        if ($teamsHandler->insert($teamsObj)) {
            if ('' !== $uploaderErrors) {
                \redirect_header('teams.php?op=edit&team_id=' . $teamId, 4, $uploaderErrors);
            } else {
                \redirect_header('teams.php?op=list', 2, _AM_WGTEAMS_FORM_OK);
            }
        }
        // Get Form
        $GLOBALS['xoopsTpl']->assign('error', $teamsObj->getHtmlErrors());
        $form = $teamsObj->getFormTeams();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'edit':
        $templateMain = 'wgteams_admin_teams.tpl';
        $adminObject->addItemButton(_AM_WGTEAMS_TEAM_ADD, 'teams.php?op=new', 'add');
        $adminObject->addItemButton(_AM_WGTEAMS_TEAMS_LIST, 'teams.php', 'list');
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('teams.php'));
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left', ''));
        // Get Form
        $teamsObj = $teamsHandler->get($teamId);
        $form     = $teamsObj->getFormTeams();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'delete':
        $teamsObj = $teamsHandler->get($teamId);
        if (\Xmf\Request::hasVar('ok', 'REQUEST') && 1 == $_REQUEST['ok']) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                \redirect_header('teams.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            $team_img = $teamsObj->getVar('team_image');
            $team_id  = $teamsObj->getVar('team_id');
            if ($teamsHandler->delete($teamsObj)) {
                //delete team image
                if ('' === !$team_img) {
                    \unlink(\WGTEAMS_UPLOAD_PATH . '/teams/images/' . $team_img);
                }
                //delete relations
                $crit_rels = new \CriteriaCompo();
                $crit_rels->add(new \Criteria('rel_team_id', $team_id));
                $relsCount = $relationsHandler->getCount($crit_rels);
                if ($relsCount > 0) {
                    $relationsAll = $relationsHandler->getAll($crit_rels);
                    foreach (\array_keys($relationsAll) as $i) {
                        $relationsObj = $relationsHandler->get($relationsAll[$i]->getVar('rel_id'));
                        $relationsHandler->delete($relationsObj);
                    }
                }
                \redirect_header('teams.php', 3, _AM_WGTEAMS_FORM_DELETE_OK);
            } else {
                $GLOBALS['xoopsTpl']->assign('error', $teamsObj->getHtmlErrors());
            }
        } else {
            xoops_confirm(['ok' => 1, 'team_id' => $teamId, 'op' => 'delete'], $_SERVER['REQUEST_URI'], \sprintf(_AM_WGTEAMS_FORM_SURE_DELETE, $teamsObj->getVar('team_name')));
        }
        break;
    case 'order':
        $torder = $_POST['torder'];
        for ($i = 0, $iMax = \count($torder); $i < $iMax; $i++) {
            $teamsObj = $teamsHandler->get($torder[$i]);
            $teamsObj->setVar('team_weight', $i + 1);
            $teamsHandler->insert($teamsObj);
        }
        break;
}

require __DIR__ . '/footer.php';

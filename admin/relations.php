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
 * @version         $Id: 1.0 relations.php 1 Sun 2015/12/27 23:18:00Z Goffy - Wedega $
 */

use Xmf\Request;

require __DIR__ . '/header.php';
// It recovered the value of argument op in URL$
$op     = Request::getString('op', 'list');
$relId  = Request::getInt('rel_id', 0);
$teamId = Request::getInt('team_id', 0);
// Switch options
switch ($op) {
    case 'list':
    default:
        $GLOBALS['xoTheme']->addScript(WGTEAMS_URL . '/assets/js/sortable-relations.js');
        $start        = Request::getInt('start', 0);
        $limit        = Request::getInt('limit', $helper->getConfig('adminpager'));
        $templateMain = 'wgteams_admin_relations.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('relations.php'));
        $adminObject->addItemButton(_AM_WGTEAMS_RELATION_ADD, 'relations.php?op=new&amp;team_id=' . $teamId, 'add');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left', ''));
        
        $form = getFormFilterTeam($teamId, $start, $limit);
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        $crRelations = new \CriteriaCompo();
        $crRelations->add(new \Criteria('rel_team_id', $teamId));  
        $relationsCount = $relationsHandler->getCount($crRelations);
        $crRelations->setStart($start);
        $crRelations->setLimit($limit);
        $relationsAll   = $relationsHandler->getAll($crRelations);
        $GLOBALS['xoopsTpl']->assign('relations_count', $relationsCount);
        $GLOBALS['xoopsTpl']->assign('wgteams_url', WGTEAMS_URL);
        $GLOBALS['xoopsTpl']->assign('wgteams_upload_url', WGTEAMS_UPLOAD_URL);
        $GLOBALS['xoopsTpl']->assign('wgteams_icons_url', WGTEAMS_ICONS_URL);

        // Table view
        if ($relationsCount > 0) {
            $team_id_prev = 0;
            $nb_rels_team = 0;
            foreach (array_keys($relationsAll) as $i) {
                $relation = $relationsAll[$i]->getValuesRelations();
                if ($team_id_prev == $relation['team_id']) {
                    $relation['new_team']     = 0;
                    $relation['nb_rels_team'] = $nb_rels_team;
                } else {
                    $relation['new_team']     = 1;
                    $nb_rels_team             = $relationsHandler->getCountRelationsTeam($relation['team_id']);
                    $relation['nb_rels_team'] = $nb_rels_team;
                    $team_id_prev             = $relation['team_id'];
                }
                $GLOBALS['xoopsTpl']->append('relations_list', $relation);
                unset($relation);
            }
            if ($relationsCount > $limit) {
                require_once XOOPS_ROOT_PATH . '/class/pagenav.php';
                $pagenav = new \XoopsPageNav($relationsCount, $limit, $start, 'start', 'op=list&amp;limit=' . $limit . '&amp;team_id=' . $teamId);
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
            }
        } else {
            if (0 == $teamId) {
                $GLOBALS['xoopsTpl']->assign('error', _AM_WGTEAMS_RELATIONS_NOTEAMSEL);
            } else {
                $GLOBALS['xoopsTpl']->assign('error', _AM_WGTEAMS_RELATIONS_NOTEAM);
            }
        }
        break;
    case 'new':
        $templateMain = 'wgteams_admin_relations.tpl';
        $adminObject->addItemButton(_AM_WGTEAMS_RELATIONS_LIST, 'relations.php', 'list');
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('relations.php'));
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left', ''));
        // Get Form
        $relationsObj = $relationsHandler->create();
        $relationsObj->setVar('rel_team_id', $teamId);
        $form         = $relationsObj->getFormRelations();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'save':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header('relations.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if (isset($relId)) {
            $relationsObj = $relationsHandler->get($relId);
        } else {
            $relationsObj = $relationsHandler->create();
        }
        // Set Vars
        // Set Var rel_team_id
        $relationsObj->setVar('rel_team_id', $_POST['rel_team_id']);
        // Set Var rel_member_id
        $relationsObj->setVar('rel_member_id', $_POST['rel_member_id']);
        // Set Var rel_info_1_field
        $relationsObj->setVar('rel_info_1_field', $_POST['rel_info_1_field']);
        // Set Var rel_info_1
        $relationsObj->setVar('rel_info_1', $_POST['rel_info_1']);
        // Set Var rel_info_2_field
        $relationsObj->setVar('rel_info_2_field', $_POST['rel_info_2_field']);
        // Set Var rel_info_2
        $relationsObj->setVar('rel_info_2', $_POST['rel_info_2']);
        // Set Var rel_info_3_field
        $relationsObj->setVar('rel_info_3_field', $_POST['rel_info_3_field']);
        // Set Var rel_info_3
        $relationsObj->setVar('rel_info_3', $_POST['rel_info_3']);
        // Set Var rel_info_4_field
        $relationsObj->setVar('rel_info_4_field', $_POST['rel_info_4_field']);
        // Set Var rel_info_4
        $relationsObj->setVar('rel_info_4', $_POST['rel_info_4']);
        // Set Var rel_info_5_field
        $relationsObj->setVar('rel_info_5_field', $_POST['rel_info_5_field']);
        // Set Var rel_info_5
        $relationsObj->setVar('rel_info_5', $_POST['rel_info_5']);
        // Set Var rel_weight
        $relationsObj->setVar('rel_weight', $_POST['rel_weight']);
        // Set Var rel_submitter
        $relationsObj->setVar('rel_submitter', $_POST['rel_submitter']);
        // Set Var rel_date_create
        $relationsObj->setVar('rel_date_create', time());
        // Insert Data
        if ($relationsHandler->insert($relationsObj)) {
            redirect_header('relations.php?op=list&amp;team_id=' . $_POST['rel_team_id'], 2, _AM_WGTEAMS_FORM_OK);
        }
        // Get Form
        $GLOBALS['xoopsTpl']->assign('error', $relationsObj->getHtmlErrors());
        $form = $relationsObj->getFormRelations();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'edit':
        $templateMain = 'wgteams_admin_relations.tpl';
        $adminObject->addItemButton(_AM_WGTEAMS_RELATION_ADD, 'relations.php?op=new', 'add');
        $adminObject->addItemButton(_AM_WGTEAMS_RELATIONS_LIST, 'relations.php', 'list');
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('relations.php'));
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left', ''));
        // Get Form
        $relationsObj = $relationsHandler->get($relId);
        $form         = $relationsObj->getFormRelations();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'delete':
        $relationsObj = $relationsHandler->get($relId);
        $teamObj = $teamsHandler->get($relationsObj->getVar('rel_team_id'));
        $memberObj = $membersHandler->get($relationsObj->getVar('rel_member_id'));
        if (\Xmf\Request::hasVar('ok') && 1 == $_REQUEST['ok']) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                redirect_header('relations.php', 3, implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($relationsHandler->delete($relationsObj)) {
                redirect_header('relations.php', 3, _AM_WGTEAMS_FORM_DELETE_OK);
            } else {
                $GLOBALS['xoopsTpl']->assign('error', $relationsObj->getHtmlErrors());
            }
        } else {
            $confirm = str_replace('%n', $memberObj->getVar('member_firstname') . ' ' . $memberObj->getVar('member_lastname'), _AM_WGTEAMS_RELATION_DELETE);
            $confirm = str_replace('%t', $teamObj->getVar('team_name'), $confirm);
            xoops_confirm(['ok' => 1, 'rel_id' => $relId, 'op' => 'delete'], $_SERVER['REQUEST_URI'], $confirm);
        }
        break;
    case 'order':
        $rorder = $_POST['rorder'];
        for ($i = 0, $iMax = count($rorder); $i < $iMax; $i++) {
            $relationsObj = $relationsHandler->get($rorder[$i]);
            $relationsObj->setVar('rel_weight', $i + 1);
            $relationsHandler->insert($relationsObj);
        }
        break;
}

require __DIR__ . '/footer.php';

/**
 * @function getFormFilterTeam:
 * provide form with a dropdown select containing all existing teams
 * @param $teamId
 * @param $start
 * @param $limit
 * @param bool $action
 * @return \XoopsThemeForm
 */
function getFormFilterTeam($teamId, $start, $limit, $action = false)
{
    $helper = \XoopsModules\Wgteams\Helper::getInstance();
    if (!$action) {
        $action = $_SERVER['REQUEST_URI'];
    }
    // Get Theme Form
    xoops_load('XoopsFormLoader');
    $form = new \XoopsThemeForm(_AM_WGTEAMS_FORM_SELTEAM, 'formselteam', $action, 'post', true);
    $form->setExtra('enctype="multipart/form-data"');
    $teamsHandler = $helper->getHandler('Teams');
    $teamIdSelect = new \XoopsFormSelect(_AM_WGTEAMS_TEAMS_LIST, 'team_id', $teamId);
    $teamIdSelect->setExtra('onchange="submit()"');
    $teamIdSelect->addOption(0, '&nbsp;');
    $teamsAll = $teamsHandler->getAll();

    foreach (array_keys($teamsAll) as $i) {
        $teamIdSelect->addOption($teamsAll[$i]->getVar('team_id'), $teamsAll[$i]->getVar('team_name'));
    }
    $form->addElement($teamIdSelect);
    $form->addElement(new \XoopsFormHidden('op', 'list'));
    $form->addElement(new \XoopsFormHidden('start', $start));
    $form->addElement(new \XoopsFormHidden('limit', $limit));

    return $form;
}

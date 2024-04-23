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
use Xmf\Module\Helper\AjaxHelper;
use XoopsModules\Wgteams\{
    Helper,
    Members
};

require __DIR__ . '/header.php';

$GLOBALS['xoopsOption']['template_main'] = 'wgteams_teams.tpl';
require_once \XOOPS_ROOT_PATH . '/header.php';
$helper    = Helper::getInstance();
$startpage = $helper->getConfig('startpage', 0)[0];

$team_id = Request::getInt('team_id');
$start   = Request::getInt('start');
$limit   = Request::getInt('limit', $helper->getConfig('userpager'));

// Define Stylesheet
$xoTheme->addStylesheet($style);

$keywords = [];

$crit_teams = new \CriteriaCompo();
$crit_teams->add(new \Criteria('team_online', '1'));
if ($team_id > 0) {
    $crit_teams->add(new \Criteria('team_id', $team_id));
}
$crit_teams->setSort('team_weight');
$crit_teams->setOrder('ASC');
if (3 == $startpage) {
    $crit_teams->setLimit('1');
}
$teamsCount = $teamsHandler->getCount($crit_teams);
$teamsAll   = $teamsHandler->getAll($crit_teams);
$teams_list = [];

$GLOBALS['xoopsTpl']->assign('teamsCount', $teamsCount);

if ($teamsCount > 0) {
    // Get All Teams
    $teams_list = wgteamsGetTeamMemberDetails($teamsAll);
    if (0 == $team_id && 1 == $startpage[0]) {
        $teams_list = wgteamsGetTeamDetails($teamsAll);
    }
} else {
    echo _MA_WGTEAMS_TEAMS_NODATA;
}

$team_name = '';
if (\count($teams_list) > 0) {
    foreach (\array_keys($teams_list) as $i) {
        $team_name  = $teams_list[$i]['team_name'];
        $keywords[] = $teams_list[$i]['team_name'];
    }
    $GLOBALS['xoopsTpl']->append('teams_list', $teams_list);
    unset($teams_list);
}

// fill in template
$GLOBALS['xoopsTpl']->assign('xoops_icons32_url', XOOPS_ICONS32_URL);
$GLOBALS['xoopsTpl']->assign('wgteams_upload_url', \WGTEAMS_UPLOAD_URL);
$GLOBALS['xoopsTpl']->assign('wgteams_teams_upload_url', \WGTEAMS_UPLOAD_URL . '/teams/images/');
$GLOBALS['xoopsTpl']->assign('wgteams_url', WGTEAMS_URL);

// Display Navigation
if ($teamsCount > $limit) {
    require_once \XOOPS_ROOT_PATH . '/class/pagenav.php';
    $nav = new \XoopsPageNav($teamsCount, $limit, $start, 'start');
    $GLOBALS['xoopsTpl']->assign('pagenav', $nav->renderNav());
}
// Breadcrumbs
if (1 == $helper->getConfig('wgteams_showbreadcrumbs')) {
    if ($team_id > 0 && '' !== $team_name) {
        $xoBreadcrumbs[] = ['title' => $GLOBALS['xoopsModule']->getVar('name'), 'link' => \WGTEAMS_URL . '/'];
        $xoBreadcrumbs[] = ['title' => $team_name];
    } else {
        $xoBreadcrumbs[] = ['title' => $GLOBALS['xoopsModule']->getVar('name')];
    }
    $GLOBALS['xoopsTpl']->assign('showbreadcrumbs', '1');
}

//---------- AJAX Modal Start -------------------

$xoopsLogger->activated = false;

if (Request::getMethod() === 'POST' && Request::hasVar('member_id', 'POST')) {
    $memberId = Request::getInt('member_id', 0, 'POST');
    if ($memberId > 0) {
        $membersHandler = $helper->getHandler('members');
        $member = $membersHandler->get($memberId);

        if ($member instanceof Members) {
            $memberDetails = renderMemberDetails($member);

            $ajaxHelper = new AjaxHelper();
            $ajaxHelper->addData('member_name', $memberDetails['member_name']);
            $ajaxHelper->addData('member_image', $memberDetails['member_image']);
            $ajaxHelper->addData('member_details', $memberDetails['member_details']);
            $ajaxHelper->setSuccess(true);
            $ajaxHelper->sendResponse();
            exit();
        }
    }
}

function renderMemberDetails($member) {

    $details = '';
    $memberImage = '';

    if ($member->getVar('member_lastname')) {
        $memberName = '<strong>Name: </strong> ' . html_entity_decode($member->getVar('member_firstname'), ENT_QUOTES | ENT_HTML5) . ' ' . html_entity_decode($member->getVar('member_lastname'), ENT_QUOTES | ENT_HTML5);
        $details    .= '<strong>Name: </strong> ' . html_entity_decode($member->getVar('member_firstname'), ENT_QUOTES | ENT_HTML5) . ' ' . html_entity_decode($member->getVar('member_lastname'), ENT_QUOTES | ENT_HTML5);
    }

    if ($member->getVar('member_image')) {
        $imageUrl =  WGTEAMS_UPLOAD_URL . '/members/images/' . $member->getVar('member_image');
        $imageName = $member->getVar('member_name');
        $memberImage = '<img src="' . $imageUrl . '" alt="' . $imageName . '" title="' . $imageName . '" class="img-fluid">';
    }



    if ($member->getVar('member_address')) {
        $address = html_entity_decode($member->getVar('member_address'), ENT_QUOTES | ENT_HTML5);
        $details .= '<div><strong>' . _MA_WGTEAMS_MEMBER_ADDRESS . ':</strong> ' . $address . '</div>';
    }

    if ($member->getVar('member_phone')) {
        $phone = html_entity_decode($member->getVar('member_phone'), ENT_QUOTES | ENT_HTML5);
        $details .= '<div><strong>' . _MA_WGTEAMS_MEMBER_PHONE . ':</strong> ' . $phone . '</div>';
    }

    if ($member->getVar('member_email')) {
        $email = html_entity_decode($member->getVar('member_email'), ENT_QUOTES | ENT_HTML5);
        $details .= '<div><strong>' . _MA_WGTEAMS_MEMBER_EMAIL . ':</strong> ' . $email . '</div>';
    }


    // Render additional info fields
    for ($i = 1; $i <= 5; $i++) {
        $infoField = 'info_' . $i;
        $infoFieldName = $infoField . '_name';

        if ($member->getVar($infoField)) {
            $info = html_entity_decode($member->getVar($infoField), ENT_QUOTES | ENT_HTML5);
            $details .= '<div><strong>' . $member->getVar($infoFieldName) . ':</strong> ' . $info . '</div>';
        }
    }

    return [
        'member_image'   => $memberImage,
//                'member_name' => $member->getVar('member_name'),
        'member_name'    => $memberName,
        'member_details' => $details,
    ];
}

//---------- AJAX Modal End -------------------

// keywords
wgteamsMetaKeywords($helper->getConfig('keywords') . ', ' . \implode(', ', $keywords));
unset($keywords);
// description
wgteamsMetaDescription(_MA_WGTEAMS_TEAM_DESC);

$GLOBALS['xoopsTpl']->assign('wgteams_url_index', \WGTEAMS_URL . '/index.php');
$GLOBALS['xoopsTpl']->assign('xoops_mpageurl', \WGTEAMS_URL . '/index.php');
require __DIR__ . '/footer.php';





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
 * @copyright       The XOOPS Project (http://xoops.org)
 * @license         GPL 2.0 or later
 * @package         wgteams
 * @since           1.0
 * @min_xoops       2.5.7
 * @author          Goffy - Wedega.com - Email:<webmaster@wedega.com> - Website:<http://wedega.com>
 * @version         $Id: 1.0 teams.php 1 Sun 2015/12/27 23:18:00Z Goffy - Wedega $
 */
include __DIR__ . '/header.php';
$GLOBALS['xoopsOption']['template_main'] = 'wgteams_teams.tpl';
include_once XOOPS_ROOT_PATH . '/header.php';

$startpage = $wgteams->getConfig('startpage', 0);

$team_id = XoopsRequest::getInt('team_id', 0);
$start   = XoopsRequest::getInt('start', 0);
$limit   = XoopsRequest::getInt('limit', $wgteams->getConfig('userpager'));

// Define Stylesheet
$xoTheme->addStylesheet($style);

$keywords = array();

$crit_teams = new CriteriaCompo();
$crit_teams->add(new Criteria('team_online', '1'));
if ($team_id > 0) {
    $crit_teams->add(new Criteria('team_id', $team_id));
}
$crit_teams->setSort('team_weight');
$crit_teams->setOrder('ASC');
if ($startpage == 3) {
    $crit_teams->setLimit('1');
}
$teamsCount = $teamsHandler->getCount($crit_teams);
$teamsAll   = $teamsHandler->getAll($crit_teams);
$teams_list = array();

if ($teamsCount > 0) {
    // Get All Teams
    $teams_list = wgteamsGetTeamMemberDetails($teamsAll);
    if ($team_id == 0 && $startpage[0] == 1) {
        $teams_list = wgteamsGetTeamDetails($teamsAll);
    }
} else {
    echo _MA_WGTEAMS_TEAMS_NODATA;
}

if (count($teams_list) > 0) {
    foreach (array_keys($teams_list) as $i) {
        $team_name  = $teams_list[$i]['team_name'];
        $keywords[] = $teams_list[$i]['team_name'];
    }
    $GLOBALS['xoopsTpl']->append('teams_list', $teams_list);
    unset($teams_list);
}

// fill in template
$GLOBALS['xoopsTpl']->assign('xoops_icons32_url', XOOPS_ICONS32_URL);
$GLOBALS['xoopsTpl']->assign('wgteams_upload_url', WGTEAMS_UPLOAD_URL);
$GLOBALS['xoopsTpl']->assign('wgteams_teams_upload_url', WGTEAMS_UPLOAD_URL . '/teams/images/');

// Display Navigation
if ($teamsCount > $limit) {
    include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
    $nav = new XoopsPageNav($teamsCount, $limit, $start, 'start');
    $GLOBALS['xoopsTpl']->assign('pagenav', $nav->renderNav(4));
}
// Breadcrumbs
if ($wgteams->getConfig('wgteams_showbreadcrumbs') == 1) {
    $xoBreadcrumbs[] = array('title' => _MA_WGTEAMS_TEAMS, 'link' => WGTEAMS_URL . '/index.php');
    if ($team_id > 0 && !$team_name === '') {
        $xoBreadcrumbs[] = array('title' => $team_name);
    }
    $GLOBALS['xoopsTpl']->assign('showbreadcrumbs', '1');
}
// keywords
wgteamsMetaKeywords($wgteams->getConfig('keywords') . ', ' . implode(', ', $keywords));
unset($keywords);
// description
wgteamsMetaDescription(_MA_WGTEAMS_TEAM_DESC);

$GLOBALS['xoopsTpl']->assign('wgteams_url_index', WGTEAMS_URL . '/index.php');
$GLOBALS['xoopsTpl']->assign('xoops_mpageurl', WGTEAMS_URL . '/index.php');
include __DIR__ . '/footer.php';

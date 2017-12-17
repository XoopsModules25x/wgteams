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
 * @author          Goffy - Wedega.com - Email:<webmaster@wedega.com> - Website:<https://wedega.com>
 * @version         $Id: 1.0 teams.php 1 Sun 2015/12/27 23:18:00Z Goffy - Wedega $
 */
include_once XOOPS_ROOT_PATH . '/modules/wgteams/include/common.php';

// Function show block
/**
 * @param $options
 * @return array
 */
function b_wgteams_teams_show($options)
{
    include_once XOOPS_ROOT_PATH . '/modules/wgteams/include/functions.php';

    $GLOBALS['xoTheme']->addStylesheet(XOOPS_URL . '/modules/wgteams/assets/css/style.css');

    $GLOBALS['xoopsTpl']->assign('wgteams_teams_upload_url', WGTEAMS_UPLOAD_URL . '/teams/images/');

    $wgteams      = WgteamsHelper::getInstance();
    $teamsHandler = $wgteams->getHandler('teams');

    $crit_teams = new CriteriaCompo();
    $crit_teams->add(new Criteria('team_online', '1'));
    $crit_teams->setSort('team_weight');
    $crit_teams->setOrder('ASC');
    $teamsCount = $teamsHandler->getCount($crit_teams);
    $teamsAll   = $teamsHandler->getAll($crit_teams);

    $block = [];
    if ($teamsCount > 0) {
        $block = wgteamsGetTeamDetails($teamsAll, false);
    }

    return $block;
}

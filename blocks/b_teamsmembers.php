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

use XoopsModules\Wgteams;

require_once XOOPS_ROOT_PATH . '/modules/wgteams/include/common.php';

// Function show block
/**
 * @param $options
 * @return array
 */
function b_wgteams_teamsmembers_show($options)
{
    require_once XOOPS_ROOT_PATH . '/modules/wgteams/include/functions.php';

    $GLOBALS['xoTheme']->addStylesheet(XOOPS_URL . '/modules/wgteams/assets/css/style.css');
    $GLOBALS['xoopsTpl']->assign('wgteams_teams_upload_url', WGTEAMS_UPLOAD_URL . '/teams/images/');
    $GLOBALS['xoopsTpl']->assign('wgteams_url_index', WGTEAMS_URL . '/index.php');

    $typeBlock = $options[0];
    $team_id   = $options[1];
    array_shift($options);
    array_shift($options);

    /** @var Wgteams\Helper $helper */
    $helper       = Wgteams\Helper::getInstance();
    $teamsHandler = $helper->getHandler('Teams');

    $crit_teams = new \CriteriaCompo();
    $crit_teams->add(new \Criteria('team_id', $team_id));
    $crit_teams->add(new \Criteria('team_online', '1'));
    $crit_teams->setSort('team_weight');
    $crit_teams->setOrder('ASC');
    $teamsCount = $teamsHandler->getCount($crit_teams);
    $teamsAll   = $teamsHandler->getAll($crit_teams);

    $block = [];
    if ($teamsCount > 0) {
        $block = wgteamsGetTeamMemberDetails($teamsAll);
    }

    return $block;
}

// Function edit block
/**
 * @param $options
 * @return string
 */
function b_wgteams_teamsmembers_edit($options)
{
    /** @var Wgteams\Helper $helper */
    $helper       = Wgteams\Helper::getInstance();
    $teamsHandler = $helper->getHandler('Teams');
    $GLOBALS['xoopsTpl']->assign('wgteams_upload_url', WGTEAMS_UPLOAD_URL);
    $form = _MB_WGTEAMS_TEAMS_TO_DISPLAY;
    $form .= "<input type='hidden' name='options[0]' value='" . $options[0] . "'>";
    array_shift($options);
    $criteria = new \CriteriaCompo();
    $criteria->add(new \Criteria('team_id', 0, '!='));
    $criteria->add(new \Criteria('team_online', 1));
    $criteria->setSort('team_weight');
    $criteria->setOrder('ASC');
    $teamsAll = $teamsHandler->getAll($criteria);
    unset($criteria);
    $form .= "<select name='options[]' size='5'>";
    foreach (array_keys($teamsAll) as $i) {
        $team_id = $teamsAll[$i]->getVar('team_id');
        $form    .= "<option value='" . $team_id . "' " . (false === array_search($team_id, $options, true) ? '' : 'selected') . '>' . $teamsAll[$i]->getVar('team_name') . '</option>';
    }
    $form .= '</select>';

    return $form;
}

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

use XoopsModules\Wgteams;
use XoopsModules\Wgteams\{
    Helper,
    Constants
};

require_once \XOOPS_ROOT_PATH . '/modules/wgteams/include/common.php';

// Function show block
/**
 * @param $options
 * @return array
 */
function b_wgteams_teamsmembers_show($options)
{
    require_once \XOOPS_ROOT_PATH . '/modules/wgteams/include/functions.php';

    $helper  = Helper::getInstance();

    $GLOBALS['xoTheme']->addStylesheet(\XOOPS_URL . '/modules/wgteams/assets/css/style.css');
    $GLOBALS['xoopsTpl']->assign('wgteams_teams_upload_url', \WGTEAMS_UPLOAD_URL . '/teams/images/');
    $GLOBALS['xoopsTpl']->assign('wgteams_url_index', \WGTEAMS_URL . '/index.php');

    $useDetails = (int)$helper->getConfig('wgteams_usedetails');
    $useModal   = Constants::USEDETAILS_MODAL === $useDetails;
    $GLOBALS['xoopsTpl']->assign('useModal', $useModal);
    if ($useModal) {
        $GLOBALS['xoTheme']->addStylesheet(\WGTEAMS_URL . '/assets/css/modal.css');
        $GLOBALS['xoTheme']->addScript(\WGTEAMS_URL . '/assets/js/modal.js');
    }
    $useTab = Constants::USEDETAILS_TAB === $useDetails;
    $GLOBALS['xoopsTpl']->assign('useTab', $useTab);

    $typeBlock = $options[0];
    \array_shift($options);
    $teamIds     = \implode(',', $options);

    $helper       = Wgteams\Helper::getInstance();
    $teamsHandler = $helper->getHandler('Teams');

    $crit_teams = new \CriteriaCompo();
    if (0 !== \mb_strpos($teamIds, '0')) {
        $crit_teams->add(new \Criteria('team_id', '(' . $teamIds . ')', 'IN'));
    }
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
    $helper       = Wgteams\Helper::getInstance();
    $teamsHandler = $helper->getHandler('Teams');
    $GLOBALS['xoopsTpl']->assign('wgteams_upload_url', \WGTEAMS_UPLOAD_URL);
    $form = _MB_WGTEAMS_TEAMS_TO_DISPLAY;
    $form .= "<input type='hidden' name='options[0]' value='" . $options[0] . "'>";
    \array_shift($options);
    $criteria = new \CriteriaCompo();
    $criteria->add(new \Criteria('team_id', 0, '!='));
    $criteria->add(new \Criteria('team_online', 1));
    $criteria->setSort('team_weight');
    $criteria->setOrder('ASC');
    $teamsAll = $teamsHandler->getAll($criteria);
    unset($criteria);
    $showAll = \in_array(0, $options);
    $form .= "<select name='options[]'  multiple='multiple' size='5'>";
    $form .= "<option value='0' " . ($showAll ? ' selected' : ' ') . '>-- ' . \_MB_WGTEAMS_ALL_TEAMS . ' --</option>';
    foreach (\array_keys($teamsAll) as $i) {
        $team_id = $teamsAll[$i]->getVar('team_id');
        $form    .= "<option value='" . $team_id . "'" . (!$showAll && \in_array($team_id, $options) ? ' selected' : ' ') . '>' . $teamsAll[$i]->getVar('team_name') . '</option>';
    }
    $form .= '</select>';

    return $form;
}

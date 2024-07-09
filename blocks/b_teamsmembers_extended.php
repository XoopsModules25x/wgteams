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
function b_wgteams_teamsmembers_ext_show($options)
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
    $showTeam   = (boolean)$options[1];
    $GLOBALS['xoopsTpl']->assign('blockExtendedTeamShow', $showTeam);
    $lengthName = $options[2];
    $showDesc   = (boolean)$options[3];
    $lengthDescr = $options[4];
    $levelDetail = (int)$options[5];
    switch ($levelDetail) {
        case constants::CLASS_INDEX:
            $GLOBALS['xoopsTpl']->assign('member_show_index', true);
            break;
        case constants::CLASS_TEAM:
            $GLOBALS['xoopsTpl']->assign('member_show_team', true);
            break;
        case constants::CLASS_DETAILS:
        default:
            $GLOBALS['xoopsTpl']->assign('member_show_details', true);
            break;
    }
    \array_shift($options);
    \array_shift($options);
    \array_shift($options);
    \array_shift($options);
    \array_shift($options);
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
        $block = wgteamsGetTeamMemberDetails($teamsAll, 0, $lengthName, $lengthDescr);
    }

    return $block;
}

// Function edit block
/**
 * @param $options
 * @return string
 */
function b_wgteams_teamsmembers_ext_edit($options)
{
    $helper       = Wgteams\Helper::getInstance();
    $teamsHandler = $helper->getHandler('Teams');
    $GLOBALS['xoopsTpl']->assign('wgteams_upload_url', \WGTEAMS_UPLOAD_URL);
    $form = "<input type='hidden' name='options[0]' value='" . $options[0] . "'>";
    $form .= \_MB_WGTEAMS_SHOWTEAM . ": <select name='options[1]' size='2'>";
    $form .= "<option value='0' " . (0 === (int)$options[1] ? "selected='selected'" : '') . '>' . \_NO . '</option>';
    $form .= "<option value='1' " . (1 === (int)$options[1] ? "selected='selected'" : '') . '>' . \_YES . '</option>';
    $form .= '</select><br>';
    $form .= \_MB_WGTEAMS_NAME_LENGTH . ": <input type='text' name='options[2]' size='5' maxlength='255' value='" . $options[2] . "'><br>";
    $form .= \_MB_WGTEAMS_DESC_SHOW . ": <select name='options[3]' size='2'>";
    $form .= "<option value='0' " . (0 === (int)$options[3] ? "selected='selected'" : '') . '>' . \_NO . '</option>';
    $form .= "<option value='1' " . (1 === (int)$options[3] ? "selected='selected'" : '') . '>' . \_YES . '</option>';
    $form .= '</select><br>';
    $form .= \_MB_WGTEAMS_DESC_LENGTH . ": <input type='text' name='options[4]' size='5' maxlength='255' value='" . $options[4] . "'><br>";
    $form .= \_MB_WGTEAMS_INFOFIELD_CLASS . ": <select name='options[5]' size='3'>";
    $form .= "<option value='" . Constants::CLASS_INDEX . "' " . (Constants::CLASS_INDEX === (int)$options[5] ? "selected='selected'" : '') . '>' . \_MB_WGTEAMS_INFOFIELD_CLASS_INDEX . '</option>';
    $form .= "<option value='" . Constants::CLASS_TEAM . "' " . (Constants::CLASS_TEAM === (int)$options[5] ? "selected='selected'" : '') . '>' . \_MB_WGTEAMS_INFOFIELD_CLASS_TEAM . '</option>';
    //TODO: usage of CLASS_DETAILS causes problems with display
    //$form .= "<option value='" . Constants::CLASS_DETAILS . "' " . (Constants::CLASS_DETAILS === (int)$options[5] ? "selected='selected'" : '') . '>' . \_MB_WGTEAMS_INFOFIELD_CLASS_DETAILS . '</option>';
    $form .= '</select><br>';
    \array_shift($options);
    \array_shift($options);
    \array_shift($options);
    \array_shift($options);
    \array_shift($options);
    \array_shift($options);

    $form .= \_MB_WGTEAMS_TEAMS_TO_DISPLAY;
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

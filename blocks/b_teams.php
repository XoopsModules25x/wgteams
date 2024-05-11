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

require_once \XOOPS_ROOT_PATH . '/modules/wgteams/include/common.php';

// Function show block
/**
 * @param $options
 * @return array
 */
function b_wgteams_teams_show($options)
{
    require_once \XOOPS_ROOT_PATH . '/modules/wgteams/include/functions.php';

    $GLOBALS['xoTheme']->addStylesheet(\XOOPS_URL . '/modules/wgteams/assets/css/style.css');

    $GLOBALS['xoopsTpl']->assign('wgteams_teams_upload_url', \WGTEAMS_UPLOAD_URL . '/teams/images/');
    $GLOBALS['xoopsTpl']->assign('wgteams_url', \WGTEAMS_URL);
    $GLOBALS['xoopsTpl']->assign('wgteams_url_index', \WGTEAMS_URL . '/index.php');
    
    $showName   = (boolean)$options[1];
    $lengthName = $options[2];
    $showDesc   = (boolean)$options[3];
    $lengthDescr = $options[4];
    $numbTeams   = $options[5];
    $template    = $options[6];
    \array_shift($options);
    \array_shift($options);
    \array_shift($options);
    \array_shift($options);
    \array_shift($options);
    \array_shift($options);
    \array_shift($options);
    
    $arrTeams    = $options;

    $helper       = Wgteams\Helper::getInstance();
    $teamsHandler = $helper->getHandler('Teams');
   
    $crit_teams = new \CriteriaCompo();
    $crit_teams->add(new \Criteria('team_online', '1'));
    if ($arrTeams[0] > 0) {
        $team_ids     = \implode(',', $options);
        $crit_teams->add(new \Criteria('team_id', '(' . $team_ids . ')', 'IN'));
    }
    $crit_teams->setSort('team_weight');
    $crit_teams->setOrder('ASC');
    $teamsCount = $teamsHandler->getCount($crit_teams);
    $teamsAll   = $teamsHandler->getAll($crit_teams);

    $block = [];
    if ($teamsCount > 0) {
        $block = wgteamsGetTeamDetails($teamsAll, $lengthName, $showDesc, $lengthDescr);
    }
    
    // assign block options
    $GLOBALS['xoopsTpl']->assign('showName', $showName);
    $GLOBALS['xoopsTpl']->assign('showDesc', $showDesc);
    $GLOBALS['xoopsTpl']->assign('numbTeams', $numbTeams);
    $GLOBALS['xoopsTpl']->assign('template', $template);

    return $block;
}
// Function edit block
/**
 * @param $options
 * @return string
 */
function b_wgteams_teams_edit($options)
{
    $helper        = Wgteams\Helper::getInstance();
    $teamsHandler = $helper->getHandler('Teams');
    $criteria      = new \CriteriaCompo();
    $criteria->setSort('team_weight');
    $criteria->setOrder('ASC');
    $teamsAll = $teamsHandler->getAll($criteria);
    unset($criteria);

    $form = "<input name='options[0]' value='".$options[0]."' type='hidden' />";
    $form .= _MB_WGTEAMS_NAME_SHOW . ": <select name='options[1]' size='2'>";
    $form .= "<option value='0' " . (0 === (int)$options[1] ? "selected='selected'" : '') . '>' . _NO . '</option>';
    $form .= "<option value='1' " . (1 === (int)$options[1] ? "selected='selected'" : '') . '>' . _YES . '</option>';
    $form .= '</select><br>';
    $form .= _MB_WGTEAMS_NAME_LENGTH . ": <input type='text' name='options[2]' size='5' maxlength='255' value='" . $options[2] . "'><br>";
    $form .= _MB_WGTEAMS_DESC_SHOW . ": <select name='options[3]' size='2'>";
    $form .= "<option value='0' " . (0 === (int)$options[3] ? "selected='selected'" : '') . '>' . _NO . '</option>';
    $form .= "<option value='1' " . (1 === (int)$options[3] ? "selected='selected'" : '') . '>' . _YES . '</option>';
    $form .= '</select><br>';
    $form .= _MB_WGTEAMS_DESC_LENGTH . ": <input type='text' name='options[4]' size='5' maxlength='255' value='" . $options[4] . "'><br>";
    $form .= _MB_WGTEAMS_NUMB_TEAMS . ": <select name='options[5]' size='5'>";
    $form .= "<option value='1' " . (1 === (int)$options[5] ? "selected='selected'" : '') . '>1</option>';
    $form .= "<option value='2' " . (2 === (int)$options[5] ? "selected='selected'" : '') . '>2</option>';
    $form .= "<option value='3' " . (3 === (int)$options[5] ? "selected='selected'" : '') . '>3</option>';
    $form .= "<option value='4' " . (4 === (int)$options[5] ? "selected='selected'" : '') . '>4</option>';
    $form .= "<option value='6' " . (6 === (int)$options[5] ? "selected='selected'" : '') . '>6</option>';
    $form .= '</select><br>';
    $form .= _MB_WGTEAMS_TEMPLATE . ": <select name='options[6]' size='3'>";
    $form .= "<option value='default' " . ('default' === $options[6] ? "selected='selected'" : '') . '>' . _MB_WGTEAMS_TEMPLATE_DEFAULT . '</option>';
    $form .= "<option value='list' " . ('list' === $options[6] ? "selected='selected'" : '') . '>' . _MB_WGTEAMS_TEMPLATE_LIST . '</option>';
    $form .= "<option value='bcards' " . ('bcards' === $options[6] ? "selected='selected'" : '') . '>' . _MB_WGTEAMS_TEMPLATE_BCARDS . '</option>';
    $form .= '</select><br>';
    \array_shift($options);
    \array_shift($options);
    \array_shift($options);
    \array_shift($options);
    \array_shift($options);
    \array_shift($options);
    \array_shift($options);

    $form .= _MB_WGTEAMS_TEAMS_TO_DISPLAY . ": <select name='options[]' multiple='multiple' size='5'>";
    $form .= "<option value='0' " . (\in_array(0, $options) ? "selected='selected'" : '') . '>' . _MB_WGTEAMS_ALL_TEAMS . '</option>';
    foreach (\array_keys($teamsAll) as $i) {
        $team_id = $teamsAll[$i]->getVar('team_id');
        $form   .= "<option value='" . $team_id . "' " . (\in_array($team_id, $options) && false === \in_array(0, $options) ? "selected='selected'" : '') . '>' . $teamsAll[$i]->getVar('team_name') . '</option>';
    }
    $form .= '</select>';

    return $form;
}

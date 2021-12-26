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
 * @version         $Id: 1.0 functions.php 1 Sun 2015/12/27 23:18:01Z Goffy - Wedega $
 * @param        $global
 * @param        $key
 * @param string $default
 * @param string $type
 * @return mixed|string
 */

use XoopsModules\Wgteams;

/**
 * @param        $global
 * @param        $key
 * @param string $default
 * @param string $type
 * @return mixed|string
 */
function wgteams_CleanVars(&$global, $key, $default = '', $type = 'int')
{
    switch ($type) {
        case 'string':
            $ret = isset($global[$key]) ? filter_var($global[$key], FILTER_SANITIZE_MAGIC_QUOTES) : $default;
            break;
        case 'int':
        default:
            $ret = isset($global[$key]) ? filter_var($global[$key], FILTER_SANITIZE_NUMBER_INT) : $default;
            break;
    }
    if (false === $ret) {
        return $default;
    }

    return $ret;
}

/**
 * @param $content
 */
function wgteamsMetaKeywords($content)
{
    global $xoopsTpl, $xoTheme;
    $myts    = \MyTextSanitizer::getInstance();
    $content = $myts->undoHtmlSpecialChars($myts->displayTarea($content));
    if (isset($xoTheme) && \is_object($xoTheme)) {
        $xoTheme->addMeta('meta', 'keywords', \strip_tags($content));
    } else {    // Compatibility for old Xoops versions
        $xoopsTpl->assign('xoops_meta_keywords', \strip_tags($content));
    }
}

/**
 * @param $content
 */
function wgteamsMetaDescription($content)
{
    global $xoopsTpl, $xoTheme;
    $myts    = \MyTextSanitizer::getInstance();
    $content = $myts->undoHtmlSpecialChars($myts->displayTarea($content));
    if (isset($xoTheme) && \is_object($xoTheme)) {
        $xoTheme->addMeta('meta', 'description', \strip_tags($content));
    } else {    // Compatibility for old Xoops versions
        $xoopsTpl->assign('xoops_meta_description', \strip_tags($content));
    }
}

/**
 * @param      $teamsAll
 * @param int $lengthName
 * @param bool $show_descr
 * @param int $lengthDescr
 * @return array
 */
function wgteamsGetTeamDetails(&$teamsAll, $lengthName = 0, $show_descr = true, $lengthDescr = 0)
{
    // Get All Teams
//    global $xoopsTpl, $xoTheme;

    /** @var Wgteams\Helper $helper */
    $helper       = Wgteams\Helper::getInstance();
//    $teamsHandler = $helper->getHandler('Teams');

    \xoops_loadLanguage('main', \WGTEAMS_DIRNAME);

    $team_image_url = \WGTEAMS_UPLOAD_URL . '/teams/images/';
    $teams_list = [];
	
	$show_teamname = (1 == $helper->getConfig('wgteams_showteamname')) ? true : false;

    foreach (\array_keys($teamsAll) as $i) {
        $team_id    = $teamsAll[$i]->getVar('team_id');
        $team_name  = $teamsAll[$i]->getVar('team_name');
        if ($lengthName > 0) {
            $team_name = $helper::truncateHtml($team_name, $lengthName, '...', false, false);
        }
        $team_descr = '';
        if ($show_descr) {
            $team_descr = $teamsAll[$i]->getVar('team_descr', 'n');
            if ($lengthDescr > 0) {
                $team_descr = $helper::truncateHtml($team_descr, $lengthDescr);
            }
        }
        if ('blank.gif' === $teamsAll[$i]->getVar('team_image') || 'blank.png' === $teamsAll[$i]->getVar('team_image')) {
            $team_image = '';
        } else {
            $team_image = $teamsAll[$i]->getVar('team_image');
        }
        $team_tablestyle = ('default' === $teamsAll[$i]->getVar('team_tablestyle')) ? '' : $teamsAll[$i]->getVar('team_tablestyle');
        $team_imagestyle = ('default' === $teamsAll[$i]->getVar('team_imagestyle')) ? '' : $teamsAll[$i]->getVar('team_imagestyle');

        $teams_list[] = [
            'team_id'         => $team_id,
            'team_name'       => $team_name,
            'team_descr'      => $team_descr,
            'team_image'      => $team_image,
            'team_image_url'  => $team_image_url,
            'team_tablestyle' => $team_tablestyle,
            'team_imagestyle' => $team_imagestyle,
            'team_read_more'  => _MA_WGTEAMS_READMORE,
			'show_teamname'   => $show_teamname,
        ];
    }

    return $teams_list;
}

/**
 * @param $teamsAll
 * @return array
 */
function wgteamsGetTeamMemberDetails(&$teamsAll)
{
    // Get All Teams
//    global $xoopsTpl, $xoTheme;
    /** @var Wgteams\Helper $helper */
    $helper            = Wgteams\Helper::getInstance();
    $db                = \XoopsDatabaseFactory::getDatabaseConnection();
//    $teamsHandler      = new Wgteams\TeamsHandler($db);
    $membersHandler    = new Wgteams\MembersHandler($db);
    $relationsHandler  = new Wgteams\RelationsHandler($db);
    $infofieldsHandler = new Wgteams\InfofieldsHandler($db);

    \xoops_loadLanguage('main', \WGTEAMS_DIRNAME);

    $team_image_url   = \WGTEAMS_UPLOAD_URL . '/teams/images/';
    $member_image_url = \WGTEAMS_UPLOAD_URL . '/members/images/';
	
	$member_labels     = (1 == $helper->getConfig('wgteams_labels_member')) ? true : false;
	$infofield_labels  = (1 == $helper->getConfig('wgteams_labels_infofields')) ? true : false;
	$show_teamname     = (1 == $helper->getConfig('wgteams_showteamname')) ? true : false;

    $teams_list = [];

    foreach (\array_keys($teamsAll) as $i) {
        $team_id    = $teamsAll[$i]->getVar('team_id');
		$team_name  = $teamsAll[$i]->getVar('team_name');
        $team_descr = $teamsAll[$i]->getVar('team_descr', 'n');
        if ('blank.gif' === $teamsAll[$i]->getVar('team_image')) {
            $team_image = '';
        } else {
            $team_image = $teamsAll[$i]->getVar('team_image');
        }
        $team_nb_cols      = $teamsAll[$i]->getVar('team_nb_cols');
        $team_tablestyle   = ('default' === $teamsAll[$i]->getVar('team_tablestyle')) ? '' : $teamsAll[$i]->getVar('team_tablestyle');
        $team_imagestyle   = ('default' === $teamsAll[$i]->getVar('team_imagestyle')) ? '' : $teamsAll[$i]->getVar('team_imagestyle');
        $team_displaystyle = $teamsAll[$i]->getVar('team_displaystyle');
        

        $crit_rels = new \CriteriaCompo();
        $crit_rels->add(new \Criteria('rel_team_id', $team_id));
        $crit_rels->setSort('rel_weight');
        $crit_rels->setOrder('ASC');
//        $relsCount = $relationsHandler->getCount($crit_rels);
        $relsAll   = $relationsHandler->getAll($crit_rels);
        unset($relations);
        $relations = [];
        $counter   = 0;
        $nb_infos  = 0;
        foreach (\array_keys($relsAll) as $r) {
            $member_id    = $relsAll[$r]->getVar('rel_member_id');
            $member_obj   = $membersHandler->get($member_id);
            $member_title = $member_obj->getVar('member_title');
            if ('' !== $member_title) {
                $nb_infos++;
            }
            $member_firstname = $member_obj->getVar('member_firstname');
            $member_lastname  = $member_obj->getVar('member_lastname');
            $member_name      = $member_firstname;
            $member_name      .= ' ' . $member_lastname;
            $member_name      = \trim($member_name);
            if ('' !== $member_name) {
                $nb_infos++;
            }
            $member_address = $member_obj->getVar('member_address', 'n');
            if ('' !== $member_address) {
                $nb_infos++;
            }
            $member_phone = $member_obj->getVar('member_phone', 'n');
            if ('' !== $member_phone) {
                $nb_infos++;
            }
            $member_email = $member_obj->getVar('member_email', 'n');
            if ('' !== $member_email) {
                $nb_infos++;
            }
            $member_image = $member_obj->getVar('member_image');
			if ('blank.gif' === $member_image) {
				$member_image = '';
			}

            // reset info field
            $infofield_id    = 0;
            $rel_info_1_name = '';
            $rel_info_2_name = '';
            $rel_info_3_name = '';
            $rel_info_4_name = '';
            $rel_info_5_name = '';

            $infofield_id = $relsAll[$r]->getVar('rel_info_1_field');
            if ($infofield_id > 0) {
                $infofield_obj   = $infofieldsHandler->get($infofield_id);
                $rel_info_1_name = $infofield_obj->getVar('infofield_name', 'n');
                $infofield_id    = 0;
                unset($infofield_obj);
                $nb_infos++;
            }
            $rel_info_1 = $relsAll[$r]->getVar('rel_info_1', 'n');

            $infofield_id = $relsAll[$r]->getVar('rel_info_2_field');
            if ($infofield_id > 0) {
                $infofield_obj   = $infofieldsHandler->get($infofield_id);
                $rel_info_2_name = $infofield_obj->getVar('infofield_name');
                $infofield_id    = 0;
                unset($infofield_obj);
                $nb_infos++;
            }
            $rel_info_2 = $relsAll[$r]->getVar('rel_info_2', 'n');

            $infofield_id = $relsAll[$r]->getVar('rel_info_3_field');
            if ($infofield_id > 0) {
                $infofield_obj   = $infofieldsHandler->get($infofield_id);
                $rel_info_3_name = $infofield_obj->getVar('infofield_name');
                $infofield_id    = 0;
                unset($infofield_obj);
                $nb_infos++;
            }
            $rel_info_3 = $relsAll[$r]->getVar('rel_info_3', 'n');

            $infofield_id = $relsAll[$r]->getVar('rel_info_4_field');
            if ($infofield_id > 0) {
                $infofield_obj   = $infofieldsHandler->get($infofield_id);
                $rel_info_4_name = $infofield_obj->getVar('infofield_name');
                $infofield_id    = 0;
                unset($infofield_obj);
                $nb_infos++;
            }
            $rel_info_4 = $relsAll[$r]->getVar('rel_info_4', 'n');

            $infofield_id = $relsAll[$r]->getVar('rel_info_5_field');
            if ($infofield_id > 0) {
                $infofield_obj   = $infofieldsHandler->get($infofield_id);
                $rel_info_5_name = $infofield_obj->getVar('infofield_name');
                $infofield_id    = 0;
                unset($infofield_obj);
                $nb_infos++;
            }
            $rel_info_5 = $relsAll[$r]->getVar('rel_info_5', 'n');
            $counter++;

            $relations[] = [
                'rel_counter'      => $counter,
                'member_id'        => $member_id,
                'member_title'     => $member_title,
                'member_firstname' => $member_firstname,
                'member_lastname'  => $member_lastname,
                'member_name'      => $member_name,
                'member_address'   => $member_address,
                'member_phone'     => $member_phone,
                'member_email'     => $member_email,
                'member_image'     => $member_image,
                'member_image_url' => $member_image_url,
                'info_1_name'      => $rel_info_1_name,
                'info_1'           => $rel_info_1,
                'info_2_name'      => $rel_info_2_name,
                'info_2'           => $rel_info_2,
                'info_3_name'      => $rel_info_3_name,
                'info_3'           => $rel_info_3,
                'info_4_name'      => $rel_info_4_name,
                'info_4'           => $rel_info_4,
                'info_5_name'      => $rel_info_5_name,
                'info_5'           => $rel_info_5,
                'rel_nb_cols'      => $team_nb_cols,
                'rel_tablestyle'   => $team_tablestyle,
                'rel_imagestyle'   => $team_imagestyle,
                'rel_displaystyle' => $team_displaystyle,
                'rel_nb_infos'     => $nb_infos,
                'member_labels'    => $member_labels,
				'infofield_labels' => $infofield_labels,
            ];
        }
        $teams_list[] = [
            'team_id'        => $team_id,
            'team_name'      => $team_name,
            'team_descr'     => $team_descr,
            'team_image'     => $team_image,
            'team_image_url' => $team_image_url,
            'members'        => $relations,
			'show_teamname'  => $show_teamname,
        ];
    }

    return $teams_list;
}

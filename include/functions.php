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
 * @param        $global
 * @param        $key
 * @param string $default
 * @param string $type
 * @return mixed|string
 */

use XoopsModules\Wgteams;
use XoopsModules\Wgteams\{
    //Constants,
    Helper
};

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
    $helper = Helper::getInstance();

    \xoops_loadLanguage('main', \WGTEAMS_DIRNAME);

    $team_image_url = \WGTEAMS_UPLOAD_URL . '/teams/images/';
    $teams_list = [];
    
    $show_teamname = 1 == $helper->getConfig('wgteams_showteamname');

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
            'team_read_more'  => \_MA_WGTEAMS_READMORE,
            'show_teamname'   => $show_teamname,
        ];
    }

    return $teams_list;
}

/** function to get team and member details
 * @param $teamsAll
 * @param int $rel_id
 * @param int $lenghtName
 * @param int $lengthDescr
 * @return array
 */
function wgteamsGetTeamMemberDetails(&$teamsAll, $rel_id = 0, $lenghtName = 0, $lengthDescr = 0)
{
    // Get teams and member relations
    $helper            = Helper::getInstance();
    $membersHandler    = $helper->getHandler('Members');
    $relationsHandler  = $helper->getHandler('Relations');
    $infofieldsHandler = $helper->getHandler('Infofields');

    \xoops_loadLanguage('main', \WGTEAMS_DIRNAME);

    $team_image_url   = \WGTEAMS_UPLOAD_URL . '/teams/images/';
    $member_image_url = \WGTEAMS_UPLOAD_URL . '/members/images/';
    
    $member_labels    = (int)$helper->getConfig('wgteams_labels_member');
    $infofield_labels = (int)$helper->getConfig('wgteams_labels_infofields');
    $show_teamname    = (int)$helper->getConfig('wgteams_showteamname');
    $usedetails       = (int)$helper->getConfig('wgteams_usedetails');

    $teams_list = [];

    foreach (\array_keys($teamsAll) as $i) {
        $team_id    = $teamsAll[$i]->getVar('team_id');
        $team_name  = $teamsAll[$i]->getVar('team_name');
        if ($lenghtName > 0) {
            $team_name = $helper::truncateHtml($team_name, $lenghtName, '...', false, false);
        }
        $team_descr = $teamsAll[$i]->getVar('team_descr', 'n');
        if ($lengthDescr > 0) {
            if ($team_descr === strip_tags($team_descr)) {
                $team_descr = $helper::truncateHtml($team_descr, $lengthDescr, '...', false, false);
            } else {
                $team_descr = $helper::truncateHtml($team_descr, $lengthDescr);
            }
        }
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
        if ($rel_id > 0) {
            $crit_rels->add(new \Criteria('rel_id', $rel_id));
        }
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
            $member_fullname = $member_title . ' ' . $member_name;
            $member_fullname = \trim($member_fullname);

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

            $relations[$r]['member_id']        = $member_id;
            $relations[$r]['member_title']     = $member_title;
            $relations[$r]['member_firstname'] = $member_firstname;
            $relations[$r]['member_lastname']  = $member_lastname;
            $relations[$r]['member_fullname']  = $member_fullname;
            $relations[$r]['member_name']      = $member_name;
            $relations[$r]['member_address']   = $member_address;
            $relations[$r]['member_phone']     = $member_phone;
            $relations[$r]['member_email']     = $member_email;
            $relations[$r]['member_image']     = $member_image;
            $relations[$r]['member_image_url'] = $member_image_url;
            $relations[$r]['member_labels']    = $member_labels;
            $relations[$r]['infofield_labels'] = $infofield_labels;
            $relations[$r]['index']            = [];
            $relations[$r]['team']             = [];
            $relations[$r]['details']          = [];
            for ($j = 1; $j <= 5; $j++) {
                // reset info field
                $rel_info_name          = '';
                $rel_info_class_index   = 0;
                $rel_info_class_team    = 0;
                $rel_info_class_details = 0;
                // get info
                $infofield_id = $relsAll[$r]->getVar('rel_info_' . $j . '_field');
                if ($infofield_id > 0) {
                    $infofield_obj   = $infofieldsHandler->get($infofield_id);
                    if ($infofield_obj !== null) {
                        $rel_info_name          = $infofield_obj->getVar('infofield_name', 'n');
                        $rel_info_class_index   = (bool)$infofield_obj->getVar('infofield_class_index');
                        $rel_info_class_team    = (bool)$infofield_obj->getVar('infofield_class_team');
                        $rel_info_class_details = (bool)$infofield_obj->getVar('infofield_class_details');
                    }
                    unset($infofield_obj);
                    //for old templates
                    $relations[$r]['info_' . $j . '_name'] = $rel_info_name;
                    $relations[$r]['info_' . $j]      = $relsAll[$r]->getVar('rel_info_' . $j, 'n');
                    //for new templates
                    if (($usedetails && $rel_info_class_index) || !$usedetails) {
                        $relations[$r]['index'][] = [
                            'info_name' => $rel_info_name,
                            'info'      => $relsAll[$r]->getVar('rel_info_' . $j, 'n')
                        ];
                    }
                    if (($usedetails && $rel_info_class_team) || !$usedetails) {
                        $relations[$r]['team'][] = [
                            'info_name' => $rel_info_name,
                            'info'      => $relsAll[$r]->getVar('rel_info_' . $j, 'n')
                        ];
                    }
                    if (($usedetails && $rel_info_class_details) || !$usedetails) {
                        $relations[$r]['details'][] = [
                            'info_name' => $rel_info_name,
                            'info'      => $relsAll[$r]->getVar('rel_info_' . $j, 'n')
                        ];
                    }
                    $nb_infos++;
                }
            }
            $counter++;

            $relations[$r]['rel_counter'] = $counter;
            $relations[$r]['rel_nb_cols'] = $team_nb_cols;
            $relations[$r]['rel_tablestyle'] = $team_tablestyle;
            $relations[$r]['rel_imagestyle'] = $team_imagestyle;
            $relations[$r]['rel_displaystyle'] = $team_displaystyle;
            $relations[$r]['rel_nb_infos'] = $nb_infos;
        }
        $teams_list[] = [
            'team_id'        => $team_id,
            'team_name'      => $team_name,
            'team_descr'     => $team_descr,
            'team_image'     => $team_image,
            'team_image_url' => $team_image_url,
            'members'        => $relations,
            'show_teamname'  => $show_teamname,
            'team_imagestyle' => $team_imagestyle,
        ];
    }

    return $teams_list;
}

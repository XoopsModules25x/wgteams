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
use XoopsModules\Wgteams\Constants;

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
            $ret = isset($global[$key]) ? filter_var($global[$key], FILTER_SANITIZE_ADD_SLASHES ) : $default;
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
    $helper       = Wgteams\Helper::getInstance();

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
function wgteamsGetTeamMemberDetails(&$teamsAll, $rel_id = 0)
{
    // Get teams and member relations
    $helper            = Wgteams\Helper::getInstance();
    $db                = \XoopsDatabaseFactory::getDatabaseConnection();
    $membersHandler    = new Wgteams\MembersHandler($db);
    $relationsHandler  = new Wgteams\RelationsHandler($db);
    $infofieldsHandler = new Wgteams\InfofieldsHandler($db);

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

            $relations[$r]['member_id'] = $member_id;
            $relations[$r]['member_title'] = $member_title;
            $relations[$r]['member_firstname'] = $member_firstname;
            $relations[$r]['member_lastname'] = $member_lastname;
            $relations[$r]['member_fullname'] = $member_fullname;
            $relations[$r]['member_name'] = $member_name;
            $relations[$r]['member_address'] = $member_address;
            $relations[$r]['member_phone'] = $member_phone;
            $relations[$r]['member_email'] = $member_email;
            $relations[$r]['member_image'] = $member_image;
            $relations[$r]['member_image_url'] = $member_image_url;
            $relations[$r]['member_labels'] = $member_labels;
            $relations[$r]['infofield_labels'] = $infofield_labels;

            // reset info field
            $rel_info_1_name = '';
            $rel_info_2_name = '';
            $rel_info_3_name = '';
            $rel_info_4_name = '';
            $rel_info_5_name = '';
            $rel_info_1_class = 0;
            $rel_info_2_class = 0;
            $rel_info_3_class = 0;
            $rel_info_4_class = 0;
            $rel_info_5_class = 0;

            $infofield_id = $relsAll[$r]->getVar('rel_info_1_field');
            if ($infofield_id > 0) {
                $infofield_obj   = $infofieldsHandler->get($infofield_id);
                if ($infofield_obj !== null) {
                    $rel_info_1_name = $infofield_obj->getVar('infofield_name', 'n');
                    $rel_info_1_class = (int)$infofield_obj->getVar('infofield_class');
                }
                unset($infofield_obj);
                if ($usedetails && Constants::CLASS_DETAILS === $rel_info_1_class) {
                    $relations[$r]['details'][] = [
                        'info_name' => $rel_info_1_name,
                        'info'      => $relsAll[$r]->getVar('rel_info_1', 'n')
                    ];
                } else {
                    //for old templates
                    $relations[$r]['info_1_name'] = $rel_info_1_name;
                    $relations[$r]['info_1']      = $relsAll[$r]->getVar('rel_info_1', 'n');
                    //for new templates
                    $relations[$r]['general'][] = [
                        'info_name' => $rel_info_1_name,
                        'info'      => $relsAll[$r]->getVar('rel_info_1', 'n')
                    ];
                }
                $nb_infos++;
            }

            $infofield_id = $relsAll[$r]->getVar('rel_info_2_field');
            if ($infofield_id > 0) {
                $infofield_obj   = $infofieldsHandler->get($infofield_id);
                if ($infofield_obj !== null) {
                    $rel_info_2_name = $infofield_obj->getVar('infofield_name');
                    $rel_info_2_class = (int)$infofield_obj->getVar('infofield_class');
                }
                unset($infofield_obj);
                if ($usedetails && Constants::CLASS_DETAILS === $rel_info_2_class) {
                    $relations[$r]['details'][] = [
                        'info_name' => $rel_info_2_name,
                        'info'      => $relsAll[$r]->getVar('rel_info_2', 'n')
                    ];
                } else {
                    //for old templates
                    $relations[$r]['info_2_name'] = $rel_info_2_name;
                    $relations[$r]['info_2']      = $relsAll[$r]->getVar('rel_info_2', 'n');
                    //for new templates
                    $relations[$r]['general'][] = [
                        'info_name' => $rel_info_2_name,
                        'info'      => $relsAll[$r]->getVar('rel_info_2', 'n')
                    ];
                }
                $nb_infos++;
            }

            $infofield_id = $relsAll[$r]->getVar('rel_info_3_field');
            if ($infofield_id > 0) {
                $infofield_obj   = $infofieldsHandler->get($infofield_id);
                if ($infofield_obj !== null) {
                    $rel_info_3_name = $infofield_obj->getVar('infofield_name');
                    $rel_info_3_class = (int)$infofield_obj->getVar('infofield_class');
                }
                unset($infofield_obj);
                if ($usedetails && Constants::CLASS_DETAILS === $rel_info_3_class) {
                    $relations[$r]['details'][] = [
                        'info_name' => $rel_info_3_name,
                        'info'      => $relsAll[$r]->getVar('rel_info_3', 'n')
                    ];
                } else {
                    //for old templates
                    $relations[$r]['info_3_name'] = $rel_info_3_name;
                    $relations[$r]['info_3']      = $relsAll[$r]->getVar('rel_info_3', 'n');
                    //for new templates
                    $relations[$r]['general'][] = [
                        'info_name' => $rel_info_3_name,
                        'info'      => $relsAll[$r]->getVar('rel_info_3', 'n')
                    ];
                }
                $nb_infos++;
            }

            $infofield_id = $relsAll[$r]->getVar('rel_info_4_field');
            if ($infofield_id > 0) {
                $infofield_obj   = $infofieldsHandler->get($infofield_id);
                if ($infofield_obj !== null) {
                    $rel_info_4_name = $infofield_obj->getVar('infofield_name');
                    $rel_info_4_class = (int)$infofield_obj->getVar('infofield_class');
                }
                $relations[$r]['info_4_name'] = $rel_info_4_name;
                unset($infofield_obj);
                if ($usedetails && Constants::CLASS_DETAILS === $rel_info_4_class) {
                    $relations[$r]['details'][] = [
                        'info_name' => $rel_info_4_name,
                        'info'      => $relsAll[$r]->getVar('rel_info_4', 'n')
                    ];
                } else {
                    //for old templates
                    $relations[$r]['info_4_name'] = $rel_info_4_name;
                    $relations[$r]['info_4']      = $relsAll[$r]->getVar('rel_info_4', 'n');
                    //for new templates
                    $relations[$r]['general'][] = [
                        'info_name' => $rel_info_4_name,
                        'info'      => $relsAll[$r]->getVar('rel_info_4', 'n')
                    ];
                }
                $nb_infos++;
            }

            $infofield_id = $relsAll[$r]->getVar('rel_info_5_field');
            if ($infofield_id > 0) {
                $infofield_obj   = $infofieldsHandler->get($infofield_id);
                if ($infofield_obj !== null) {
                    $rel_info_5_name = $infofield_obj->getVar('infofield_name');
                    $rel_info_5_class = (int)$infofield_obj->getVar('infofield_class');
                }
                unset($infofield_obj);
                if ($usedetails && Constants::CLASS_DETAILS === $rel_info_5_class) {
                    $relations[$r]['details'][] = [
                        'info_name' => $rel_info_5_name,
                        'info'      => $relsAll[$r]->getVar('rel_info_5', 'n')
                    ];
                } else {
                    //for old templates
                    $relations[$r]['info_5_name'] = $rel_info_5_name;
                    $relations[$r]['info_5']      = $relsAll[$r]->getVar('rel_info_5', 'n');
                    //for new templates
                    $relations[$r]['general'][] = [
                        'info_name' => $rel_info_5_name,
                        'info'      => $relsAll[$r]->getVar('rel_info_5', 'n')
                    ];
                }
                $nb_infos++;
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

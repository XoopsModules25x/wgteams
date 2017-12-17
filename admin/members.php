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
 * @author          Goffy - Wedega.com - Email:<webmaster@wedega.com> - Website:<http://wedega.com>
 * @version         $Id: 1.0 members.php 1 Sun 2015/12/27 23:18:00Z Goffy - Wedega $
 */
include __DIR__ . '/header.php';
// It recovered the value of argument op in URL$ 
$op = XoopsRequest::getString('op', 'list');
// Request member_id
$memberId = XoopsRequest::getInt('member_id', 0);
// Switch options
switch ($op) {
    case 'list':
    default:
        $start        = XoopsRequest::getInt('start', 0);
        $limit        = XoopsRequest::getInt('limit', $wgteams->getConfig('adminpager'));
        $templateMain = 'wgteams_admin_members.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminMenu->addNavigation('members.php'));
        $adminMenu->addItemButton(_AM_WGTEAMS_MEMBER_ADD, 'members.php?op=new', 'add');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminMenu->renderButton());
        $membersCount = $membersHandler->getCountMembers();
        $membersAll   = $membersHandler->getAllMembers($start, $limit);
        $GLOBALS['xoopsTpl']->assign('members_count', $membersCount);
        $GLOBALS['xoopsTpl']->assign('wgteams_url', WGTEAMS_URL);
        $GLOBALS['xoopsTpl']->assign('wgteams_upload_url', WGTEAMS_UPLOAD_URL);
        // Table view
        if ($membersCount > 0) {
            foreach (array_keys($membersAll) as $i) {
                $member = $membersAll[$i]->getValuesMember();
                $GLOBALS['xoopsTpl']->append('members_list', $member);
                unset($member);
            }
            if ($membersCount > $limit) {
                include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
                $pagenav = new XoopsPageNav($membersCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
            }
        } else {
            $GLOBALS['xoopsTpl']->assign('error', _AM_WGTEAMS_THEREARENT_MEMBERS);
        }
        break;

    case 'new':
        $templateMain = 'wgteams_admin_members.tpl';
        $adminMenu->addItemButton(_AM_WGTEAMS_MEMBERS_LIST, 'members.php', 'list');
        $GLOBALS['xoopsTpl']->assign('navigation', $adminMenu->addNavigation('members.php'));
        $GLOBALS['xoopsTpl']->assign('buttons', $adminMenu->renderButton());
        // Get Form
        $membersObj = $membersHandler->create();
        $form       = $membersObj->getFormMembers();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;

    case 'save':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header('members.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if (isset($memberId)) {
            $membersObj = $membersHandler->get($memberId);
        } else {
            $membersObj = $membersHandler->create();
        }
        // Set Vars
        // Set Var member_firstname
        $membersObj->setVar('member_firstname', $_POST['member_firstname']);
        // Set Var member_lastname
        $membersObj->setVar('member_lastname', $_POST['member_lastname']);
        // Set Var member_title
        $membersObj->setVar('member_title', $_POST['member_title']);
        // Set Var member_address
        $membersObj->setVar('member_address', $_POST['member_address']);
        // Set Var member_phone
        $membersObj->setVar('member_phone', $_POST['member_phone']);
        // Set Var member_email
        $membersObj->setVar('member_email', $_POST['member_email']);
        // Set Var member_image
        include_once XOOPS_ROOT_PATH . '/class/uploader.php';
        $uploader = new XoopsMediaUploader(WGTEAMS_UPLOAD_PATH . '/members/images', $wgteams->getConfig('wgteams_img_mimetypes'), $wgteams->getConfig('wgteams_img_maxsize'), null, null);
        if ($uploader->fetchMedia($_POST['xoops_upload_file'][0])) {
            $extension = preg_replace('/^.+\.([^.]+)$/sU', '', $_FILES['attachedfile']['name']);
            $imgName   = substr(str_replace(' ', '', $_POST['member_lastname'] . $_POST['member_firstname']), 0, 20) . '_' . $extension;
            $uploader->setPrefix($imgName);
            $uploader->fetchMedia($_POST['xoops_upload_file'][0]);
            if (!$uploader->upload()) {
                $errors = $uploader->getErrors();
                redirect_header('javascript:history.go(-1)', 3, $errors);
            } else {
                $membersObj->setVar('member_image', $uploader->getSavedFileName());
            }
        } else {
            $membersObj->setVar('member_image', $_POST['member_image']);
        }
        // Set Var member_submitter
        $membersObj->setVar('member_submitter', $_POST['member_submitter']);
        // Set Var member_date_create
        $membersObj->setVar('member_date_create', time());
        // Insert Data
        if ($membersHandler->insert($membersObj)) {
            redirect_header('members.php?op=list', 2, _AM_WGTEAMS_FORM_OK);
        }
        // Get Form
        $GLOBALS['xoopsTpl']->assign('error', $membersObj->getHtmlErrors());
        $form = $membersObj->getFormMembers();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;

    case 'edit':
        $templateMain = 'wgteams_admin_members.tpl';
        $adminMenu->addItemButton(_AM_WGTEAMS_MEMBER_ADD, 'members.php?op=new', 'add');
        $adminMenu->addItemButton(_AM_WGTEAMS_MEMBERS_LIST, 'members.php', 'list');
        $GLOBALS['xoopsTpl']->assign('navigation', $adminMenu->addNavigation('members.php'));
        $GLOBALS['xoopsTpl']->assign('buttons', $adminMenu->renderButton());
        // Get Form
        $membersObj = $membersHandler->get($memberId);
        $form       = $membersObj->getFormMembers();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;

    case 'delete':
        $membersObj = $membersHandler->get($memberId);
        if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                redirect_header('members.php', 3, implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            $member_img = $membersObj->getVar('member_image');
            $member_id  = $membersObj->getVar('member_id');
            if ($membersHandler->delete($membersObj)) {
                // delete image of this member
                if ('' === !$member_img) {
                    unlink(WGTEAMS_UPLOAD_PATH . '/members/images/' . $member_img);
                }
                //delete relations
                $crit_rels = new CriteriaCompo();
                $crit_rels->add(new Criteria('rel_member_id', $member_id));
                $relsCount = $relationsHandler->getCount($crit_rels);
                if ( $relsCount > 0 ) {
                    $relationsAll   = $relationsHandler->getAll($crit_rels);
                    foreach (array_keys($relationsAll) as $i) {
                        $relationsObj = $relationsHandler->get($relationsAll[$i]->getVar('rel_id'));
                        $relationsHandler->delete($relationsObj);
                    }
                }
                redirect_header('members.php', 3, _AM_WGTEAMS_FORM_DELETE_OK);
            } else {
                $GLOBALS['xoopsTpl']->assign('error', $membersObj->getHtmlErrors());
            }
        } else {
            xoops_confirm(['ok' => 1, 'member_id' => $memberId, 'op' => 'delete'], $_SERVER['REQUEST_URI'], sprintf(_AM_WGTEAMS_FORM_SURE_DELETE, $membersObj->getVar('member_firstname')));
        }
        break;
}

include __DIR__ . '/footer.php';

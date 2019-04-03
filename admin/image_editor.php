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
 * @copyright      module for xoops
 * @license        GPL 2.0 or later
 * @package        wgteams
 * @since          1.0
 * @min_xoops      2.5.9
 * @author         Wedega - Email:<webmaster@wedega.com> - Website:<https://wedega.com>
 * @version        $Id: 1.0 albums.php 1 Mon 2018-03-19 10:04:50Z XOOPS Project (www.xoops.org) $
 */

use Xmf\Request;
use XoopsModules\Wgteams;
use XoopsModules\Wgteams\Constants;

include __DIR__ . '/header.php';
$GLOBALS['xoopsOption']['template_main'] = 'wgteams_image_editor.tpl';
require_once XOOPS_ROOT_PATH . '/header.php';

/** @var \XoopsModules\Wgteams\Utility $utility */
$utility = new \XoopsModules\Wgteams\Utility();

$op         = Request::getString('op', 'list');
$memberId   = Request::getInt('member_id', 0);
$imageClass = 0;
if ( 0 < $memberId ) {
	$imageId      = $memberId;
	$imageHandler = $membersHandler;
	$imageObj     = $membersHandler->get($imageId);
	$imageClass   = Constants::IMAGECLASS_MEMBER;
} else {
	$teamId = Request::getInt('team_id', 0);
	if ($teamId > 0) {
		$imageId      = $teamId;
		$imageObj     = $teamsHandler->get($imageId);
		$imageHandler = $teamsHandler;
		$imageClass   = Constants::IMAGECLASS_TEAM;
	} else {
		redirect_header('index.php', 3, _CO_WGTEAMS_FORM_ERROR_INVALIDID);
	}
}
$start     = Request::getInt('start', 0);
$limit     = Request::getInt('limit', $helper->getConfig('adminpager'));

$uid = $xoopsUser instanceof \XoopsUser ? $xoopsUser->id() : 0;

// Define Stylesheet
$GLOBALS['xoTheme']->addStylesheet($style, null);
$GLOBALS['xoTheme']->addStylesheet(WGTEAMS_URL . '/assets/css/style_default.css');

// add scripts
$GLOBALS['xoTheme']->addScript(XOOPS_URL . '/modules/wgteams/assets/js/admin.js');

// assign vars
$GLOBALS['xoopsTpl']->assign('wgteams_icon_url_16', WGTEAMS_ICONS_URL . '/16');
$GLOBALS['xoopsTpl']->assign('wgteams_icon_url_32', WGTEAMS_ICONS_URL . '/32');
$GLOBALS['xoopsTpl']->assign('wgteams_upload_image_url', WGTEAMS_UPLOAD_IMAGES_URL);
$GLOBALS['xoopsTpl']->assign('wgteams_url', WGTEAMS_URL);
$GLOBALS['xoopsTpl']->assign('show_breadcrumbs', $helper->getConfig('show_breadcrumbs'));

$maxwidth  = $helper->getConfig('maxwidth');
$maxheight = $helper->getConfig('maxheight');

switch ($op) {
    case 'creategrid':
        $type   = Request::getInt('type', 4);
        $src[1] = Request::getString('src1', '');
        $src[2] = Request::getString('src2', '');
        $src[3] = Request::getString('src3', '');
        $src[4] = Request::getString('src4', '');
        $src[5] = Request::getString('src5', '');
        $src[6] = Request::getString('src6', '');
        $target = Request::getString('target', '');
        // replace thumbs dir by dir for medium images, only for wggallery
        // $src[1] = str_replace('/thumbs/', '/medium/', $src[1]);
        // $src[2] = str_replace('/thumbs/', '/medium/', $src[2]);
        // $src[3] = str_replace('/thumbs/', '/medium/', $src[3]);
        // $src[4] = str_replace('/thumbs/', '/medium/', $src[4]);
        // $src[5] = str_replace('/thumbs/', '/medium/', $src[5]);
        // $src[6] = str_replace('/thumbs/', '/medium/', $src[6]);
        
        $images = [];
        for ($i = 1; $i <= 6; $i++) {
            if ('' !== $src[$i]) {
                $file       = str_replace(XOOPS_URL, XOOPS_ROOT_PATH, $src[$i]);
                $images[$i] = ['file' => $file, 'mimetype' => mime_content_type($file)];
            }
        }

        // create basic image
        $tmp   = imagecreatetruecolor($maxwidth, $maxheight);
        $imgBg = imagecolorallocate($tmp, 0, 0, 0);
        imagefilledrectangle($tmp, 0, 0, $maxwidth, $maxheight, $imgBg);

        $final = XOOPS_UPLOAD_PATH . '/wgteams/images/temp/' . $target;
        unlink($final);
        imagejpeg($tmp, $final);
        imagedestroy($tmp);

        $imgTemp = XOOPS_UPLOAD_PATH . '/wgteams/images/temp/' . $uid . 'imgTemp';

        $imgHandler = new Wgteams\Resizer();
        if (4 === $type) {
            for ($i = 1; $i <= 4; $i++) {
                unlink($imgTemp . $i . '.jpg');
                $imgHandler->sourceFile    = $images[$i]['file'];
                $imgHandler->endFile       = $imgTemp . $i . '.jpg';
                $imgHandler->imageMimetype = $images[$i]['mimetype'];
                $imgHandler->maxWidth      = (int)round($maxwidth / 2 - 1);
                $imgHandler->maxHeight     = (int)round($maxheight / 2 - 1);
                $imgHandler->jpgQuality    = 90;
                $imgHandler->resizeAndCrop();
            }
            $imgHandler->mergeType = 4;
            $imgHandler->endFile   = $final;
            $imgHandler->maxWidth  = $maxwidth;
            $imgHandler->maxHeight = $maxheight;
            for ($i = 1; $i <= 4; $i++) {
                $imgHandler->sourceFile = $imgTemp . $i . '.jpg';
                $imgHandler->mergePos   = $i;
                $imgHandler->mergeImage();
                unlink($imgTemp . $i . '.jpg');
            }
        }
        if (6 === $type) {
            for ($i = 1; $i <= 6; $i++) {
                $imgHandler->sourceFile    = $images[$i]['file'];
                $imgHandler->endFile       = $imgTemp . $i . '.jpg';
                $imgHandler->imageMimetype = $images[$i]['mimetype'];
                $imgHandler->maxWidth      = (int)round($maxwidth / 3 - 1);
                $imgHandler->maxHeight     = (int)round($maxheight / 2 - 1);
                $imgHandler->resizeAndCrop();
            }
            $imgHandler->mergeType = 6;
            $imgHandler->endFile   = $final;
            $imgHandler->maxWidth  = $maxwidth;
            $imgHandler->maxHeight = $maxheight;
            for ($i = 1; $i <= 6; $i++) {
                $imgHandler->sourceFile = $imgTemp . $i . '.jpg';
                $imgHandler->mergePos   = $i;
                $imgHandler->mergeImage();
                unlink($imgTemp . $i . '.jpg');
            }
        }

        break;
    case 'cropimage':
        $albPid   = $imageObj->getVar('alb_pid');

        $imgTemp              = WGTEAMS_UPLOAD_IMAGE_PATH . '/temp/' . $cat . $imageId . '.jpg';
        $base64_image_content = Request::getString('croppedImage', '');
        //$ret = move_uploaded_file( $_FILES['croppedImage']['tmp_name'], $imgTemp );
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)) {
            $type = $result[2];
            file_put_contents($imgTemp, base64_decode(str_replace($result[1], '', $base64_image_content), true));
        }

        $imgHandler                = new Wgteams\Resizer();
        $imgHandler->sourceFile    = $imgTemp;
        $imgHandler->endFile       = $imgTemp;
        $imgHandler->imageMimetype = 'image/jpeg';
        $imgHandler->maxWidth      = $maxwidth;
        $imgHandler->maxHeight     = $maxheight;
        $ret                       = $imgHandler->resizeImage();
		if ($imageClass === Constants::IMAGECLASS_MEMBER) {
			$savedFilename = WGTEAMS_UPLOAD_IMAGE_PATH . '/members/images/member' . $imageId . '.jpg';
		} else {
			$savedFilename = WGTEAMS_UPLOAD_IMAGE_PATH . '/teams/images/team' . $imageId . '.jpg';
		}
        
        unlink($savedFilename);
        break;
    case 'saveAlbumImage':
    case 'saveGrid':
    case 'saveCrop':
        // Set Vars
        if ('saveGrid' === $op || 'saveCrop' === $op) {
            $imgTemp = XOOPS_UPLOAD_PATH . '/wgteams/images/temp/album' . $albId . '.jpg';
            $final   = XOOPS_UPLOAD_PATH . '/wgteams/images/albums/album' . $albId . '.jpg';
            $ret     = rename($imgTemp, $final);
        }
        if ('saveAlbumImage' === $op) {
            $imageObj->setVar('alb_imgid', Request::getInt('alb_imgid'));
            $imageObj->setVar('alb_image', '');
        } else {
            $imageObj->setVar('alb_imgid', 0);
            $imageObj->setVar('alb_image', 'album' . $albId . '.jpg');
        }
        $imageObj->setVar('alb_submitter', $uid);
        // Insert Data
        if ($imageHandler->insert($imageObj)) {
            if (0 === $albPid) {
                $albPid = $imageObj->getVar('alb_pid');
            }
            redirect_header('albums.php?op=list' . '&amp;alb_pid=' . $albPid, 2, _CO_WGTEAMS_FORM_OK);
        }
        $GLOBALS['xoopsTpl']->assign('error', $imageObj->getHtmlErrors());

        break;
    case 'uploadAlbumImage':
        // Security Check
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header('albums.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        // Set Vars
        $imageObj->setVar('alb_imgcat', Constants::ALBUM_IMGCAT_USE_UPLOADED_VAL);
        require_once XOOPS_ROOT_PATH . '/class/uploader.php';
        $fileName       = $_FILES['attachedfile']['name'];
        $imageMimetype  = $_FILES['attachedfile']['type'];
        $uploaderErrors = '';
        $uploader       = new \XoopsMediaUploader(WGTEAMS_UPLOAD_IMAGE_PATH . '/albums/', $helper->getConfig('mimetypes'), $helper->getConfig('maxsize'), null, null);
        if ($uploader->fetchMedia($_POST['xoops_upload_file'][0])) {
            $extension = preg_replace('/^.+\.([^.]+)$/sU', '', $fileName);
            $imgName   = 'album' . $albId . '.' . $extension;
            $uploader->setPrefix($imgName);
            $uploader->fetchMedia($_POST['xoops_upload_file'][0]);
            if (!$uploader->upload()) {
                $uploaderErrors = $uploader->getErrors();
            } else {
                $savedFilename = $uploader->getSavedFileName();
                $imageObj->setVar('alb_image', $savedFilename);
                // resize image
                //                require_once XOOPS_ROOT_PATH . '/modules/wgteams/include/imagehandler.php';
                $maxwidth = (int)$helper->getConfig('maxwidth_albimage');
                if (0 === $maxwidth) {
                    $maxwidth = $helper->getConfig('maxwidth');
                }
                $maxheight = (int)$helper->getConfig('maxheight_albimage');
                if (0 === $maxheight) {
                    $maxheight = $helper->getConfig('maxheight');
                }
                $imgHandler                = new Wgteams\Resizer();
                $imgHandler->sourceFile    = WGTEAMS_UPLOAD_IMAGE_PATH . '/albums/' . $savedFilename;
                $imgHandler->endFile       = WGTEAMS_UPLOAD_IMAGE_PATH . '/albums/' . $savedFilename;
                $imgHandler->imageMimetype = $imageMimetype;
                $imgHandler->maxWidth      = $maxwidth;
                $imgHandler->maxHeight     = $maxheight;
                $result                    = $imgHandler->resizeImage();
                $imageObj->setVar('alb_image', $savedFilename);
            }
        } else {
            if ($fileName > '') {
                $uploaderErrors = $uploader->getErrors();
            }
            $imageObj->setVar('alb_image', Request::getString('alb_image'));
        }
        $imageObj->setVar('alb_imgid', 0);

        // Insert Data
        if ($imageHandler->insert($imageObj)) {
            if ('' !== $uploaderErrors) {
                redirect_header('albums.php?op=list&amp;alb_pid=' . $albPid . '&amp;start=' . $start . '&amp;limit=' . $limit, $uploaderErrors);
            } else {
                redirect_header('albums.php?op=list&amp;alb_pid=' . $albPid . '&amp;start=' . $start . '&amp;limit=' . $limit, 2, _CO_WGTEAMS_FORM_OK);
            }
        }
        // Get Form
        $GLOBALS['xoopsTpl']->assign('error', $imageObj->getHtmlErrors());
        $form = $imageObj->getFormUploadAlbumimage();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());

        break;
    case 'imghandler':
    default:
        $GLOBALS['xoTheme']->addStylesheet(WGTEAMS_URL . '/assets/css/cropper.min.css');
        $GLOBALS['xoTheme']->addScript(WGTEAMS_URL . '/assets/js/cropper.min.js');
        $GLOBALS['xoTheme']->addScript(WGTEAMS_URL . '/assets/js/cropper-main.js');

        $GLOBALS['xoopsTpl']->assign('nbModals', [1, 2, 3, 4, 5, 6]);

        $GLOBALS['xoopsTpl']->assign('album', $imageObj->getValuesAlbums());

        $albImgid  = $imageObj->getVar('alb_imgid');
        $albImage1 = 'blank.gif';
        if ($albImgid > 0) {
            $imagesObj = $imagesHandler->get($albImgid);
            if (null !== $imagesObj && is_object($imagesObj)) {
                $albImage1 = $imagesObj->getVar('img_name');
            }
        }
        // Get All Images of this album
        $albumsChilds = [];
        $albumsChilds = explode('|', $albId . $imageHandler->getChildsOfCategory($albId));
        $images       = [];
        if (count($albumsChilds) > 0) {
            foreach ($albumsChilds as $child) {
                $alb_name = '';
                $crImages = new \CriteriaCompo();
                $crImages->add(new \Criteria('img_albid', $child));
                $crImages->setSort('img_weight');
                $crImages->setOrder('DESC');
                $imagesAll = $imagesHandler->getAll($crImages);
                foreach (array_keys($imagesAll) as $i) {
                    $images[$i] = $imagesAll[$i]->getValuesImages();
                    if ($albImage1 === $images[$i]['img_name']) {
                        $images[$i]['selected'] = 1;
                    }
                    if ('' === $alb_name) {
                        $albums                 = $helper->getHandler('Albums');
                        $alb_name               = $albums->get($child)->getVar('alb_name');
                        $images[$i]['alb_name'] = $alb_name;
                    }
                }
            }
        }
        if (count($images) > 0) {
            $GLOBALS['xoopsTpl']->assign('images', $images);
        }
        // get form for upload album image
        $form = $imageObj->getFormUploadAlbumimage();
        $GLOBALS['xoopsTpl']->assign('form_uploadimage', $form->render());
        // get form for apply select existing

        // get form for apply grid

        // set style of button
        $GLOBALS['xoopsTpl']->assign('btn_style', 'btn-default');

        break;
}

// Breadcrumbs
if ($albPid > 0) {
    $xoBreadcrumbs[] = ['title' => _CO_WGTEAMS_ALBUMS, 'link' => 'albums.php?op=list'];
    $imageObjPid    = $imageHandler->get($albPid);
    $xoBreadcrumbs[] = ['title' => $imageObjPid->getVar('alb_name')];
    unset($imageObjPid);
} else {
    $xoBreadcrumbs[] = ['title' => _CO_WGTEAMS_ALBUMS];
}

$GLOBALS['xoopsTpl']->assign('panel_type', $helper->getConfig('panel_type'));

// Description
$utility::getMetaDescription(_CO_WGTEAMS_ALBUMS);
$GLOBALS['xoopsTpl']->assign('wgteams_upload_url', WGTEAMS_UPLOAD_URL);
include __DIR__ . '/footer.php';

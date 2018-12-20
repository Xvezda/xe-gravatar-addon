<?php
/* Copyright (C) 2018 Xvezda <https://xvezda.com/> */

if (!defined('__XE__')) exit();

function setProfileImageByMemberSrl($member_srl) {
    if (!$member_srl) return;

    if (!isset($GLOBALS['__member_info__']['profile_image'][$member_srl])) {
        $GLOBALS['__member_info__']['profile_image'][$member_srl] = getProfileImageByMemberSrl($member_srl);
    }
}

function getProfileImageByMemberSrl($member_srl) {
    if (!$member_srl) return;

    $oAddonModel = getAdminModel('addon');
    $addon_info = $oAddonModel->getAddonInfoXml('gravatar');

    $vars = new stdClass();
    foreach ($addon_info->extra_vars as $var) {
        $vars->{$var->name} = $var->value;
    }

    $oMemberModel = getModel('member');
    $member_conf = $oMemberModel->getMemberConfig();
    $member_info = $oMemberModel->getMemberInfoByMemberSrl($member_srl);

    $info = new stdClass();
    if ($member_conf->profile_image != 'Y') {
        $info->width = $member_conf->profile_image_max_width;
        $info->height = $member_conf->profile_image_max_height;
    } else {
        $info->width = 80;
        $info->height = 80;
    }
    $info->src = "//www.gravatar.com/avatar/" . md5($member_info->email_address);

    return $info;
}

/* End of file gravatar.func.php */
/* Location: ./addons/gravatar/gravatar.func.php */

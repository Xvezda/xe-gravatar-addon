<?php
/* Copyright (C) 2018 Xvezda <https://xvezda.com/> */

if (!defined('__XE__')) exit();

function getGravatarAddonVariables() {
    $oAddonModel = getAdminModel('addon');
    $addon_info = $oAddonModel->getAddonInfoXml('gravatar');

    $vars = new stdClass();
    foreach ($addon_info->extra_vars as $var) {
        $vars->{$var->name} = $var->value;
    }
    return $vars;
}

function setGravatarImageByMemberSrl($member_srl) {
    if (!$member_srl) return;

    $vars = getGravatarAddonVariables();
    $oMemberModel = getModel('member');
    if (!$vars->image_priority && $oMemberModel->getProfileImage($member_srl)) {
        return;
    }

    if (!isset($GLOBALS['__member_info__']['profile_image'][$member_srl]) || $vars->image_priority) {
        $GLOBALS['__member_info__']['profile_image'][$member_srl] = getGravatarImageByMemberSrl($member_srl);
    }
}

function getGravatarImageByMemberSrl($member_srl) {
    if (!$member_srl) return;

    $oMemberModel = getModel('member');
    $member_conf = $oMemberModel->getMemberConfig();
    $member_info = $oMemberModel->getMemberInfoByMemberSrl($member_srl);

    $vars = getGravatarAddonVariables();

    $info = new stdClass();
    if (!$vars->force_size) {
        if ($member_conf->profile_image != 'Y') {
            $info->width = $member_conf->profile_image_max_width;
            $info->height = $member_conf->profile_image_max_height;
        } else {
            $info->width = 80;
            $info->height = 80;
        }
    } else {
        $info->width = intval($vars->force_size);
        $info->height = intval($vars->force_size);
    }
    $info->src = "https://www.gravatar.com/avatar/" . md5(($member_info->email_address ? $member_info->email_address : $member_info->user_id));

    $info->src .= '?s=' . ($info->width > $info->height ? $info->width : $info->height);

    if ($vars->image_theme) $info->src .= '&d=' . $vars->image_theme;
    if ($vars->image_rating) $info->src .= '&r=' . $vars->image_rating;
    if ($vars->force_default) $info->src .= '&f=y';

    return $info;
}


/* End of file gravatar.func.php */
/* Location: ./addons/gravatar/gravatar.func.php */

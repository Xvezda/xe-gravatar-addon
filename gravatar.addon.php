<?php
/* Copyright (c) 2018 Xvezda <https://xvezda.com> */

if (!defined('__XE__')) exit();

// Load function libraries
require_once(_XE_PATH_ . 'addons/gravatar/gravatar.func.php');

if ($called_position == 'after_module_proc') {
    $oMemberModel = getModel('member');
    $vars = getGravatarAddonVariables();

    // If user login
    $logged_info = Context::get('logged_info');
    if ($logged_info) {
        if (!$logged_info->profile_image || $vars->image_priority) {
            $logged_info->profile_image = getGravatarImageByMemberSrl($logged_info->member_srl);
        }
    }

    switch ($this->act) {
    case 'dispBoardContent':
        if ($this->module_info->use_anonymous === 'Y' && !$vars->anon_active) return;
        $oDocument = Context::get('oDocument');
        setGravatarImageByMemberSrl($oDocument->getMemberSrl());

        $oComments = $oDocument->getComments();
        foreach ($oComments as $comment) {
            setGravatarImageByMemberSrl($comment->member_srl);
        }
    default:
      break;
    }
}


/* End of file gravatar.addon.php */
/* Location: ./addons/gravatar/gravatar.addon.php */

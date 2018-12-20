<?php
/* @Copyright (c) 2018 Xvezda <https://xvezda.com> */

if (!defined('__XE__')) exit();

// Load function libraries
require_once(_XE_PATH_ . 'addons/gravatar/gravatar.func.php');

if ($called_position == 'after_module_proc') {
    /*
    $oMemberModel = getModel('member');
    $config = $oMemberModel->getMemberConfig();

    if ($config->profile_image != 'Y') return;
     */

    switch ($this->act) {
    case 'dispBoardContent':
        $oDocument = Context::get('oDocument');
        setProfileImageByMemberSrl($oDocument->getMemberSrl());

        $oComments = $oDocument->getComments();
        foreach ($oComments as $comment) {
            setProfileImageByMemberSrl($comment->member_srl);
        }
    default:
      break;
    }
    //$GLOBALS['__member_info__']['profile_image'][0] = $info;

    // if user login
    $logged_info = Context::get('logged_info');
    if ($logged_info) {
        $logged_info->profile_image = getProfileImageByMemberSrl($logged_info->member_srl);
    }
}

/* End of file gravatar.addon.php */
/* Location: ./addons/gravatar/gravatar.addon.php */

<?php
/*
 * Describe what it does!
 *
 **/

/** @var $this \bbn\mvc\controller */
if ( !\defined('APPUI_CHAT_ROOT') ){
  define('APPUI_CHAT_ROOT', $ctrl->plugin_url('appui-chat').'/');
  $ctrl->add_inc('chat', new \bbn\appui\chat($ctrl->db, $ctrl->inc->user));
}
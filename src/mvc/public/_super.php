<?php

/** @var bbn\Mvc\Controller $ctrl */
if ( !\defined('APPUI_CHAT_ROOT') ){
  define('APPUI_CHAT_ROOT', $ctrl->pluginUrl('appui-chat').'/');
  $ctrl->addInc('chat', new \bbn\Appui\Chat($ctrl->db, $ctrl->inc->user));
}
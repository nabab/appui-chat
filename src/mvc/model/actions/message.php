<?php
/*
 * Describe what it does!
 *
 **/

/** @var $this \bbn\mvc\model*/
$res = ['success' => false];
if ( isset($model->data['message']) && (!empty($model->data['id']) || !empty($model->data['user'])) ){
  $chat = new \bbn\appui\chat($model->db, $model->inc->user);
  $id_chat = empty($model->data['id']) ? $chat->get_chat_by_user($model->data['user']) : $model->data['id'];
  if ( $id_chat ){
    $chat->talk($id_chat, $model->data['message']);
    $res['success'] = true;
    $res['id_chat'] = $id_chat;
  }
}
return $res;
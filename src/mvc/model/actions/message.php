<?php
/*
 * Describe what it does!
 *
 **/

/** @var $this \bbn\mvc\model*/
$res = ['success' => false];
if ( !empty($model->data['id_chat']) && !empty($model->data['time']) ){
  return [
    'messages' => $model->inc->chat->get_prev_messages($model->data['id_chat'], $model->data['time'])
  ];
}
if ( isset($model->data['message']) && (!empty($model->data['id']) || !empty($model->data['users'])) ){
  if ( empty($model->data['id']) ){
    $chat = new \bbn\appui\chat($model->db, $model->inc->user);
    $id_chat = empty($model->data['id']) ? $chat->get_chat_by_users($model->data['users']) : $model->data['id'];
  }
  else{
    $id_chat = $model->data['id'];
  }
  if ( $id_chat ){
    $chat->talk($id_chat, $model->data['message']);
    $res['success'] = true;
    $res['id_chat'] = $id_chat;
  }
}
return $res;
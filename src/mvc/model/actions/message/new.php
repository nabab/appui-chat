<?php
/** @var $model \bbn\mvc\model */
if (
  !empty($model->data['text']) &&
  (
    ($id_chat = $model->data['id_chat'] ?? null) ||
    (
      !empty($model->data['users']) &&
      !empty($model->data['id_temp']) &&
      ($id_chat = $model->inc->chat->get_chat_by_users($model->data['users']))
    )
  )
){
  return [
    'success' => (bool)$model->inc->chat->talk($id_chat, $model->data['text']),
    'id_chat' => $id_chat,
    'id_temp' => $model->data['id_temp']
  ];
}
return ['success' => false];
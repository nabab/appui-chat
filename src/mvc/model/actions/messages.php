<?php
/** @var $model \bbn\mvc\model */
if ( !empty($model->data['id_chat']) && !empty($model->data['time']) ){
  return [
    'success' => true,
    'messages' => $model->inc->chat->get_prev_messages($model->data['id_chat'], $model->data['time'])
  ];
}
return ['success' => false];
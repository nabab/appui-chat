<?php
/** @var $model \bbn\mvc\model */
if ( !empty($model->data['id_chat']) && !empty($model->data['title']) ){
  return [
    'success' => $model->inc->chat->set_title($model->data['id_chat'], $model->data['title'])
  ];
}
return ['success' => false];
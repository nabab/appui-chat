<?php
/** @var $model \bbn\Mvc\Model */
if ( !empty($model->data['id_chat']) && !empty($model->data['title']) ){
  return [
    'success' => $model->inc->chat->setTitle($model->data['id_chat'], $model->data['title'])
  ];
}
return ['success' => false];
<?php
/** @var bbn\Mvc\Model $model */
if ( !empty($model->data['id_chat']) && !empty($model->data['title']) ){
  return [
    'success' => $model->inc->chat->setTitle($model->data['id_chat'], $model->data['title'])
  ];
}
return ['success' => false];
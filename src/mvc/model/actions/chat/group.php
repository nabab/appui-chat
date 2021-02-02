<?php
/** @var $model \bbn\Mvc\Model */
if (
  !empty($model->data['title']) &&
  !empty($model->data['participants']) &&
  isset($model->data['admins'])
){
  return [
    'success' => $model->inc->chat->createGroup($model->data['title'], $model->data['participants'], $model->data['admins'])
  ];
}
return ['success' => false];
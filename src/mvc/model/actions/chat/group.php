<?php
/** @var $model \bbn\mvc\model */
if (
  !empty($model->data['title']) &&
  !empty($model->data['participants']) &&
  isset($model->data['admins'])
){
  return [
    'success' => $model->inc->chat->create_group($model->data['title'], $model->data['participants'], $model->data['admins'])
  ];
}
return ['success' => false];
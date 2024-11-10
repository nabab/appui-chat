<?php
/** @var bbn\Mvc\Model $model */
if ( !empty($model->data['id_chat']) && !empty($model->data['id_user']) ){
  return ['success' => $model->inc->chat->setLastActivity($model->data['id_chat'], $model->data['id_user'])];
}
return ['success' => false];
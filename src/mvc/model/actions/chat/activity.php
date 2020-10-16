<?php
/** @var $model \bbn\mvc\model */
if ( !empty($model->data['id_chat']) && !empty($model->data['id_user']) ){
  return ['success' => $model->inc->chat->set_last_activity($model->data['id_chat'], $model->data['id_user'])];
}
return ['success' => false];
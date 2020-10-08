<?php
/** @var $model \bbn\mvc\model */
if ( !empty($model->data['id_chat']) && !empty($model->data['id_user']) ){
  return [
    'success' => $model->inc->chat->remove_admin($model->data['id_chat'], $model->data['id_user'])
  ];
}
return ['success' => false];
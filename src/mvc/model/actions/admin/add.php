<?php
/** @var $model \bbn\Mvc\Model */
if ( !empty($model->data['id_chat']) && !empty($model->data['id_user']) ){
  return [
    'success' => $model->inc->chat->addAdmin($model->data['id_chat'], $model->data['id_user'])
  ];
}
return ['success' => false];
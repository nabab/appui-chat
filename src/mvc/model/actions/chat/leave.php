<?php
/** @var $model \bbn\Mvc\Model */
if ( !empty($model->data['id_chat']) ){
  return [
    'success' => $model->inc->chat->leave($model->data['id_chat'])
  ];
}
return ['success' => false];
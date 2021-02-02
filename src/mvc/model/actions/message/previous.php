<?php
/** @var $model \bbn\Mvc\Model */
if ( !empty($model->data['id_chat']) && !empty($model->data['time']) ){
  return [
    'success' => true,
    'messages' => $model->inc->chat->getPrevMessages($model->data['id_chat'], $model->data['time'])
  ];
}
return ['success' => false];
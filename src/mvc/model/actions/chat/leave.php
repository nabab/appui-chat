<?php
/** @var bbn\Mvc\Model $model */
if ( !empty($model->data['id_chat']) ){
  return [
    'success' => $model->inc->chat->leave($model->data['id_chat'])
  ];
}
return ['success' => false];
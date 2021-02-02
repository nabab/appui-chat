<?php
/**
 * Created by PhpStorm.
 * User: BBN
 * Date: 24/10/2018
 * Time: 14:37
 */

if ( isset($model->data['id_chat'], $model->data['id_user']) ){
  return [
    'success' => $model->inc->chat->addUser($model->data['id_chat'], $model->data['id_user'])
  ];
}
return ['success' => false];
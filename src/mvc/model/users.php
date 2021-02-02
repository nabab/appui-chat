<?php
/*
 * Describe what it does!
 *
 **/

/** @var $this \bbn\Mvc\Model*/
$users = new \bbn\User\Users($model->db);
$res = [];
if ( $online = $users->onlineList() ){
  foreach ( $online as $o ){
    $res[] = [
      'id' => $o,
      'name' => $model->inc->user->getName($o)
    ];
  }
}

return ['users' => $res];
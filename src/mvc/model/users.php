<?php
/*
 * Describe what it does!
 *
 **/

/** @var $this \bbn\mvc\model*/
$users = new \bbn\user\users($model->db);
$res = [];
if ( $online = $users->online_list() ){
  foreach ( $online as $o ){
    $res[] = [
      'id' => $o,
      'name' => $model->inc->user->get_name($o)
    ];
  }
}

return ['users' => $res];
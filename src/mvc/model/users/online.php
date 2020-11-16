<?php
return $model->get_set_from_cache(function() use($model){
  $chat = new \bbn\appui\chat($model->db, $model->inc->user);
  return [
    'online' => $chat->get_online_users()
  ];
}, [], '', 5);

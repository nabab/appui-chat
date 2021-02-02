<?php
return $model->getSetFromCache(function() use($model){
  $chat = new \bbn\Appui\Chat($model->db, $model->inc->user);
  return [
    'online' => $chat->getOnlineUsers()
  ];
}, [], '', 5);

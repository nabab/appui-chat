<?php
$user_system = new \bbn\user\users($model->db);
$chat_system = new \bbn\appui\chat($model->db, $model->inc->user);
return [[
  'id' => 'appui-core-1',
  'frequency' => 1,
  'function' => function(array $data) use($chat_system){
    $res = [];
    if ( !empty($data['enabled']) ){
      $ctmp = [
        'current' => [],
        'last' => $data['lastChat'] ?? 0
      ];
      if ($chats = $chat_system->get_chats()) {
        foreach ($chats as $c) {
          $ctmp['current'][$c] = [
            'info' => $chat_system->info($c),
            'admins' => $chat_system->get_admins($c),
            'participants' => $chat_system->get_participants($c, false)
          ];
        }
      }
      $chats_hash = md5(json_encode($ctmp));
      if ( ($chats_hash !== $data['chatsHash']) ){
        $ctmp['hash'] = $chats_hash;
        foreach ( $chats as $c ){
          if ( empty($data['chatsHash']) ){
            if ( $m = $chat_system->get_prev_messages($c) ){
              $ctmp['current'][$c]['messages'] = $m;
              $max = $m[count($m)-1]['time'];
              if (\bbn\x::compare_floats($max, $ctmp['last'], '>')) {
                $ctmp['last'] = $max;
              }
            }
          }
          else if ( $m = $chat_system->get_next_messages($c, $data['lastChat'] ?? null) ){
            $ctmp['current'][$c]['messages'] = $m;
            $max = $m[count($m)-1]['time'];
            if ( \bbn\x::compare_floats($max, $ctmp['last'], '>')) {
              $ctmp['last'] = $max;
            }
          }
        }
        $res = [
          'chats' => $ctmp,
          'serviceWorkers' => [
            'chatsHash' => $chats_hash,
            'lastChat' => $ctmp['last']
          ]
        ];
      }
    }
    return $res;
  }
], [
  'id' => 'appui-core-2',
  'frequency' => 10,
  'function' => function(array $data) use($user_system){
    $res = [];
    if ( !empty($data['enabled']) ){
      $users = $user_system->online_list();
      $users_hash = md5(json_encode($users));
      if ($users_hash !== $data['usersHash']) {
        $res = [
          'users' => [
            'list' => $users,
            'hash' => $users_hash
          ],
          'serviceWorkers' => [
            'usersHash' => $users_hash
          ]
        ];
      }
    }
    return $res;
  }
]];
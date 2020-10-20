<?php
$cc = new \bbn\appui\chat($model->db, $model->inc->user);
return [[
  'id' => 'appui-core-1',
  'frequency' => 1,
  'function' => function(array $data) use($cc){
    $res = [];
    $online = $cc->get_user_status();
    if ($online !== $data['online']) {
      $res = [
        'online' => $online,
        'serviceWorkers' => [
          'online' => $online
        ]
      ];
    }
    if (!empty($online)) {
      $chats_hash = $cc->get_chats_hash();
      $chats = $cc->get_chats();
      if (empty($data['lastChat'])) {
        $data['lastChat'] = null;
      }
      $last = $data['lastChat'] ?? 0;
      if ($chats_hash !== $data['chatsHash']) {
        $res['chats'] = [
          'current' => [],
          'hash' => $chats_hash
        ];
        foreach ($chats as $c) {
          $res['chats']['current'][$c] = [
            'info' => $cc->info($c),
            'admins' => $cc->get_admins($c),
            'participants' => $cc->get_participants($c, false, true)
          ];
          if ($m = empty($data['chatsHash']) ? $cc->get_prev_messages($c) : $cc->get_next_messages($c, $data['lastChat'])) {
            $res['chats']['current'][$c]['messages'] = $m;
            $max = $m[count($m)-1]['time'];
            if (\bbn\x::compare_floats($max, $last, '>')) {
              $last = $max;
            }
          }
        }
        $res['serviceWorkers'] = [
          'chatsHash' => $chats_hash
        ];
      }
      else if (!empty($data['lastChat'])) {
        foreach ($chats as $c) {
          if ($m = $cc->get_next_messages($c, $data['lastChat'])) {
            if (!isset($res['messages'])) {
              $res['messages'] = []; 
            }
            $res['messages'][$c] = $m;
            $max = $m[count($m)-1]['time'];
            if (\bbn\x::compare_floats($max, $last, '>')) {
              $last = $max;
            }
          }
        }
      }
      if (!empty($res['chats']) || !empty($res['messages'])) {
        $res['last'] = !empty($chats_hash) ? $last : null;
        if (!isset($res['serviceWorkers'])) {
          $res['serviceWorkers'] = [];
        }
        $res['serviceWorkers']['lastChat'] = $res['last'];
      }
    }
    else if (empty($data['lastChat'])
      && ($max = $cc->get_max_last_activity())
      && ($chats_hash = $cc->get_chats_hash($max))
      && ($chats_hash !== $data['chatsHash'])
      && ($chats = $cc->get_chats($max))
    ) {
      $res['last'] = $max;
      $res['chats'] = [
        'current' => [],
        'hash' => $chats_hash
      ];
      foreach ($chats as $c) {
        $res['chats']['current'][$c] = [
          'info' => $cc->info($c),
          'admins' => $cc->get_admins($c),
          'participants' => $cc->get_participants($c, false, true),
          'messages' => $cc->get_prev_messages($c, $max)
        ];
      }
      if (!isset($res['serviceWorkers'])) {
        $res['serviceWorkers'] = [];
      }
      $res['serviceWorkers']['lastChat'] = $max;
      $res['serviceWorkers']['chatsHash'] = $chats_hash;
    }
    return $res;
  }
], [
  'id' => 'appui-core-2',
  'frequency' => 10,
  'function' => function(array $data) use($cc){
    $res = [];
    $users = $cc->get_online_users();
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
    return $res;
  }
]];
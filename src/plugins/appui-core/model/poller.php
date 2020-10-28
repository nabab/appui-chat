<?php
$cc = new \bbn\appui\chat($model->db, $model->inc->user);
return [[
  'id' => 'appui-chat-0',
  'frequency' => 1,
  'function' => function(array $data) use($cc){
    $res = [
      'success' => true,
      'data' => []
    ];
    if (isset($data['online'])) {
      $online = $cc->get_user_status();
      if ($online !== $data['online']) {
        $res['data'] = [
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
          $res['data']['chats'] = [
            'list' => [],
            'hash' => $chats_hash
          ];
          foreach ($chats as $c) {
            $res['data']['chats']['list'][$c] = [
              'info' => $cc->info($c),
              'admins' => $cc->get_admins($c),
              'participants' => $cc->get_participants($c, false, true)
            ];
            if ($m = empty($data['chatsHash']) ? $cc->get_prev_messages($c) : $cc->get_next_messages($c, $data['lastChat'])) {
              $res['data']['chats']['list'][$c]['messages'] = $m;
              $max = $m[count($m)-1]['time'];
              if (\bbn\x::compare_floats($max, $last, '>')) {
                $last = $max;
              }
            }
          }
          $res['data']['serviceWorkers'] = [
            'chatsHash' => $chats_hash
          ];
        }
        else if (!empty($data['lastChat'])) {
          foreach ($chats as $c) {
            if ($m = $cc->get_next_messages($c, $data['lastChat'])) {
              if (!isset($res['data']['messages'])) {
                $res['data']['messages'] = [];
              }
              $res['data']['messages'][$c] = $m;
              $max = $m[count($m)-1]['time'];
              if (\bbn\x::compare_floats($max, $last, '>')) {
                $last = $max;
              }
            }
          }
        }
        if (!empty($res['data']['chats']) || !empty($res['data']['messages'])) {
          $res['data']['last'] = !empty($chats_hash) ? $last : null;
          if (!isset($res['data']['serviceWorkers'])) {
            $res['data']['serviceWorkers'] = [];
          }
          $res['data']['serviceWorkers']['lastChat'] = $res['data']['last'];
        }
      }
      else if (empty($data['lastChat'])
        && ($max = $cc->get_max_last_activity())
        && ($chats_hash = $cc->get_chats_hash($max))
        && ($chats_hash !== $data['chatsHash'])
        && ($chats = $cc->get_chats($max))
      ) {
        $res['data']['last'] = $max;
        $res['data']['chats'] = [
          'list' => [],
          'hash' => $chats_hash
        ];
        foreach ($chats as $c) {
          $res['data']['chats']['list'][$c] = [
            'info' => $cc->info($c),
            'admins' => $cc->get_admins($c),
            'participants' => $cc->get_participants($c, false, true),
            'messages' => $cc->get_prev_messages($c, $max)
          ];
        }
        if (!isset($res['data']['serviceWorkers'])) {
          $res['data']['serviceWorkers'] = [];
        }
        $res['data']['serviceWorkers']['lastChat'] = $max;
        $res['data']['serviceWorkers']['chatsHash'] = $chats_hash;
      }
    }
    return $res;
  }
], [
  'id' => 'appui-chat-1',
  'frequency' => 10,
  'function' => function(array $data) use($cc){
    $res = [
      'success' => true,
      'data' => []
    ];
    if (isset($data['online'])) {
      $users = $cc->get_online_users();
      $users_hash = md5(json_encode($users));
      if ($users_hash !== $data['usersHash']) {
        $res['data'] = [
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
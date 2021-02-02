<?php
$cc = new \bbn\Appui\Chat($model->db, $model->inc->user);
return [[
  'id' => 'appui-chat-0',
  'frequency' => 1,
  'function' => function(array $data) use($cc){
    $res = [
      'success' => true,
      'data' => []
    ];
    if (isset($data['data']['online'])) {
      $online = $cc->getUserStatus();
      if ($online !== $data['data']['online']) {
        $res['data'] = [
          'online' => $online,
          'serviceWorkers' => [
            'online' => $online
          ]
        ];
      }
      if (!empty($online)) {
        $chats_hash = $cc->getChatsHash();
        $chats = $cc->getChats();
        if (empty($data['data']['lastChat'])) {
          $data['data']['lastChat'] = null;
        }
        $last = $data['data']['lastChat'] ?? 0;
        if ($chats_hash !== $data['data']['chatsHash']) {
          $res['data']['chats'] = [
            'list' => [],
            'hash' => $chats_hash
          ];
          foreach ($chats as $c) {
            $res['data']['chats']['list'][$c] = [
              'info' => $cc->info($c),
              'admins' => $cc->getAdmins($c),
              'participants' => $cc->getParticipants($c, false, true)
            ];
            if ($m = empty($data['data']['chatsHash']) ? $cc->getPrevMessages($c) : $cc->getNextMessages($c, $data['data']['lastChat'])) {
              $res['data']['chats']['list'][$c]['messages'] = $m;
              $max = $m[count($m)-1]['time'];
              if (\bbn\X::compareFloats($max, $last, '>')) {
                $last = $max;
              }
            }
          }
          $res['data']['serviceWorkers'] = [
            'chatsHash' => $chats_hash
          ];
        }
        else if (!empty($data['data']['lastChat'])) {
          foreach ($chats as $c) {
            if ($m = $cc->getNextMessages($c, $data['data']['lastChat'])) {
              if (!isset($res['data']['messages'])) {
                $res['data']['messages'] = [];
              }
              $res['data']['messages'][$c] = $m;
              $max = $m[count($m)-1]['time'];
              if (\bbn\X::compareFloats($max, $last, '>')) {
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
      else if (empty($data['data']['lastChat'])
        && ($max = $cc->getMaxLastActivity())
        && ($chats_hash = $cc->getChatsHash($max))
        && ($chats_hash !== $data['data']['chatsHash'])
        && ($chats = $cc->getChats($max))
      ) {
        $res['data']['last'] = $max;
        $res['data']['chats'] = [
          'list' => [],
          'hash' => $chats_hash
        ];
        foreach ($chats as $c) {
          $res['data']['chats']['list'][$c] = [
            'info' => $cc->info($c),
            'admins' => $cc->getAdmins($c),
            'participants' => $cc->getParticipants($c, false, true),
            'messages' => $cc->getPrevMessages($c, $max)
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
  'function' => function(array $data) use($model){
    $res = [
      'success' => true,
      'data' => []
    ];
    if (isset($data['data']['online'])) {
      $users = $model->getModel($model->pluginUrl('appui-chat').'/users/online')['online'];
      $users_hash = md5(json_encode($users));
      if ($users_hash !== $data['data']['usersHash']) {
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
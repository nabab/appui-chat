<?php
$chat = new \bbn\appui\chat($ctrl->db, $ctrl->inc->user);
$notifications = new \bbn\appui\notifications($ctrl->db);
$ucfg = $ctrl->inc->user->get_class_cfg();
$ufields = $ucfg['arch']['users'];
$chats = $ctrl->db->select_all([
  'table' => 'bbn_chats_users',
  'fields' => [
    'bbn_chats_users.id_chat',
    'bbn_chats_users.id_user',
    'bbn_chats_users.last_activity',
    'bbn_chats.title'
  ],
  'join' => [[
    'table' => 'bbn_chats',
    'on' => [
      'conditions' => [[
        'field' => 'bbn_chats_users.id_chat',
        'exp' => 'bbn_chats.id'
      ], [
        'field' => 'bbn_chats.blocked',
        'value' => 0
      ], [
        'field' => 'bbn_chats_users.last_activity',
        'operator' => '<',
        'exp' => 'bbn_chats.last_message'
      ]]
    ]
  ], [
    'table' => $ucfg['table'],
    'on' => [
      'conditions' => [[
        'field' => $ctrl->db->col_full_name('id_user', 'bbn_chats_users'),
        'exp' => $ctrl->db->col_full_name($ufields['id'], $ucfg['table'])
      ], [
        'field' => $ctrl->db->col_full_name($ufields['active'], $ucfg['table']),
        'value' => 1
      ]]
    ]
  ]],
  'where' => [
    'conditions' => [[
      'field' => 'bbn_chats_users.active',
      'value' => 1
    ], [
      'field' => "ADDTIME(from_unixtime(bbn_chats.last_message), '1:0:0')",
      'operator' => '<',
      'exp' => 'NOW()'
    ], [
      'logic' => 'OR',
      'conditions' => [[
        'field' => 'bbn_chats_users.last_notification',
        'operator' => 'isnull'
      ], [
        'field' => 'bbn_chats_users.last_notification',
        'operator' => '<',
        'exp' => 'bbn_chats.last_message'
      ]]
    ]]
  ]
]);
$did = 0;
foreach ($chats as $c) {
  if ($mess = $chat->get_next_messages($c->id_chat, $c->last_activity, 0, $c->id_user)) {
    $n = [
    	'title' => _('New messages received from') . ' "' . ($c->title ?: $ctrl->inc->user->get_name($mess[0]->id_user)) . '"',
      'content' => ''
  	];
    foreach ($mess as $m) {
      if (!empty($m['user'])) {
        $n['content'] .= "<div>{$ctrl->inc->user->get_name($m['user'])} " . _('wrote on') . date(' d/m/Y H:i', $m['time']) . "<br>$m[message]</div><br>";
      }
    }
    if (!empty($n['content'])
    	&& $notifications->insert($n['title'], $n['content'], 'chat/unread_messages', [$c->id_user])
      && $chat->set_last_notification($c->id_chat, $c->id_user)
    ) {
      $did++;
    }
  }
}
if (count($chats) !== $did) {
  echo _('To send') . ": " . count($chats). " - " . _('Sent') . ": $did";
}

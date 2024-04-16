<!-- CLIPBOARD BUTTON -->
<div class="bbn-right-smargin">
  <bbn-chat :url="root"
            :user-id="userId"
            ref="chat"
            :users="users"
            :online-users="usersOnline"
            :online="isChatOnline"
            @messagetochannel="messageChannel"
            @hook:mounted="onChatMounted"
            :groups="groups"/>
</div>

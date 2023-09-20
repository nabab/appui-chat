(() => {
  return {
    data() {
      return {
        root: appui.plugins['appui-task'] + '/',
        userId: '',
        users: [],
        usersOnline: [],
        groups: [],
        isChatOnline: false
      };
    },
    methods: {
      messageChannel(d) {
        return appui.messageChannel('appui-chat', d);
      },
      onChatMounted() {
        appui.register('chat', this.getRef('chat'));
      }
    }
  }
  })();
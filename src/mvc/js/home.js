// Javascript Document
(() => {
  return {
    data(){
      return {
        allUsers: appui.app.users,
        currentFilter: '',
        usersTimeout: 0,
        online: []
      }
    },
    computed: {
      users(){
        return appui.app.users.filter((a) => {
          if ( this.currentFilter && (a.text.indexOf(this.currentFilter) === -1) ){
            return false;
          }
          return a.value !== appui.app.user.id;
        })
      }
    },
    mounted(){
      this.usersTimeout = setTimeout(() => {
        this.post(this.source.root)
      })
    }
  }
})();
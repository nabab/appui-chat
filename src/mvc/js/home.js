// Javascript Document
(() => {
  return {
    data(){
      return {
        allUsers: appui.users,
        currentFilter: '',
        usersTimeout: 0,
        online: []
      }
    },
    computed: {
      users(){
        return appui.users.filter((a) => {
          if ( this.currentFilter && (a.text.indexOf(this.currentFilter) === -1) ){
            return false;
          }
          return a.value !== appui.user.id;
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
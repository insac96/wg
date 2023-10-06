import Vue from 'vue'
import axios from 'axios'

const mixin = Vue.extend({
  computed: {
    isLoading () {
      return this.$store.state.loading
    },
    isLogin () {
      return this.$store.state.user.isLogin
    },
    storeConfig () {
      return this.$store.state.config
    },
    storeUser () {
      return this.$store.state.user.profile
    },
    storeNotify () {
      return this.$store.state.notifies
    },
    storeNotifySocket () {
      return this.$store.state.notifiesSocket
    },
    storeGameConfig () {
      return this.$store.state.gameConfig
    },
    storeDark () {
      return this.$store.state.dark
    },
    publicPath () {
      return process.env.BASE_URL
    },
    routerPath () {
      return this.$route.path
    }
  },

  methods: {
    notify (text, type = 'danger') {
      if(!text) return
      const id = (new Date()).getTime();
      this.$store.commit('addNotify', { id, text, type })
      setTimeout(() => {
        const index = this.storeNotify.findIndex((item) => item.id == id)
        this.$store.commit('removeNotify', index)
      }, 2500)
    },

    notifySocket(data) {
      this.$store.commit('addNotifySocket', data)
    },

    login (user) {
      this.$utils.setCookie('token', user.token)
      this.$store.commit('setUser', user)
      this.$router.push('/home')
      this.sendSocketNotify(`VIP ${user['vip']['number']} - ${user['account'].toUpperCase()} truy cập`, user)
    },

    logout () {
      this.$utils.deleteCookie('token')
      this.$store.commit('setUser', null)
      if(this.$route.path != '/sign-in') return this.$router.push('/sign-in')
    },

    goToGame () {
      if(!!this.isLogin) return this.$router.push('/game')
      this.notify('Vui lòng đăng nhập trước')
      if(this.routerPath != '/sign-in') return this.$router.push('/sign-in')
    },

    sendSocketNotify (content, user = {}) {
      this.$socket.emit('add-notify', {
        content: content,
        ...this.storeUser,
        ...user
      })
    },

    getDark () {
      const dark = window.localStorage.getItem('dark')
      if (dark === undefined || dark === null || dark.length === 0) return
      this.$store.commit('setDark', JSON.parse(dark))
      document.body.setAttribute('dark', JSON.parse(dark))
      window.localStorage.setItem('dark', JSON.parse(dark))
    },

    toogleDark () {
      const dark = !this.storeDark
      this.$store.commit('setDark', dark)
      document.body.setAttribute('dark', dark)
      window.localStorage.setItem('dark', dark)
    },

    async getUser () {
      const user = await this.API('getUser')
      if(!user) return 

      // Socket Notify Login
      if(!this.storeUser){
        this.sendSocketNotify(`VIP ${user['vip']['number']} - ${user['account'].toUpperCase()} truy cập`, user)
      }

      this.$store.commit('setUser', user)
    },

    async getConfig () {
      let config

      if(process.env.NODE_ENV === 'production'){
        config = window.CONFIG
      }
      else {
        config = await this.API('getConfig')
      }
      
      if(config) return this.$store.commit('setConfig', config)
    },

    API (action, obj, admin = false) {
      return new Promise(async (resolve) => {
        try {
          // Start Loading
          this.$store.commit('setLoading', true)

          // Set Data Post
          const url = process.env.NODE_ENV === 'production' ? '/api/index.php' : 'http://127.0.0.1:3000/api/index.php'
          const token = this.$utils.getCookie('token')
          
          // Post API
          const post = await axios.post(url, {
            token, 
            action, 
            data: obj || {},
            controller: !!admin ? 'admin' : 'service'
          })
          
          // End Loading
          this.$store.commit('setLoading', false)

          // Get Var
          const { code, msg, data } = post.data
          const type = (code == 200 ? 'success' : 'danger')
          this.notify(msg, type)
          
          // Check and Return
          if(code == 405) return this.logout()
          if(code == 401) return this.logout()
          if(code == 200) return resolve(data || true)
          if(code != 200) return resolve(null)
        }
        catch (e){
          this.$store.commit('setLoading', false)
          this.notify('Có lỗi xảy ra, vui lòng thử lại sau')
          resolve(null)
        }
      })
    }
  }
})

Vue.mixin(mixin)
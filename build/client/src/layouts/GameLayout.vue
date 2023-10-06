<template lang="pug">
  div(class="GameLayout" :style="styleLayout" id="GameLayout")
    LayoutHeader(@open-menu="open_menu = !open_menu" @toggle-chat="toggleChat")
    LayoutIframe
    SocketChat(:open.sync="open_chat_mobile" is-game-layout)

    LayoutMenu(:open.sync="open_menu" :showNotify.sync="showNotify")
    GameRecharge

    WebNotify
    SocketNotify(v-if="storeGameConfig.notify" game)
</template>

<script>
import LayoutHeader from '@/components/game/layout/Header.vue'
import LayoutMenu from '@/components/game/layout/Menu.vue'
import LayoutIframe from '@/components/game/layout/Iframe.vue'
import GameRecharge from '@/components/game/Recharge.vue'
import WebNotify from '@/components/Notify.vue'
import SocketNotify from '@/components/socket/Notify.vue'
import SocketChat from '@/components/socket/Chat.vue'

export default {
  components: {
    LayoutHeader,
    LayoutMenu,
    LayoutIframe,
    GameRecharge,
    WebNotify,
    SocketNotify,
    SocketChat
  },
  
  data() {
    return {
      open_menu: false,
      open_chat_mobile: false,
      open_chat_desktop: false,
      showNotify: true
    }
  },

  computed: {
    styleLayout () {
      return {
        '--ui-reponsize-mobile': !!this.open_chat_mobile ? '0px' : '-100%',
        '--ui-reponsize-desktop': !!this.open_chat_desktop ? '300px' : '0px'
      }
    }
  },

  created() {
    this.checkAuth()
  },

  mounted() {
    window.document.addEventListener('login_game', this.loginGame, false)
  },

  beforeDestroy() {
    window.document.removeEventListener('login_game', this.loginGame, false)
  },

  methods: {
    checkAuth () {
      const token = this.$utils.getCookie('token')
      if(!token) return this.$router.push('/sign-in')
      this.getUser()
    },

    toggleChat () {
      this.open_chat_desktop = !this.open_chat_desktop
      this.open_chat_mobile = !this.open_chat_mobile
    },

    async loginGame (e) {
      if(!e.detail) return this.notify('Có lỗi xảy ra')
      const detail = JSON.parse(e.detail)
      const server_id = detail.server_id

      if(!server_id) return this.notify('Có lỗi xảy ra')
      await this.API('loginGame', { server_id: server_id })
    }
  },
}
</script>

<style lang="sass">
@import @/assets/reponsize.sass

.GameLayout
  --ui-reponsize: 0px

.GameLayout
  position: relative
  display: grid
  grid-template-columns: 1fr var(--ui-reponsize-desktop)
  grid-template-rows:  45px 1fr
  grid-template-areas: "header sidebar" "main sidebar"
  width: 100%
  height: 100%
  background: rgba(var(--ui-background))
  transition: all 0.25s ease
  overflow: hidden
  .GameLayoutHeader
    grid-area: header
  .GameLayoutIframe
    grid-area: main
  .SocketChat
    grid-area: sidebar
  @include mobile
    grid-template-columns: 1fr 0px
    .SocketChat
      position: fixed
      top: 0
      right: 0
      width: 400px
      height: 100%
      max-width: 80%
      right: var(--ui-reponsize-mobile)
</style>
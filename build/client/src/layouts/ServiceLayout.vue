<template lang="pug">
  div(class="ServiceLayout" :style="styleLayout")
    LayoutSidebar(:open.sync="open_left")
    SocketChat(:open.sync="open_right")
    
    div(class="ServiceLayoutView")
      LayoutHeader(@menu-left="open_left = !open_left" @menu-right="open_right = !open_right")
      div(class="Container")
        LayoutBanner(class="mb-2")
        transition(name="up" mode="out-in")
          router-view
    
    WebNotify
    SocketNotify
</template>

<script>
import LayoutHeader from '@/components/service/layout/Header.vue'
import LayoutSidebar from '@/components/service/layout/Sidebar.vue'
import LayoutBanner from '@/components/service/layout/Banner.vue'
import WebNotify from '@/components/Notify.vue'
import SocketNotify from '@/components/socket/Notify.vue'
import SocketChat from '@/components/socket/Chat.vue'

export default {
  components: {
    LayoutHeader,
    LayoutSidebar,
    LayoutBanner,
    WebNotify,
    SocketNotify,
    SocketChat,
  },
  
  data() {
    return {
      menu: [
        { title: 'Nạp Xu', icon: 'pay', to: '/pay' },
        { title: 'Cửa Hàng', icon: 'shop', to: '/shop' },
        { title: 'Sự Kiện', icon: 'event', to: '/event' },
        { title: 'Nhiệm Vụ', icon: 'mission', to: '/mission' },
        { title: 'Vòng Quay', icon: 'wheel', to: '/wheel' },
        { title: 'Xếp Hạng', icon: 'rank', to: '/rank' }
      ],

      open_left: false,
      open_right: false
    }
  },

  computed: {
    styleLayout () {
      return {
        '--ui-reponsize-left': !!this.open_left ? '0px' : '-100%',
        '--ui-reponsize-right': !!this.open_right ? '0px' : '-100%',
      }
    }
  },

  created () {
    this.checkAuth()
  },

  methods: {
    checkAuth () {
      const noCheck = ["/sign-in", "/sign-up", "/forgot"]
      const token = this.$utils.getCookie('token')
      if(noCheck.includes(this.$route.path)) return
      if(!token) return this.$store.commit('setUser', null)
      this.getUser()
    }
  },
}
</script>

<style lang="sass">
@import @/assets/reponsize.sass

.ServiceLayout
  --ui-reponsize-left: 0px
  --ui-reponsize-right: 0px

.ServiceLayout
  position: relative
  display: grid
  width: 100%
  height: 100%
  grid-template-columns: 300px 1fr 300px
  grid-template-rows: 1fr
  grid-template-areas: "sidebar_left main sidebar_right"
  transition: all 0.25s ease
  .ServiceLayoutSidebar, .SocketChat
    position: fixed
    top: 0
    width: 300px
    height: 100%
  .ServiceLayoutSidebar
    grid-area: sidebar_left
    left: 0
  .SocketChat
    grid-area: sidebar_right
    right: 0
  .ServiceLayoutView
    position: relative
    grid-area: main
    min-width: 100%
    .Container
      width: 750px
      max-width: 100%
      margin: 0 auto
      padding: var(--space)
  
  @include mobile
    grid-template-columns: 0 1fr 0
    .ServiceLayoutSidebar
      left: var(--ui-reponsize-left)
    .SocketChat
      width: 400px
      max-width: 80%
      right: var(--ui-reponsize-right)
</style>
<template lang="pug">
  div(class="AdminLayout" :style="{ '--ui-reponsize': !!open ? '300px' : '0px' }")
    LayoutHeader(@menu="open = !open")
    LayoutSidebar(:open.sync="open")
    div(class="AdminLayoutView")
      transition(name="up" mode="out-in")
        router-view
    WebNotify
    WebLoading
</template>

<script>
import LayoutHeader from '@/components/admin/layout/Header.vue'
import LayoutSidebar from '@/components/admin/layout/Sidebar.vue'
import WebNotify from '@/components/Notify.vue'
import WebLoading from '@/components/Loading.vue'

export default {
  components: {
    LayoutHeader,
    LayoutSidebar,
    WebNotify,
    WebLoading
  },
  
  data() {
    return {
      open: false
    }
  },

  created() {
    this.checkAuth()
  },

  methods: {
    checkAuth () {
      const token = this.$utils.getCookie('token')
      if(!token) return this.$router.push('/sign-in')
      this.getUser()
    }
  },
}
</script>

<style lang="sass">
@import @/assets/reponsize.sass

.AdminLayout
  --ui-reponsize: 300px
.AdminLayout
  position: relative
  display: grid
  grid-template-columns: 300px 1fr
  grid-template-rows: 55px 1fr
  grid-template-areas: "sidebar header" "sidebar main"
  width: 100%
  height: 100%
  background: rgba(var(--ui-background))
  transition: all 0.25s ease
  .AdminLayoutHeader
    grid-area: header
    z-index: 100
  .AdminLayoutSidebar
    position: fixed
    top: 0
    left: 0
    width: 300px
    height: 100%
    z-index: 99
    grid-area: sidebar
    transition: all 0.25s ease
  .AdminLayoutView
    grid-area: main
    padding: var(--space)
    overflow-y: auto

  @include mobile
    grid-template-columns: 0px 1fr
    .AdminLayoutSidebar
      left: calc(var(--ui-reponsize) - 300px)
      
</style>
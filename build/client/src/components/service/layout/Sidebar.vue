<template lang="pug">
  div(class="ServiceLayoutSidebar" ref="sidebar")
    UFlex(justify="center" align="center" class="ServiceLayoutSidebar__Top mb-2")
      img(:src="logo" height="60px" width="auto" alt="logo" v-if="logo")
      UText(v-if="!logo && !!storeConfig" size="1.2rem" weight="700") {{ storeConfig.game_name }}
    
    div(class="ServiceLayoutSidebar__Center")
      UFlex(
        class="Item" 
        align="center" 
        v-for="item in list" :key="item.icon" 
        @click="to(item.to)"
      )
        UButton(width="3rem" avatar :color="item.icon" class="mr-2")
          UIcon(:src="item.icon" size="1.3rem")
        UText(weight="500" no-wrap size="0.9rem") {{item.title}}

    UFlex(class="ServiceLayoutSidebar__Footer" align="center" justify="center" wrap="wrap" class="px-4" v-if="storeConfig")
      div(@click="openSocial(storeConfig.fanpage_link)" class="Link" v-if="storeConfig.fanpage_link")
        img(:src="`${publicPath}images/social/facebook.png`" alt="facebook")
      div(@click="openSocial(storeConfig.messenger_link)" class="Link" v-if="storeConfig.messenger_link")
        img(:src="`${publicPath}images/social/messenger.png`" alt="messenger")
      div(@click="openSocial(storeConfig.zalo_link)" class="Link" v-if="storeConfig.zalo_link")
        img(:src="`${publicPath}images/social/zalo.png`" alt="zalo")
      div(@click="openSocial(storeConfig.telegram_link)" class="Link" v-if="storeConfig.telegram_link")
        img(:src="`${publicPath}images/social/telegram.png`" alt="telegram")
      a(class="Link" v-if="storeConfig.phone_support" :href="`tel:${storeConfig.phone_support}`")
        img(:src="`${publicPath}images/social/phone.png`" alt="phone")
      a(class="Link" v-if="storeConfig.email_support" :href="`mailto:${storeConfig.email_support}`")
        img(:src="`${publicPath}images/social/email.png`" alt="email")
      
</template>

<script>
export default {
  props: {
    open: { type: Boolean }
  },

  data() {
    return {
      show: this.open,
      list: [
        { title: 'Trang chủ', icon: 'home', to: '/home' },
        { title: 'Chơi ngay', icon: 'game', to: '/game' },
        { title: 'Nạp Xu', icon: 'pay', to: '/pay' },
        { title: 'Cửa Hàng', icon: 'shop', to: '/shop' },
        { title: 'Sự Kiện', icon: 'event', to: '/event' },
        { title: 'Nhiệm Vụ', icon: 'mission', to: '/mission' },
        { title: 'Vòng Quay', icon: 'wheel', to: '/wheel' },
        { title: 'Xúc Xắc', icon: 'dice', to: '/dice' },
        { title: 'Xếp Hạng', icon: 'rank', to: '/rank' },
        { title: 'GiftCode', icon: 'giftcode', to: '/giftcode' }
      ]
    }
  },

  computed: {
    logo () {
      if(!this.storeConfig || !this.storeConfig.game_logo) return null
      return this.storeConfig.game_logo
    }
  },

  watch: {
    open (val) {
      if(!!val){
        this.show = true
        window.addEventListener('click', this.clickOutside)
      }

      if(!val){
        this.show = false
        window.removeEventListener('click', this.clickOutside)
      }
    }
  },

  methods: {
    close () {
      this.$emit('update:open', false)
    },

    to (link) {
      this.close()
      this.$router.push(link)
    },

    clickOutside (event) {
      const el = this.$refs['sidebar']
      if(!el) return
      if(
        el == event.target 
        || el.contains(event.target) 
        || event.target.classList.contains('bx-menu-alt-left')
      ) return
      return this.$emit('update:open', false)
    },

    openSocial (link) {
      if(!link) return
      window.open(link, '_blank')
    },
  },
}
</script>

<style lang="sass">
.ServiceLayoutSidebar
  display: flex
  flex-direction: column
  background: rgb(var(--ui-content))
  padding: var(--space)
  box-shadow: 3px 0 20px -10px rgba(0,0,0,0.3)
  transition: all 0.25s ease
  overflow: hidden
  z-index: 99
  &__Top
    min-height: var(--header)
  &__Center
    flex-grow: 1
    overflow-y: auto
    .Item
      background: rgba(var(--ui-gray-100))
      border-radius: var(--radius)
      padding: calc(var(--space) * 0.5)
      margin-bottom: calc(var(--space) * 0.5)
      cursor: pointer
  &__Footer
    .Link
      cursor: pointer
      margin: 6px
      img
        width: 35px
        height: 35px
</style>
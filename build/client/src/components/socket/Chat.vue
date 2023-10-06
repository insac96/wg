<template lang="pug">
  div(class="SocketChat" ref="sidebar")
    UFlex(class="SocketChat__Top px-2" align="center" full)
      UIcon(src="bx-x" class="mr-2" @click="close")
      UText(weight="600" class="mr-auto") Online
      UChip(icon="bx-group" color="success" full) {{socketOnline}}

    transition(name="up")
      div(class="SocketChat__Pin" v-if="socketPin")
        UAlert(color="info" icon="bxs-cat") {{socketPin}}
        
    div(class="SocketChat__Body" ref="box")
      transition(name="up")
        UAlert(v-if="socketChats && socketChats.length == 0" border) Chưa có tin nhắn nào

      transition-group(tag="div" name="chat")
        UFlex(class="Chat" v-for="item in socketChats" :key="item.id")
          div(class="Chat__Avatar mr-2")
            img(:src="`${publicPath}images/avatar/${item.vip}.webp`" :alt="item.account")
          UBox(class="Chat__Info" :color="item.type > 0 ? `type-${item.type}` : null" :flat="item.type > 0")
            template(#header)
              UFlex(align="center" justify="space-between")
                UText(:color="`type-${item.type}`" size="0.8rem" weight="700" class="capitalize" mini) {{ item.account }}
                UIcon(src="bx-reply" @click="setReply(item.account)")
            div(class="Chat__Message") 
              span(v-if="item.reply" class="Chat__Message__Reply mr-1" @click="setReply(item.reply)") @{{item.reply}}
              span(class="Chat__Message__Content") {{ item.message }}


    form(class="SocketChat__Footer" @submit.prevent="onChat")
      transition(name="up")
        UFlex(align="center" class="pt-1 pb-2" v-if="reply")
          UText(size="0.8rem" class="mr-1") Trả lời
          UText(size="0.8rem" weight="700" color="primary") @{{reply}}
          UIcon(src="bx-x" class="ml-auto" @click="reply = null")
      UFlex(align="center" justify="space-between")
        UInput(v-model="message" placeholder="Nhập nội dung" width="100%" class="mb-0 mr-1")
        UButton(avatar size="47px") 
          UIcon(src="bx-send" size="1.2rem")
</template>

<script>
export default {
  props: {
    open: { type: Boolean },
    isGameLayout: { type: Boolean }
  },

  data() {
    return {
      show: this.open,

      socketOnline: 0,
      socketChats: null,
      socketPin: null,

      message: null,
      reply: null
    }
  },

  sockets: {
    online: function (data) {
      this.socketOnline = data
    },
    pin: function (data) {
      this.socketPin = data
    },
    chat: function (data) {
      this.socketChats.push(data)
      setTimeout(() => this.toBottom(), 1)
    },
    chats: function (data) {
      this.socketChats = data
      setTimeout(() => this.toBottom(), 1)
    }
  },

  mounted () {
    this.$socket.emit('get-chat-data')
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
    setReply (name) {
      this.reply = name
    },

    onChat () {
      if(!this.isLogin) return this.notify('Vui lòng đăng nhập trước')
      if(!this.storeUser) return this.notify('Vui lòng tải lại trang')
      if(!this.message) return this.notify('Vui lòng nhập nội dung tin nhắn')

      this.$socket.emit('add-chat', {
        message: this.message,
        reply: this.reply,
        ...this.storeUser
      })

      this.message = null
      this.reply = null
    },

    toBottom () {
      const box = this.$refs.box
      box.scroll({ top: box.scrollHeight, behavior: 'smooth' });
    },

    close () {
      this.$emit('update:open', false)
    },

    clickOutside (event) {
      const el = this.$refs['sidebar']
      if(!el) return
      if(
        el == event.target 
        || el.contains(event.target) 
        || event.target.classList.contains('bx-chat')
      ) return
      return this.$emit('update:open', false)
    }
  },
}
</script>

<style lang="sass">
@import @/assets/reponsize.sass

.SocketChat
  display: flex
  flex-direction: column
  align-items: center
  background: rgb(var(--ui-content))
  box-shadow: -3px 0 20px -10px rgba(0,0,0,0.3)
  transition: all 0.25s ease
  overflow: hidden
  z-index: 99
  &__Top
    min-height: var(--header)
    max-height: var(--header)
    background: rgba(var(--ui-black), 0.05)
    .bx-x
      @include desktop
        display: none
  &__Pin
    width: 100%
    padding: var(--space)
  &__Body
    width: 100%
    flex-grow: 1
    overflow-y: auto
    overflow-x: hidden
    padding: var(--space)
    .Chat
      margin-bottom: var(--space)
      &__Avatar
        img
          width: 40px
          height: 40px
          border-radius: var(--radius)
          box-shadow: 0px 0px 15px -5px rgba(0,0,0,0.4)
      &__Info
        @include mobile
          min-width: auto
        @include desktop
          flex-grow: 1
      &__Message
        word-break: break-word
        span
          font-size: 0.9rem
        &__Content
          font-weight: 500
        &__Reply
          font-weight: 700
          color: rgba(var(--ui-primary), 1)
    .chat-enter-active, .chat-leave-active
      transition: all 0.25s ease
    .chat-leave-active
      position: absolute
    .chat-enter
      opacity: 0
      transform: translateY(100%)
    .chat-leave-to
      opacity: 0
  &__Footer
    width: 100%
    padding: calc(var(--space) / 2) var(--space)
    background: rgba(var(--ui-black), 0.05)
</style>
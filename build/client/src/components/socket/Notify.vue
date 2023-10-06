<template lang="pug">
  div(:class="`SocketNotify SocketNotify--${!!game ? 'game' : 'default'}`")
    transition(name="notify-socket")
      UFlex(
        v-if="notify"
        :class="classEffect"
        :style="styleEffect"
        align="center"
      ) 
        div(class="Notify__Content") 
          UText(weight="600" size="0.85rem") {{ notify.content }}
        //- img(:src="effectData.img" :width="effectData.w" :height="effectData.h")
        img(:src="effectData.img" :width="effectData.w" :height="effectData.h")
</template>

<script>
export default {
  props: {
    game: { type: Boolean } 
  },

  data() {
    return {
      notify: null,

      config: {
        'dragon-red': { w: 'auto', h: '140px', tx: '-50%', ty: '-20%', color: '184, 57, 28' },
        'dragon-blue': { w: 'auto', h: '140px', tx: '-55%', ty: '-20%', color: '38, 112, 163' },
        'dragon-green': { w: 'auto', h: '130px', tx: '-45%', ty: '-5%', color: '42, 135, 115' },
      }
    }
  },

  computed: {
    effectData () {
      if(!this.notify) return null

      const effect = this.notify.effect
      const isVIP = effect.includes('vip')

      if(!!isVIP){
        const num = effect.split('-')[1]
        return {
          type: 'vip',
          img: `${this.publicPath}images/avatar/${num}.webp`,
          w: '45px',
          h: '45px',
          tx: '-var(--space) * 2',
          ty: '0',
          color: `--ui-vip-${num}`,
        }
      }
      else {
        return {
          type: 'custom',
          img: `${this.publicPath}images/effect/${effect}.gif`,
          ...this.config[effect]
        }
      }
    },

    styleEffect () {
      if(!this.effectData) return {}
      return {
        '--ui-notify-color': this.effectData.type == 'custom' ? this.effectData.color : `var(${this.effectData.color})`,
        '--ui-notify-img-x': this.effectData.tx,
        '--ui-notify-img-y': this.effectData.ty
      }
    },

    classEffect () {
      if(!this.effectData) return {}
      return {
        'Notify': true,
        'Notify--VIP': this.effectData.type == 'vip',
        'Notify--CUSTOM': this.effectData.type == 'custom'
      }
    }
  },

  watch: {
    storeNotifySocket () {
      this.getNewNotify()
    },
  },

  methods: {
    getNewNotify () {
      if(!!this.notify) return
      if(this.storeNotifySocket.length == 0) return
      this.notify = this.storeNotifySocket[0]

      setTimeout(() => {
        const index = this.storeNotifySocket.findIndex((notify) => notify.id == this.notify.id)
        this.notify = null
        setTimeout(() => this.$store.commit('removeNotifySocket', index), 1000)
      }, this.notify.dup)
    }
  },
}
</script>

<style lang="sass">
@import @/assets/reponsize.sass

.SocketNotify
  position: fixed
  width: auto
  height: auto
  display: inline-flex
  align-items: center
  justify-content: center
  z-index: 999999
  &--game
    top: calc(45px + var(--space))
    left: var(--space)
  &--default
    top: calc(var(--header) + var(--space))
    @include mobile
      left: var(--space)
    @include desktop
      left: calc(300px + var(--space))

  .Notify
    position: relative
    &--VIP
      img
        border-radius: 50%
        box-shadow: 0px 0px 15px -5px rgba(0,0,0,0.4)
        transform: translateX(calc(var(--space) * -1))
    &--CUSTOM
      img
        transform: translateX(var(--ui-notify-img-x)) translateY(var(--ui-notify-img-y))
    img
      z-index: 0
      
    &__Content
      display: flex
      align-items: center
      max-width: 280px
      min-height: 38px
      background-image: linear-gradient(0deg, rgb(var(--ui-notify-color)), rgba(var(--ui-notify-color), 0.8))
      color: rgb(var(--ui-light))
      padding: var(--space)
      padding-right: calc(var(--space) * 2)
      transform: skewX(-3deg)
      border-radius: var(--radius)
      box-shadow: 0px 0px 15px -5px rgba(0,0,0,0.4)

  @keyframes notify-socket 
    0%
      opacity: 0
      transform: translateX(-50%)
    100%
      opacity: 1
      transform: translateX(0)

  .notify-socket-enter-active 
    animation: notify-socket .25s ease forwards
  .notify-socket-leave-active 
    animation: notify-socket .25s reverse ease forwards
</style>
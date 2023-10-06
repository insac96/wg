<template lang="pug">
  div(class="ServiceLayoutBanner")
    div(class="Banner")
      img(:src="banner" alt="banner")
    UButton(size="4rem" color="danger" avatar class="Play jump-anim" @click="$router.push('/game')")
      UIcon(src="bx-play" size="3rem")
</template>

<script>
export default {
  computed: {
    banner () {
      if(!this.storeConfig || !this.storeConfig.game_banner) return `${this.publicPath}images/banner.png`
      return this.storeConfig.game_banner
    }
  },
}
</script>

<style lang="sass">
.ServiceLayoutBanner
  position: relative
  display: flex
  flex-direction: column
  align-items: center
  justify-content: center
  width: 100%
  overflow: hidden
  aspect-ratio: 16 / 6
  box-shadow: 0 0 20px -10px rgba(var(--ui-black), 0.2)
  border-radius: var(--radius)
  .Banner
    width: 100%
    height: 100%
    img
      width: 100%
      height: 100%
      object-fit: fill
    &::after
      position: absolute
      content: ''
      top: 0
      left: 0
      width: 100%
      height: 100%
      background: rgba(0,0,0,0.1)
  .Play
    position: absolute
    border-radius: 50%
    .UiIcon
      transform: translateX(3px)
</style>
<template lang="pug">
  div(class="GameLayoutIframe")
    iframe(:src="src")
</template>

<script>
export default {
  computed: {
    src () {
      return (process.env.NODE_ENV == 'production') ? '/game/jump.html' : 'http://127.0.0.1:3000/game/jump.html'
    }
  },
}
</script>

<style lang="sass">
.GameLayoutIframe
  min-width: 100%
  min-height: 100%
  width: 100%
  height: 100%
  max-width: 100%
  max-height: 100%
  overflow: hidden
  iframe
    width: 100%
    height: 100%
    border: none
    outline: none
</style>
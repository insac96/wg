<template lang="pug">
  transition(name="loading-down")
    UFlex(class="Loading" align="center" v-if="show")
      UIcon(src="bx-loader" class="spin-anim mr-1" size="1.4rem")
      UText(no-wrap weight="600" size="0.85rem") API Loading...
</template>

<script>
export default {
  data() {
    return {
      show: false,
      timeout: null
    }
  },

  watch: {
    isLoading (val) {
      if(!!this.timeout) return

      if(!!val){
        this.show = true
      }
      else {
        this.timeout = setTimeout(() => {
          this.show = false 
          this.timeout = null
        }, 500)
      }
    }
  },
}
</script>

<style lang="sass">
.Loading
  position: fixed !important
  top: 0
  left: 50%
  transform: translateY(-0%) translateX(-50%)
  padding: var(--space)
  border-radius: 0 0 var(--radius) var(--radius)
  background-image: linear-gradient(0deg, rgb(var(--ui-primary)), rgba(var(--ui-primary), 0.7))
  color: rgb(var(--ui-light))
  box-shadow: 0 3px 3px rgba(var(--ui-primary), 0.15), 0 3px 1px -2px rgba(var(--ui-primary),0.2), 0 1px 5px rgba(var(--ui-primary),0.15)
  z-index: 99999
  @media (min-width: 769px)
    left: calc(50% + 150px)

@keyframes loading-down
  0%
    opacity: 0
    transform: translateY(-100%) translateX(-50%)

  100%
    opacity: 1
    transform: translateY(0%) translateX(-50%)

.loading-down-enter-active 
  animation: loading-down .25s ease forwards
.loading-down-leave-active 
  animation: loading-down .25s reverse ease forwards
</style>
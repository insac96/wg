<template>
  <div class="UiScrollX" ref="slider">
    <slot></slot>
  </div>
</template>

<script>
export default {
  mounted () {
    this.$refs.slider.addEventListener('wheel', this.scrollWheel)
  },

  beforeDestroy () {
    this.$refs.slider.removeEventListener('wheel', this.scrollWheel)
  },

  methods: {
    scrollWheel (e) {
      e.preventDefault();
      this.$refs.slider.scrollLeft += e.deltaY
    }
  }
}
</script>

<style lang="sass">
.UiScrollX
  position: relative
  width: 100%
  overflow-x: auto
  overflow-y: hidden
  transition: all 0.2s
  will-change: transform
  white-space: nowrap
  cursor: pointer
  scrollbar-width: none
  scroll-snap-type: x mandatory
  &::-webkit-scrollbar
    display: none
  > div
    display: inline-block
</style>
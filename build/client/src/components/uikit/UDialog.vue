<template>
  <transition name="show">
    <div 
      v-if="!!show"
      :class="{
          'UiDialog': true,
          'UiDialog--Blur': !!blur && !!overlay,
          'UiDialog--Full': !!full,
          'UiDialog--Default': !full
      }"
      :style="{
        '--ui-dialog-max': max
      }"
      ref="dialog"
    >
      <div 
        :class="{
          'UiDialog__Overlay': true,
          'UiDialog__Overlay--Hidden': !overlay
        }"
        @click="hide"
      ></div>

      <div class="UiDialog__Content">
        <slot></slot>
      </div>
    </div>
  </transition>
</template>

<script>
export default {
  props: {
    'show': { type: Boolean, default: false },
    'blur': { type: Boolean, default: false },
    'overlay': { type: Boolean, default: true },
    'full': { type: Boolean, default: false },
    'max': { type: String, default: null },
  },

  model: {
    prop: 'show',
    event: 'change'
  },

  mounted() {
    if(!!this.show) {
      this.$emit('show')
    }
  },
  
  watch: {
    show (val) {
      if(!!val) return this.$emit('show')
      this.$emit('hide')
    }
  },

  methods: {
    hide () {
      this.$emit('change', false)
    }
  }
}
</script>

<style lang="sass">
.UiDialog
  position: fixed
  width: 100%
  height: 100%
  max-width: 100%
  max-height: 100%
  top: 0
  left: 0
  display: flex
  align-items: center
  justify-content: center
  overflow: hidden
  z-index: 99998

  &--Full
    --ui-dialog-max: 100%
    padding: 0
    &.UiDialog--Blur
      backdrop-filter: saturate(180%) blur(50px)
    &.show-enter-active 
      --ui-dialog-animation: show .25s ease forwards
    &.show-leave-active 
      --ui-dialog-animation: show .25s reverse ease forwards
    .UiDialog__Content
      width: 100%
      height: 100%
      max-height: 100%
      overflow: hidden

  &--Default
    --ui-dialog-max: 500px
    padding: var(--space)
    &--Blur
      backdrop-filter: saturate(180%) blur(15px)
    &.show-enter-active 
      --ui-dialog-animation: zoom .25s ease forwards
    &.show-leave-active 
      --ui-dialog-animation: zoom .25s reverse ease
    .UiDialog__Content 
      width: var(--ui-dialog-max)
      height: auto
      
  &__Overlay
    position: absolute
    width: 100%
    height: 100%
    top: 0
    left: 0
    background: rgba(0, 0, 0, 0.5)
    cursor: pointer
    z-index: 1
    &--Hidden
      background: none

  &__Content
    position: relative
    display: flex
    align-items: center
    justify-content: center
    max-width: 100%
    animation: var(--ui-dialog-animation)
    z-index: 2
</style>
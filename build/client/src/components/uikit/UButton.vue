<template>
  <button 
    :class="{
      'UiButton': true,
      'UiButton--block': block,
      'UiButton--avatar': avatar,
      'disabled': disabled
    }"
    :style="{
      '--ui-button-color': !!color ? `var(--ui-${_color(color)})` : null,
      '--ui-button-width': width,
      '--ui-button-height': height,
      '--ui-button-size': size,
    }"
    @click="$emit('click')"
    :type="type"
  >
    <slot></slot>
  </button>
</template>

<script>
export default {
  props: {
    color: { type: String, default: null },
    block: { type: Boolean, default: null },
    avatar: { type: Boolean, default: null },
    disabled: { type: Boolean, default: null },
    width: { type: String, default: null },
    height: { type: String, default: null },
    size: { type: String, default: null },
    type: { type: String, default: null },
  }
}
</script>

<style lang="sass">
.UiButton
  --ui-button-color: var(--ui-primary)
  --ui-button-width: auto
  --ui-button-height: var(--size)
  --ui-button-size: var(--size)

.UiButton 
  position: relative
  display: inline-flex
  align-items: center
  justify-content: center
  width: var(--ui-button-width)
  max-width: var(--ui-button-width)
  height: var(--ui-button-height)
  max-height: var(--ui-button-height)
  background-image: linear-gradient(0deg, rgb(var(--ui-button-color)), rgba(var(--ui-button-color), 0.7))
  color: rgb(var(--ui-light))
  box-shadow: 0 3px 3px rgba(var(--ui-button-color), 0.15), 0 3px 1px -2px rgba(var(--ui-button-color),0.2), 0 1px 5px rgba(var(--ui-button-color),0.15)
  border-radius: var(--radius)
  padding: 0 var(--space)
  font-weight: 700
  text-transform: uppercase
  transition: all 0.25s ease
  cursor: pointer
  overflow: hidden
  white-space: nowrap
  &--block
    display: flex 
  &--avatar
    min-width: var(--ui-button-size)
    max-width: var(--ui-button-size)
    min-height: var(--ui-button-size)
    max-height: var(--ui-button-size)
    padding: 0
</style>
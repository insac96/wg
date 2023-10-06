<template>
  <div 
    :class="{
      'UiAlert': true,
      'UiAlert--border': border,
    }"
    :style="{
      '--ui-alert-color': !!color ? `var(--ui-${_color(color)})` : null,
    }"
  > 
    <UIcon :src="icon" size="1.5rem" class="mr-2"></UIcon>
    <slot></slot>
  </div>
</template>

<script>
export default {
  props: {
    color: { type: String, default: null },
    icon: { type: String, default: 'alert' },
    border: { type: Boolean, default: false }
  }
}
</script>

<style lang="sass">
.UiAlert
  --ui-alert-color: var(--ui-danger)

.UiAlert
  display: flex
  align-items: center
  background-image: linear-gradient(0deg, rgb(var(--ui-alert-color)), rgba(var(--ui-alert-color), 0.7))
  color: rgb(var(--ui-light))
  box-shadow: 0 3px 3px rgba(var(--ui-alert-color), 0.15), 0 3px 1px -2px rgba(var(--ui-alert-color),0.2), 0 1px 5px rgba(var(--ui-alert-color),0.15)
  border-radius: var(--radius)
  padding: var(--space)
  font-size: 0.85rem
  font-weight: 600
  &--border
    background: rgba(var(--ui-alert-color), 0.1)
    color: rgba(var(--ui-alert-color), 1)
    border: 1px solid rgba(var(--ui-alert-color), 1)
    box-shadow: none
</style>
<template>
  <p
    :class="{
      'UiText': true,
      'UiText--nowrap': noWrap,
      'UiText--mini': mini,
      'pointer': !!$listeners.click
    }"
    :style="{ 
      'color': !!color ? `rgb(var(--ui-${_color(color)}))` : null,
      'font-size': size,
      'font-weight': weight,
    }"
    @click="$emit('click')"
  >
    <slot></slot>
  </p>
</template>

<script>
export default {
  props: {
    color: { type: String, default: null },
    size: { type: String, default: null },
    weight: { type: String, default: null },
    noWrap: { type: Boolean, default: false },
    mini: { type: Boolean, default: false },
  },
}
</script>

<style lang="sass">
.UiText
  &--nowrap
    white-space: nowrap
  &--mini
    max-width: 100%
    white-space: nowrap
    text-overflow: ellipsis
    word-wrap: break-word
    overflow: hidden
</style>
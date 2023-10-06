<template>
  <div
    :class="{
      'UiChip': true,
      'UiChip--icon': icon,
      'UiChip--full': full,
      'UiChip--border': border,
      'UiChip--flat': flat,
      'UiChip--large': large,
      'pointer': !!$listeners.click
    }"
    :style="{
      '--ui-chip-color': !!color ? `var(--ui-${_color(color)})` : null,
      '--ui-chip-width': width,
      '--ui-chip-height': height,
    }"
    @click="$emit('click')"
  >
    <UText size="0.8rem" weight="700" no-wrap><slot></slot></UText>
    <div class="UiChip__Icon" v-if="icon">
      <UIcon :src="icon"></UIcon>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    color: { type: String, default: null },
    full: { type: Boolean, default: false },
    width: { type: String, default: null },
    height: { type: String, default: null },
    icon: { type: String, default: null },
    border: { type: Boolean, default: false },
    flat: { type: Boolean, default: false },
    large: { type: Boolean, default: false },
  }
}
</script>

<style lang="sass">
.UiChip
  --ui-chip-color: var(--ui-primary)
  --ui-chip-text: var(--ui-text)
  --ui-chip-width: auto
  --ui-chip-height: 33px

.UiChip
  position: relative
  display: inline-flex
  align-items: center
  justify-content: center
  min-width: var(--ui-chip-width)
  max-width: var(--ui-chip-width)
  height: var(--ui-chip-height)
  background: rgb(var(--ui-gray-200))
  color: rgb(var(--ui-chip-text))
  border-radius: var(--radius)
  border: 1px dashed rgba(var(--ui-dark), 0.1)
  padding: 0 var(--space)
  user-select: all
  overflow: hidden
  &__Icon
    display: flex
    align-items: center
    justify-content: center
    min-width: calc(var(--ui-chip-height) * 0.8)
    min-height: calc(var(--ui-chip-height) * 0.8)
    max-width: calc(var(--ui-chip-height) * 0.8)
    max-height: calc(var(--ui-chip-height) * 0.8)
    background: rgb(var(--ui-chip-color))
    color: rgb(var(--ui-light))
    border-radius: var(--radius)
    margin-left: calc(var(--space) * 0.8)
    font-size: 1rem
  &--icon
    padding-right: 3px
  &--full
    --ui-chip-text: var(--ui-light)
    background-image: linear-gradient(0deg, rgb(var(--ui-chip-color)), rgba(var(--ui-chip-color), 0.7))
    border: none
    .UiChip__Icon
      background: rgb(var(--ui-chip-text))
      color: rgb(var(--ui-chip-color))
  &--border
    border-color: rgb(var(--ui-chip-color))
    color: rgb(var(--ui-chip-color))
  &--flat
    background: rgba(var(--ui-chip-color), 0.3)
    color: rgb(var(--ui-light))
  &--large
    min-height: var(--ui-chip-height)
    height: auto
    .UiText
      white-space: pre-wrap !important
      word-wrap: break-word !important
  &.pointer
    user-select: none !important
</style>
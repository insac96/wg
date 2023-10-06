<template>
  <div 
    :class="{
      'UiBox': true,
      'UiBox--color': color,
      'UiBox--flat': flat,
      'UiBox--noPadding': noPadding,
      'pointer': !!$listeners.click
    }" 
    :style="{
      '--ui-box-color': !!color ? `var(--ui-${_color(color)})` : null,
      '--ui-box-width': width,
    }"
    @click="$emit('click')"
  >
    <div class="UiBox__Header" v-if="title || $slots.header">
      <slot name="header" v-if="$slots.header"></slot>
      <UText mini weight="600" size="0.8rem" v-else>{{title}}</UText>
    </div>

    <div class="UiBox__Body">
      <slot></slot>
    </div>

    <div class="UiBox__Footer" v-if="$slots.footer">
      <slot name="footer"></slot>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    'title': { type: String, default: null },
    'width': { type: String, default: null },
    'color': { type: String, default: null },
    'flat': { type: Boolean, default: false },
    'noPadding' : { type: Boolean, default: false },
  }
}
</script>

<style lang="sass">
.UiBox
  position: relative
  width: var(--ui-box-width)
  max-width: var(--ui-box-width)
  background: rgba(var(--ui-content))
  border-radius: var(--radius)
  box-shadow: 0 0 20px -10px rgba(var(--ui-black), 0.2)
  border: 1px solid rgba(var(--ui-dark), 0.1)
  transition: all 0.25s ease
  &__Header
    background: rgba(var(--ui-black), 0.05)
    color: rgba(var(--ui-text), 1)
    padding: calc(var(--space) / 2) var(--space)
    border-radius: var(--radius) var(--radius) 0 0
  &__Body
    padding: var(--space)
  &__Footer
    background: rgba(var(--ui-black), 0.05)
    padding: calc(var(--space) * 0.5) var(--space)
    border-radius: 0 0 var(--radius) var(--radius)
  &--color
    &:not(.UiBox--flat)
      background-image: linear-gradient(0deg, rgb(var(--ui-box-color)), rgba(var(--ui-box-color), 0.7))
      box-shadow: 0 3px 3px rgba(var(--ui-box-color), 0.15), 0 3px 1px -2px rgba(var(--ui-box-color),0.2), 0 1px 5px rgba(var(--ui-box-color),0.15)
      .UiBox__Header, .UiBox__Body, .UiBox__Footer
        color: rgba(var(--ui-light), 1)
  &--flat
    background: rgba(var(--ui-box-color), 0.1)
    border-color: rgba(var(--ui-box-color), 0.5)
    .UiBox__Header
      background: rgba(var(--ui-box-color), 0.1)
    .UiBox__Footer
      background: rgba(var(--ui-box-color), 0.05)
  &--noPadding
    .UiBox__Body
      padding: 0
</style>
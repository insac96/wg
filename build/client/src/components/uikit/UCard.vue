<template>
  <div class="UiCard">
    <div class="UiCard__Header" v-if="title || $slots.header">
      <slot name="header" v-if="$slots.header"></slot>
      <UText weight="600" v-else>{{title}}</UText>
    </div>

    <div class="UiCard__Body">
      <slot></slot>
    </div>

    <div class="UiCard__Footer" v-if="$slots.footer">
      <slot name="footer"></slot>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    'title': { type: String, default: null }
  }
}
</script>

<style lang="sass">
.UiCard
  position: relative
  background: rgba(var(--ui-content))
  border-radius: var(--radius)
  box-shadow: 0 0 20px -10px rgba(var(--ui-black), 0.2)
  border: 1px solid rgba(var(--ui-dark), 0.1)
  &__Header
    background: rgba(var(--ui-black), 0.05)
    padding: var(--space)
    border-radius: var(--radius) var(--radius) 0 0
  &__Body
    padding: var(--space)
  &__Footer
    background: rgba(var(--ui-gray-100))
    padding: calc(var(--space) * 0.5) var(--space)
    border-radius: 0 0 var(--radius) var(--radius)
</style>
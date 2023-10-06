<template>
  <div class="UiTab">
    <div 
      :class="{
        'Tab': true,
        'Tab--active': tab == item[value]
      }"
      :style="{
        '--ui-tab-color': !!color ? `var(--ui-${_color(color)})` : null,
      }"
      v-for="item in list" :key="item.value"
      @click="$emit('change', item[value])"
    >
      {{item[label]}}
    </div>

    <div class="Anim"></div>
  </div>
</template>

<script>
export default {
  props: {
    list: { type: Array },
    tab: { type: String || Number },
    value: { type: String, default: 'value' },
    label: { type: String, default: 'label' },
    color: { type: String, default: null },
  },

  model: {
    'prop': 'tab',
    'event': 'change'
  }
}
</script>

<style lang="sass">
.UiTab
  --ui-tab-color: var(--ui-primary)
.UiTab
  position: relative
  white-space: nowrap
  display: inline-block
  max-width: 100%
  background: rgba(var(--ui-content))
  border-radius: var(--radius)
  box-shadow: 0 0 20px -10px rgba(var(--ui-black), 0.2)
  border: 1px solid rgba(var(--ui-dark), 0.1)
  overflow-y: hidden
  overflow-x: auto
  .Tab
    display: inline-flex
    align-items: center
    justify-content: center
    min-height: 35px
    padding: 0 var(--space)
    margin: 3px
    border-radius: inherit
    color: rgb(var(--ui-text))
    font-weight: 600
    font-size: 0.85rem
    white-space: nowrap
    cursor: pointer
    transition: all 0.1s ease
    &--active
      background-image: linear-gradient(0deg, rgb(var(--ui-tab-color)), rgba(var(--ui-tab-color), 0.7))
      color: rgb(var(--ui-light))
</style>
<template>
  <div 
    :class="{
      'UiInput': true,
      'UiInput--icon': icon,
    }"
    :style="{
      '--ui-input-color': !!color ? `var(--ui-${_color(color)})` : null,
      '--ui-input-icon-color': !!iconColor ? `var(--ui-${_color(iconColor)})` : null,
      '--ui-input-width': width,
      '--ui-input-height': height,
    }"
    @click="$emit('click')"
  >
    <div class="UiInput__Label" v-if="labelTop">{{labelTop}}</div>

    <div class="UiInput__Content">
      <div class="UiInput__Content__Icon mr-2" v-if="icon">
        <UIcon :src="icon" size="1.1rem"></UIcon>
      </div>
      
      <input 
        class="UiInput__Content__Input"
        :value="value"
        :type="type"
        :placeholder="placeholder"
        :readonly="readOnly"
        :disabled="disabled"
        @input="onInput"
      />
    </div>
  </div>
</template>

<script>
export default {
  props: {
    width: { type: String, default: null },
    height: { type: String, default: null },
    icon: { type: String, default: null },
    color: { type: String, default: null },
    iconColor: { type: String, default: null },

    value: { type: String || Number, default: null },
    type: { type: String, default: 'text' },
    placeholder: { type: String, default: null },
    labelTop: { type: String, default: null },
    readOnly: { type: Boolean, default: false },
    disabled: { type: Boolean, default: false },
  },

  model: {
    prop: 'value',
    event: 'change'
  },

  methods: {
    onInput (e) {
      this.$emit('change', e.target.value)
      this.$emit('input', e.target.value)
    }
  }
}
</script>

<style lang="sass">
.UiInput
  --ui-input-color: var(--ui-gray-100)
  --ui-input-width: auto
  --ui-input-height: calc(var(--size) + var(--space))

.UiInput
  position: relative
  margin-bottom: var(--space)
  width: var(--ui-input-width)
  &:last-child
    margin-bottom: 0
  
  &__Label
    color: rgb(var(--ui-gray-600))
    font-size: 0.8rem
    font-weight: 600
    margin-bottom: calc(var(--space) / 2)

  &__Content
    position: relative
    display: flex
    align-items: center
    width: 100%
    height: var(--ui-input-height)
    background: rgb(var(--ui-input-color))
    border-radius: var(--radius)
    padding: 0 var(--space)
    border: 1px dashed rgba(var(--ui-dark), 0.1)
    &__Input
      flex-grow: 1
      height: 100%
      background: none
      color: rgba(var(--ui-text))
      font-weight: 500
      &::placeholder
        font-weight: 300
        color: rgba(var(--ui-text), 0.8)
    &__Icon
      position: relative
      display: inline-flex
      align-items: center
      justify-content: center
      min-width: var(--size)
      max-width: var(--size)
      min-height: var(--size)
      max-height: var(--size)
      background-image: linear-gradient(0deg, rgb(var(--ui-input-icon-color)), rgba(var(--ui-input-icon-color), 0.7))
      color: rgb(var(--ui-light))
      box-shadow: 0 3px 3px rgba(var(--ui-input-icon-color), 0.15), 0 3px 1px -2px rgba(var(--ui-input-icon-color),0.2), 0 1px 5px rgba(var(--ui-input-icon-color),0.15)
      border-radius: var(--radius)
  
  &--icon
    .UiInput__Content
      padding-left: calc(var(--space) * 0.5)
</style>
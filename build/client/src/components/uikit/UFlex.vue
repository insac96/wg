<template>
  <div 
    :class="{
      'UiFlex': true,
      'UiFlex--full': !!full
    }"
    :style="{
      'align-items': align,
      'justify-content': justify,
      'flex-direction': type,
      'flex-wrap': wrap,
    }"
    @click="$emit('click')"
  >
    <slot></slot>
  </div>
</template>

<script>
export default {
  props: {
    'align': { type: String },
    'justify': { type: String },
    'type': { type: String },
    'wrap': { type: String },
    'full': { type: Boolean },
  }
}
</script>

<style lang="sass" scoped>
.UiFlex
  display: flex
  position: relative
  &--full
    width: 100%
</style>
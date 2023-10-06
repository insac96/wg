<template lang="pug">
  div(class="UiBarge" @click="$emit('click')")
    slot
    transition(name="show")
      div(class="UiBarge__Text" v-if="text") {{text}}
</template>

<script>
export default {
  props: {
    text: { type: Number || String },
  }
}
</script>

<style lang="sass">
.UiBarge
  position: relative
  &__Text
    position: absolute
    right: 0
    bottom: 0
    display: flex
    align-items: center
    justify-content: center
    min-width: 16px
    height: 16px
    max-height: 16px
    padding: 0 3px
    transform: translate(4px)
    background: rgba(var(--ui-primary))
    color: rgba(var(--ui-light))
    border-radius: var(--radius)
    font-size: 0.7rem
    font-weight: 700
    box-shadow: 0 0 20px -10px rgba(var(--ui-black), 0.2)
</style>
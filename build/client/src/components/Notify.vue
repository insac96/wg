
<template lang="pug">
  div(class="WebNotify")
    transition-group(tag="div" name="notify-alert" class="Main-Notify")
      UFlex(
        v-for="(item, index) in storeNotify"
        :key="item.id"
        class="Notify"
        :style="`background: rgba(var(--ui-${item.type}))`"
        align="center" 
      )
        UIcon(src="alert" size="1rem" class="mr-1")
        UText() {{item.text}}
</template>

<style lang="sass">
.WebNotify
  position: fixed
  top: 0
  right: 0
  width: auto
  height: auto
  max-width: 300px
  z-index: 999999
  .Main-Notify
    display: block
    text-align: right
  .Notify
    display: inline-flex
    padding: var(--space)
    padding: calc(var(--space) * 0.5)
    margin-bottom: 1px
    border-radius: var(--radius) 0 0 var(--radius)
    box-shadow: 0px 0px 15px -5px rgba(0,0,0,0.4)
    color: rgba(var(--ui-light))
    font-size: 0.85rem
    font-weight: 600
    text-align: left
  .notify-alert-enter-active, .notify-leave-active
    transition: all 0.5s ease
  .notify-alert-enter, .notify-leave-to
    opacity: 0
    transform: translateX(100%)
</style>
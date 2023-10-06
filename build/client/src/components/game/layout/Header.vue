<template lang="pug">
  UFlex(class="GameLayoutHeader" align="center")
    UIcon(src="bx-menu-alt-left" size="1.5rem" class="mr-auto" @click="$emit('open-menu')")
    UserCurrency(:diamond="false")
    UIcon(src="bx-chat" size="1.5rem" class="ml-2" @click="$emit('toggle-chat')")
</template>

<style lang="sass">
@import @/assets/reponsize.sass

.GameLayoutHeader
  position: relative
  width: 100%
  background: rgb(var(--ui-content))
  padding: var(--space)
  box-shadow: 0 5px 20px 0 #0000000d
  z-index: 100
  @include mobile
    z-index: 11
  i
    cursor: pointer
</style>
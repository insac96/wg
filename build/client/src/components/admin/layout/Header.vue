<template lang="pug">
  UFlex(class="AdminLayoutHeader" align="center")
    UIcon(src="bx-menu-alt-left" size="2rem" color="dark" @click="$emit('menu')")
    UText(weight="700" class="mr-auto ml-2") {{ $route.name }}
    UChip()
      span Xin chào, 
      span(class="capitalize") {{storeUser.account}}
    UChip(full color="danger" class="ml-1" @click="$router.push('/')") Thoát
</template>

<style lang="sass">
.AdminLayoutHeader
  position: sticky
  top: 0
  background: rgb(var(--ui-content))
  padding: var(--space)
  box-shadow: 0px 5px 20px -10px rgba(0,0,0,0.2)
  i
    cursor: pointer
</style>
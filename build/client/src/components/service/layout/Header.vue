<template lang="pug">
  div(class="ServiceLayoutHeader")
    UFlex(class="Content" align="center")
      UIcon(src="bx-menu-alt-left" size="2rem" class="mr-2" @click="$emit('menu-left')")
      UText(class="Title" size="1rem" weight="700") {{$route.name}}

      UFlex(v-if="!isLogin" align="center" class="ml-auto")
        UButton(class="mr-1" @click="$router.push('/sign-in')") Đăng Nhập
        UButton(color="danger" @click="$router.push('/sign-up')") Đăng Ký
        UBarge(color="time" @click="$emit('menu-right')" class="ChatIcon ml-2")
          UIcon(src="bx-chat" size="1.5rem")

      UFlex(v-else align="center" class="ml-auto")
        UBarge(@click="toogleDark")
          UIcon(src="bx-moon" size="1.5rem" v-if="!storeDark")
          UIcon(src="bx-sun" size="1.5rem" v-else)
        UBarge(color="time" @click="$router.push('/notify')" class="ml-2")
          UIcon(src="bx-bell" size="1.5rem")
        UBarge(color="time" @click="$router.push('/user')" class="ml-2")
          UIcon(src="bx-user" size="1.5rem")
        UBarge(color="time" @click="$emit('menu-right')" class="ChatIcon ml-2")
          UIcon(src="bx-chat" size="1.5rem")
</template>

<script>
export default {
  data() {
    return {
      dark: false
    }
  }
}
</script>

<style lang="sass">
@import @/assets/reponsize.sass

.ServiceLayoutHeader
  position: sticky
  top: 0
  z-index: 100
  @include mobile
    z-index: 11
  .Content
    height: var(--header)
    max-height: var(--header)
    background: rgb(var(--ui-content))
    padding: var(--space)
    box-shadow: 0 5px 20px 0 #0000000d
    i
      cursor: pointer
    .Account
      text-transform: capitalize
    
    @include desktop
      .ChatIcon
        display: none
    @include mobile
      .ChatIcon
        display: inline-block
      .Title
        display: none
</style>
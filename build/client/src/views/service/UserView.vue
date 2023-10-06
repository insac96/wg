<template lang="pug">
  div(class="UserView")
    UserMini(class="mb-2")
    UserInfo
</template>

<script>
import UserMini from '@/components/service/user/Mini'
import UserInfo from '@/components/service/user/Info'

export default {
  components: {
    UserMini,
    UserInfo
  },

  created () {
    const token = this.$utils.getCookie('token')
    if(!token) return this.$router.push('/home')
    this.getUser()
  },
}
</script>
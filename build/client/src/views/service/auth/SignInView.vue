<template lang="pug">
  form(@submit.prevent="sign")
    UCard(title="Đăng Nhập")
      UInput(v-model="account" placeholder="Tài khoản" type="text" icon="user" icon-color="user")
      UInput(v-model="password" placeholder="Mật khẩu" type="password" icon="password" icon-color="password")
      template(#footer)
        UFlex(justify="space-between" align="center")
          UChip(@click="$router.push('/sign-forgot')") Quên mật khẩu?
          UButton(type="submit") Đăng Nhập
</template>

<script>
export default {
  data() {
    return {
      account: null,
      password: null
    }
  },

  created () {
    this.$utils.deleteCookie('token')
    this.$store.commit('setUser', null)
  },

  methods: {
    async sign () {
      if(!this.account || !this.password) return this.notify('Vui lòng nhập đầy đủ thông tin')

      const user = await this.API('sign', {
        account: this.account,
        password: this.password,
        type: 'in'
      })

      if(!!user) return this.login(user)
    }
  },
}
</script>
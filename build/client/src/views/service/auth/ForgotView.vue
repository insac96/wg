<template lang="pug">
  form(@submit.prevent="sign")
    UCard(title="Quên Mật Khẩu")
      UInput(v-model="account" placeholder="Tài khoản" type="text" icon="user" icon-color="user")
      UInput(v-model="password" placeholder="Mật khẩu mới" type="password" icon="password" icon-color="password")
      UInput(v-model="phone" placeholder="Số điện thoại đăng ký" type="text" icon="phone" icon-color="phone")
      template(#footer)
        UFlex(justify="flex-end" align="center")
          UButton(type="submit") Gửi Yêu Cầu
</template>

<script>
export default {
  data() {
    return {
      account: null,
      password: null,
      phone: null,
    }
  },

  created () {
    this.$utils.deleteCookie('token')
    this.$store.commit('setUser', null)
  },

  methods: {
    async sign () {
      if(!this.account || !this.password || !this.phone) return this.notify('Vui lòng nhập đầy đủ thông tin')
      
      const forgot = await this.API('sign', {
        account: this.account,
        password: this.password,
        phone: this.phone,
        type: 'forgot'
      })
      
      if(!!forgot) return this.$router.push('/sign-in')
    }
  },
}
</script>
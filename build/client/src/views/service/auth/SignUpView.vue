<template lang="pug">
  form(@submit.prevent="sign")
    UCard(title="Đăng Ký")
      UInput(v-model="account" placeholder="Tài khoản" type="text" icon="user" icon-color="user")
      UInput(v-model="password" placeholder="Mật khẩu" type="password" icon="password" icon-color="password")
      UInput(v-model="phone" placeholder="Số điện thoại" type="text" icon="phone" icon-color="phone")
      UInput(v-model="referral_code" placeholder="Mã mời nếu có" type="text" icon="code" icon-color="referraler")
      USelect(v-model="reg_from" :list="listAds" value="id" label="name" icon="bxs-spreadsheet" icon-color="dark" placeholder="Bạn biết đến trò chơi từ đâu?" v-if="listAds && listAds.length > 0")
      template(#footer)
        UFlex(justify="space-between" align="center")
          UChip(@click="$router.push('/sign-in')") Đã có tài khoản?
          UButton(type="submit") Đăng Ký
</template>

<script>
export default {
  data() {
    return {
      listAds: null,
      account: null,
      password: null,
      phone: null,
      referral_code: this.$route.params.code || null,
      reg_from: null,
    }
  },

  created () {
    this.getAllAds()
    this.$utils.deleteCookie('token')
    this.$store.commit('setUser', null)
  },

  methods: {
    async getAllAds () {
      const list = await this.API('getAllAds')
      if(!!list) return this.listAds = list
    },

    async sign () {
      if(!this.account || !this.password || !this.phone) return this.notify('Vui lòng nhập đầy đủ thông tin')
      if(this.listAds && this.listAds > 0 && !this.reg_from) return this.notify('Vui lòng chọn nguồn biết đến trò chơi')

      const user = await this.API('sign', {
        account: this.account,
        password: this.password,
        phone: this.phone,
        referral_code: this.referral_code,
        reg_from: this.reg_from,
        type: 'up',
      })
      
      if(!user) return this.getAllAds()
      if(!!user) return this.login(user)
    }
  },
}
</script>
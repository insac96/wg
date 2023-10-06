<template lang="pug">
  UFlex(justify="center" align="center" wrap="wrap" v-if="selectUser")
    UCard(class="box-resize-33" title="Tiền tệ" )
      UInput(v-model="selectUser.coin" label-top="Xu" disabled)
      UInput(v-model="selectUser.coin_lock" label-top="Xu khóa" type="number" disabled)
      UInput(v-model="selectUser.diamond" label-top="Kim cương" type="number" disabled)
      UInput(v-model="selectUser.wheel" label-top="Lượt quay" type="number" disabled)
    UCard(class="box-resize-33" title="Tích nạp")
      UInput(v-model="selectUser.pay_day" label-top="Ngày" type="number")
      UInput(v-model="selectUser.pay_month" label-top="Tháng" type="number")
      UInput(v-model="selectUser.pay_all" label-top="Tổng" type="number")
      template(#footer)
        UButton(width="100%" @click="updateUserPaySpend") Lưu thông tin
    UCard(class="box-resize-33" title="Tiêu phí")
      UInput(v-model="selectUser.spend_day" label-top="Ngày" type="number")
      UInput(v-model="selectUser.spend_month" label-top="Tháng" type="number")
      UInput(v-model="selectUser.spend_all" label-top="Tổng" type="number")
      template(#footer)
        UButton(width="100%" color="success" @click="updateUserPaySpend") Lưu thông tin
</template>

<script>
export default {
  props: {
    user: { type: Object }
  },

  data() {
    return {
      selectUser: JSON.parse(JSON.stringify(this.user)),
    }
  },
  
  watch: {
    user (val) {
      this.selectUser = JSON.parse(JSON.stringify(val))
    }
  },

  methods: {
    async updateUserPaySpend () {
      if(!this.selectUser) return this.notify('Vui lòng chọn tài khoản trước');
      const update = await this.API('updateUserPaySpend', this.selectUser, true)
      if(!!update) return this.$emit('reload')
    },
  },
}
</script>
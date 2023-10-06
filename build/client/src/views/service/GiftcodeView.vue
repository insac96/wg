<template lang="pug">
  UCard(title="GiftCode" class="GiftCodeView")
    SelectServer(v-model="server_id" class="mb-2" v-if="!!isLogin")  
    UInput(v-model="giftcode" icon-color="giftcode" icon="bxs-gift" placeholder="Nhập mã quà tặng")
    template(#footer)
      UFlex(justify="flex-end")
        UButton(@click="getGiftCode" color="giftcode") Xác nhận
</template>

<script>
export default {
  name: 'GiftCodeView',

  data() {
    return {
      giftcode: null,
      server_id: null,
    }
  },

  methods: {
    async getGiftCode () {
      if(!this.isLogin) return this.notify('Vui lòng đăng nhập trước')
      if(!this.server_id) return this.notify('Vui lòng chọn máy chủ')
      if(!this.giftcode) return this.notify('Vui lòng nhập mã GiftCode')
       await this.API('getGiftCode', {
        giftcode: this.giftcode,
        server_id: this.server_id
      })
    }
  },
}
</script>
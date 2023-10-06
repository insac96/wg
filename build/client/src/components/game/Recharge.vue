<template lang="pug">
  UDialog(v-model="show" @hide="cancel")
    UBox(title="Xác Nhận" width="100%" v-if="recharge")
      UFlex(align="center" justify="space-between" class="mb-2")
        UText(size="0.85rem") Mặt hàng
        UChip() {{recharge.name}}
      UFlex(align="center" justify="space-between" class="mb-2")
        UText(size="0.85rem") Giá gốc
        UChip() {{$utils.getMoney(recharge.price, false)}} Xu
      UFlex(align="center" justify="space-between" class="mb-2")
        UText(size="0.85rem") VIP {{storeUser.vip.number}} Giảm giá
        UChip() {{storeUser.vip.discount_shop}}%
      UFlex(align="center" justify="space-between")
        UText(size="0.85rem") Giá cuối
        UChip() {{getPrice}} Xu 
      template(#footer)
        UFlex(align="center" justify="flex-end")
          UButton(color="success" @click="buyRecharge" class="mr-1") Mua
          UButton(color="gray" @click="show = false") Không
</template>

<script>
export default {
  data() {
    return {
      show: false,
      recharge: null,
      server_id: null
    }
  },

  mounted() {
    window.document.addEventListener('ask_pay', this.askpay, false)
  },

  beforeDestroy() {
    window.document.removeEventListener('ask_pay', this.askpay, false)
  },

  computed: {
    getPrice () {
      if(!this.recharge) return 0
      const discount_vip = Number(this.storeUser.vip.discount_shop)
      const price = Number(this.recharge.price)
      const newPrice = price - Math.floor(price * discount_vip / 100)
      return this.$utils.getMoney(newPrice, false)
    }
  },

  methods: {
    async askpay (e) {
      if(!e.detail) return this.notify('Có lỗi xảy ra')
      
      const detail = JSON.parse(e.detail)
      const recharge_id = detail.recharge_id
      const server_id = detail.server_id

      if(!recharge_id || !server_id) return this.notify('Có lỗi xảy ra')

      this.getRecharge(recharge_id)
      this.server_id = server_id
    },

    async getRecharge (recharge_id) {
      const recharge = await this.API('getRecharge', {
        recharge_id: recharge_id
      })

      if(!recharge) return
      this.recharge = recharge
      this.show = true
    },

    async buyRecharge () {
      if(!this.recharge) return this.notify('Vui lòng chọn vật phẩm')
      if(!this.server_id) return this.notify('Vui lòng chọn máy chủ')

      const buy = await this.API('buyRecharge', {
        recharge_id: this.recharge.id,
        server_id: this.server_id
      })
      if(!buy) return

      this.sendSocketNotify(`${this.storeUser.account.toUpperCase()} vừa mua gói nạp ${this.recharge.name.toUpperCase()}`)
      this.getUser()
      this.show = false
    },

    cancel () {
      this.show = false
      this.recharge = null
      this.server_id = null
    }
  },
}
</script>
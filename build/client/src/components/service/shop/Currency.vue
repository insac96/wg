<template lang="pug">
  div(class="ShopCurrency" v-if="list")
    UAlert(border color="shop" v-if="list.length == 0") Chưa có tiền tệ nào đang bày bán, vui lòng quay lại sau

    UFlex(wrap="wrap" align="center")
      UBox(
        v-for="item in list"
        :key="item.id"
        :title="item.name"
        class="box-resize"
        @click="setCurrency(item)"
      )
      
        UFlex(justify="center")
          img(
            :src="`${publicPath}images/icon/${item.type}.png`" 
            :alt="item.name" 
            width="70%" 
            height="auto"
          )

        template(#footer)
          UFlex(justify="center")
            UChip(:icon="item.buy_with" :color="item.buy_with") {{ $utils.getMoney(item.price) }}

    UDialog(v-model="dialog" @hide="cancel")
      UBox(title="Xác Nhận" width="100%" v-if="currencySelect")
        UFlex(align="center" justify="space-between" class="mb-2")
          UText(size="0.85rem") Mặt hàng
          UChip() {{currencySelect.name}}
        UFlex(align="center" justify="space-between" class="mb-2")
          UText(size="0.85rem") Số lượng
          UChip() x{{currencySelect.amount}}
        UFlex(align="center" justify="space-between")
          UText(size="0.85rem") Giá mua
          UChip(:icon="currencySelect.buy_with" :color="currencySelect.buy_with") {{$utils.getMoney(currencySelect.price, false)}}
        template(#footer)
          UFlex(align="center" justify="flex-end")
            UButton(color="success" @click="buyCurrency" class="mr-1") Mua
            UButton(color="gray" @click="cancel") Không
</template>

<script>
export default {
  data() {
    return {
      list: null,
      currencySelect: null,
      dialog: false
    }
  },

  mounted () {
    this.getShopCurrency()
  },

  methods: {
    async getShopCurrency () {
      const list = await this.API('getShopCurrency')
      if(!!list) return this.list = list
    },

    async buyCurrency () {
      if(!this.currencySelect) return this.notify('Vui lòng chọn vật phẩm')

      const buy = await this.API('buyCurrency', {
        currency_id: this.currencySelect.id,
      })
      if(!buy) return

      this.getUser()
      this.cancel()
      this.getShopCurrency()
    },

    setCurrency (item) {
      if(!this.isLogin) return this.notify('Vui lòng đăng nhập trước')

      this.dialog = true
      this.currencySelect = item
    },

    cancel () {
      this.dialog = false
      this.currencySelect = null
    }
  },
}
</script>
<template lang="pug">
  div(class="ShopItem" v-if="list")
    UAlert(border color="shop" v-if="list.length == 0") Chưa có vật phẩm nào đang bày bán, vui lòng quay lại sau

    UFlex(wrap="wrap" align="center")
      UBox(
        v-for="item in list"
        :key="item.id"
        :title="item.name"
        class="box-resize"
        @click="setItem(item)"
      )
      
        UFlex(justify="center")
          img(
            :src="imgItem(item.icon)" 
            :alt="item.name" 
            width="70%" 
            height="auto"
          )

        template(#footer)
          UFlex(justify="center")
            UChip(icon="coin" color="shop") {{ $utils.getMoney(item.price) }}

    UDialog(v-model="dialog" @hide="cancel")
      UBox(title="Xác Nhận" width="100%" v-if="itemSelect")
        SelectServer(v-model="serverSelect" class="mb-2")  
        UFlex(align="center" justify="space-between" class="mb-2")
          UText(size="0.85rem") Mặt hàng
          UChip() {{itemSelect.name}}
        UFlex(align="center" justify="space-between" class="mb-2")
          UText(size="0.85rem") Nhập số lượng
          UInput(v-model="itemSelect.amount" width="100px" height="35px" type="number")
        UFlex(align="center" justify="space-between" class="mb-2")
          UText(size="0.85rem") Giá gốc
          UChip() {{$utils.getMoney(itemSelect.price * itemSelect.amount, false)}} Xu
        UFlex(align="center" justify="space-between" class="mb-2")
          UText(size="0.85rem") VIP {{storeUser.vip.number}} Giảm giá
          UChip() {{storeUser.vip.discount_shop}}%
        UFlex(align="center" justify="space-between")
          UText(size="0.85rem") Giá cuối
          UChip() {{getPrice}} Xu 
        template(#footer)
          UFlex(align="center" justify="flex-end")
            UButton(color="success" @click="buyItem" class="mr-1") Mua
            UButton(color="gray" @click="cancel") Không
</template>

<script>
export default {
  data() {
    return {
      list: null,
      itemSelect: null,
      serverSelect: null,
      dialog: false
    }
  },

  computed: {
    getPrice () {
      if(!this.isLogin) return 0
      if(!this.itemSelect) return 0
      const discount_vip = Number(this.storeUser.vip.discount_shop)
      const price = Number(this.itemSelect.price) * this.itemSelect.amount
      const newPrice = price - Math.floor(price * discount_vip / 100)
      return this.$utils.getMoney(newPrice, false)
    },
  },

  mounted () {
    this.getShopItem()
  },

  methods: {
    async getShopItem () {
      const list = await this.API('getShopItem')
      if(!!list) return this.list = list
    },

    async buyItem () {
      if(!this.itemSelect) return this.notify('Vui lòng chọn vật phẩm')
      if(!this.serverSelect) return this.notify('Vui lòng chọn máy chủ')

      const buy = await this.API('buyItem', {
        item_id: this.itemSelect.id,
        item_amount: this.itemSelect.amount,
        server_id: this.serverSelect
      })
      if(!buy) return

      this.$socket.emit('notify-buy', {
        content: '',
        ...this.storeUser
      })

      this.sendSocketNotify(`${this.storeUser.account.toUpperCase()} vừa mua vật phẩm ${this.itemSelect.name.toUpperCase()}`)
      this.getUser()
      this.cancel()
      this.getShopItem()
    },

    imgItem (icon) {
      const iconPath = this.storeConfig ? this.storeConfig.game_icon_path : null
      if(!!icon && !!iconPath){
        return `${iconPath}/${icon}.png`
      }
      else {
        return `${this.publicPath}images/icon/item_game.png`
      }
    },

    setItem (item) {
      if(!this.isLogin) return this.notify('Vui lòng đăng nhập trước')

      this.dialog = true
      this.itemSelect = item
    },

    cancel () {
      this.dialog = false
      this.itemSelect = null
      this.serverSelect = null
    }
  },
}
</script>
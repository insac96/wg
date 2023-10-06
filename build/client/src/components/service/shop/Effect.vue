<template lang="pug">
  div(class="ShopEffect" v-if="list")
    UAlert(border color="shop" v-if="list.length == 0") Chưa có hiệu ứng nào đang bày bán, vui lòng quay lại sau

    UFlex(wrap="wrap" align="center")
      UBox(
        v-for="item in list"
        :key="item.id"
        :title="item.name"
        class="box-resize"
        @click="setEffect(item)"
      )
      
        UFlex(justify="center")
          img(
            :src="`${publicPath}images/effect/${item.type}.gif`" 
            :alt="item.name" 
            width="70%" 
            height="100px"
          )
        template(#footer)
          UFlex(justify="center")
            UChip(icon="coin") {{ $utils.getMoney(item.price) }}

    UDialog(v-model="dialog" @hide="cancel")
      UBox(title="Xác Nhận" width="100%" v-if="effectSelect")
        UFlex(align="center" justify="space-between" class="mb-2")
          UText(size="0.85rem") Hiệu ứng
          UChip() {{effectSelect.name}}
        UFlex(align="center" justify="space-between")
          UText(size="0.85rem") Giá mua
          UChip() {{$utils.getMoney(effectSelect.price, false)}} Xu
        template(#footer)
          UFlex(align="center" justify="flex-end")
            UButton(color="success" @click="buyEffect" class="mr-1") Mua
            UButton(color="gray" @click="cancel") Không
</template>

<script>
export default {
  data() {
    return {
      list: null,
      effectSelect: null,
      dialog: false
    }
  },

  mounted () {
    this.getShopEffect()
  },

  methods: {
    async getShopEffect () {
      const list = await this.API('getShopEffect')
      if(!!list) return this.list = list
    },

    async buyEffect () {
      if(!this.effectSelect) return this.notify('Vui lòng chọn vật phẩm')

      const buy = await this.API('buyEffect', {
        effect_id: this.effectSelect.id,
      })
      if(!buy) return

      this.sendSocketNotify(`${this.storeUser.account.toUpperCase()} vừa mua hiệu ứng ${this.effectSelect.name.toUpperCase()}`)
      this.getUser()
      this.cancel()
      this.getShopEffect()
    },

    setEffect (item) {
      if(!this.isLogin) return this.notify('Vui lòng đăng nhập trước')

      this.dialog = true
      this.effectSelect = item
    },

    cancel () {
      this.dialog = false
      this.effectSelect = null
    }
  },
}
</script>
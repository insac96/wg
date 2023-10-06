<template lang="pug">
  div(class="ShopView")
    transition(name="up")
      UCard(class="mb-2" v-if="isLogin && routerPath != '/game'")
        UFlex(justify="center")
          UserCurrency

    UTab(:list="list" v-model="tab" color="shop" class="mb-2")

    transition(name="up" mode="out-in")
      ShopItem(v-if="tab == 'item'")
      ShopCurrency(v-if="tab == 'currency'")
      ShopEffect(v-if="tab == 'effect'")
</template>

<script>
import ShopItem from '@/components/service/shop/Item'
import ShopCurrency from '@/components/service/shop/Currency'
import ShopEffect from '@/components/service/shop/Effect'

export default {
  components: {
    ShopItem,
    ShopCurrency,
    ShopEffect
  },

  data() {
    return {
      tab: 'item',
      list: [
        { value: 'item', label: 'Vật phẩm' },
        { value: 'effect', label: 'Hiệu ứng' },
        { value: 'currency', label: 'Tiền tệ' },
      ]
    }
  },
}
</script>
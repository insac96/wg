<template lang="pug">
  div(class="ShopCurrencyView")
    UTableAdmin(
      :head="head"
      :reload="reload"
      :select.sync="select"
      get-action="getAllShopCurrency"
      search-action="searchShopCurrency"
      first-sort="update_time"
      action-create
      action-one
      action-two
      @create="createShopCurrency"
      @one="updateShopCurrency"
      @two="deleteShopCurrency"
    )
      template(#create)
        UInput(v-model="addVal.name" label-top="Tên vật phẩm")
        USelect(v-model="addVal.type" :list="typeVal" label-top="Loại tiền")
        UInput(v-model="addVal.amount" label-top="Số lượng" type="number")
        USelect(v-model="addVal.buy_with" :list="typeVal" label-top="Mua bằng")
        UInput(v-model="addVal.price" label-top="Giá mua" type="number")
        UInput(v-model="addVal.icon" label-top="Link Icon nếu có")
        USelect(v-model="addVal.display" :list="displayVal" label-top="Hiển thị")

      template(#one v-if="select")
        UInput(v-model="select.name" label-top="Tên vật phẩm")
        USelect(v-model="select.type" :list="typeVal" label-top="Loại tiền")
        UInput(v-model="select.amount" label-top="Số lượng" type="number")
        USelect(v-model="select.buy_with" :list="typeVal" label-top="Mua bằng")
        UInput(v-model="select.price" label-top="Giá mua" type="number")
        UInput(v-model="select.icon" label-top="Link Icon nếu có")
        USelect(v-model="select.display" :list="displayVal" label-top="Hiển thị")

      template(#two v-if="select")
        UAlert(color="danger" border) Bạn chắc chắn muốn xóa [{{select.name}}] khỏi cửa hàng ?
        
</template>

<script>
export default {
  data() {
    return {
      head: {
        'id': 'ID',
        'name': 'Tên',
        'type': 'Loại tiền tệ',
        'amount': 'Số lượng',
        'buy_with': 'Mua bằng',
        'price': 'Giá mua',
        'display': 'Hiển thị',
        'update_time': 'Cập nhật'
      },

      select: null,

      reload: 0,

      addVal: {
        name: null,
        type: null,
        amount: null,
        price: null,
        buy_with: null,
        icon: null,
        display: 1
      },

      displayVal: [
        { value: 0, label: 'Ẩn' },
        { value: 1, label: 'Hiện' },
      ],

      typeVal: [
        { value: 'coin', label: 'Xu' },
        { value: 'coin_lock', label: 'Xu Khóa' },
        { value: 'diamond', label: 'Kim Cương' },
        { value: 'wheel', label: 'Lượt Quay' },
      ]
    }
  },

  methods: {
    async createShopCurrency () {
      const create = await this.API('createShopCurrency', this.addVal, true)
      if(!!create) return this.onReload()
    },

    async updateShopCurrency () {
      const update = await this.API('updateShopCurrency', this.select, true)
      if(!!update) return this.onReload()
    },

    async deleteShopCurrency () {
      const del = await this.API('deleteShopCurrency', {
        currency_id: this.select.id
      }, true)
      if(!!del) return this.onReload()
    },

    onReload () {
      this.reload = this.reload + 1
      this.addVal = {
        name: null,
        type: null,
        amount: null,
        price: null,
        buy_with: null,
        icon: null,
        display: 1
      }
    }
  },
}
</script>
<template lang="pug">
  div(class="ShopItemView")
    UTableAdmin(
      :head="head"
      :reload="reload"
      :select.sync="select"
      get-action="getAllShopItem"
      search-action="searchShopItem"
      first-sort="update_time"
      action-create
      action-one
      action-two
      @create="createShopItem"
      @one="updateShopItem"
      @two="deleteShopItem"
    )
      template(#create)
        UInput(v-model="addVal.id" label-top="Mã ID" type="number")
        UInput(v-model="addVal.name" label-top="Tên vật phẩm")
        UInput(v-model="addVal.price" label-top="Giá mua" type="number")
        UInput(v-model="addVal.icon" label-top="Mã Icon nếu có")
        USelect(v-model="addVal.display" :list="displayVal" label-top="Hiển thị")

      template(#one v-if="select")
        UInput(v-model="select.id" label-top="Mã ID" type="number" disabled)
        UInput(v-model="select.name" label-top="Tên gói")
        UInput(v-model="select.price" label-top="Giá mua" type="number")
        UInput(v-model="select.icon" label-top="Mã Icon nếu có")
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
        'price': 'Giá mua',
        'display': 'Hiển thị',
        'update_time': 'Cập nhật'
      },

      select: null,

      reload: 0,

      addVal: {
        id: null,
        name: null,
        price: null,
        icon: null,
        display: 1
      },

      displayVal: [
        { value: 0, label: 'Ẩn' },
        { value: 1, label: 'Hiện' },
      ]
    }
  },

  methods: {
    async createShopItem () {
      const create = await this.API('createShopItem', this.addVal, true)
      if(!!create) return this.onReload()
    },

    async updateShopItem () {
      const update = await this.API('updateShopItem', this.select, true)
      if(!!update) return this.onReload()
    },

    async deleteShopItem () {
      const del = await this.API('deleteShopItem', {
        item_id: this.select.id
      }, true)
      if(!!del) return this.onReload()
    },

    onReload () {
      this.reload = this.reload + 1
      this.addVal = {
        id: null,
        name: null,
        price: null,
        icon: null,
        display: 1
      }
    }
  },
}
</script>
<template lang="pug">
  div(class="ActionGiftView")
    UTableAdmin(
      :head="head"
      :reload="reload"
      :select.sync="select"
      get-action="getAllGift"
      first-sort="id"
      action-create
      action-one
      action-two
      action-three
      @create="createGift"
      @one="updateGift"
      @two="deleteGift"
      @three="updateGift"
      @open-one="openEdit"
      @open-three="openEdit"
    )
      template(#create)
        UInput(v-model="addVal.name" label-top="Tên bộ quà tặng")

      template(#one v-if="select")
        UInput(v-model="select.name" label-top="Tên bộ quà tặng")

      template(#two v-if="select")
        UAlert(color="danger" border) Bạn chắc chắn xóa bộ quà tặng này
        
      template(#three v-if="select")
        UGiftAdmin(:gifts.sync="select.list")
</template>

<script>
export default {
  data() {
    return {
      head: {
        'id': 'ID',
        'name': 'Tên',
        'list': 'Vật phẩm',
      },

      select: null,

      reload: 0,

      addVal: {
        name: null,
        list: []
      }
    }
  },

  methods: {
    async createGift () {
      const addVal = JSON.parse(JSON.stringify(this.addVal))
      addVal.list = JSON.stringify(addVal.list)
      const create = await this.API('createGift', addVal, true)
      if(!!create) return this.onReload()
    },

    async updateGift () {
      const select = JSON.parse(JSON.stringify(this.select))
      select.list = JSON.stringify(select.list)
      const update = await this.API('updateGift', select, true)
      if(!!update) return this.onReload()
    },

    async deleteGift () {
      const del = await this.API('deleteGift', {
        gift_id: this.select.id
      }, true)
      if(!!del) return this.onReload()
    },

    openEdit () {
      if(!this.select) return
      this.select.list = JSON.parse(this.select.list)
    },

    onReload () {
      this.reload = this.reload + 1
      this.addVal = {
        name: null,
        list: [],
      }
    }
  },
}
</script>
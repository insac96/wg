<template lang="pug">
  div(class="ActivateWheelView")
    UTableAdmin(
      :head="head"
      :reload="reload"
      :select.sync="select"
      get-action="getAllWheelGift"
      first-sort="update_time"
      action-create
      action-one
      action-two
      @create="createWheelGift"
      @one="updateWheelGift"
      @two="deleteWheelGift"
    )
      template(#create)
        USelect(v-model="addVal.type" :list="typeVal" label-top="Loại phần thưởng")
        UInput(v-model="addVal.name" label-top="Tên phần thưởng")
        UInput(v-model="addVal.item_id" label-top="ID Vật phẩm" type="number" no-icon v-if="addVal.type == 'item'")
        UInput(v-model="addVal.amount" label-top="Số lượng" type="number")
        UInput(v-model="addVal.percent" label-top="Tỷ lệ (0 < ? < 1)" type="number")
        USelect(v-model="addVal.display" :list="displayVal" label-top="Hiển thị")

      template(#one v-if="select")
        USelect(v-model="select.type" :list="typeVal" label-top="Loại phần thưởng")
        UInput(v-model="select.name" label-top="Tên phần thưởng")
        UInput(v-model="select.item_id" label-top="ID Vật phẩm" type="number" no-icon v-if="select.type == 'item'")
        UInput(v-model="select.amount" label-top="Số lượng" type="number")
        UInput(v-model="select.percent" label-top="Tỷ lệ (0 < ? < 1)" type="number")
        USelect(v-model="select.display" :list="displayVal" label-top="Hiển thị")

      template(#two v-if="select")
        UAlert(color="danger" border) Bạn chắc chắn muốn xóa [{{select.name}}] khỏi vòng quay ?
</template>

<script>
export default {
  data() {
    return {
      head: {
        'id': 'ID',
        'name': 'Tên',
        'type': 'Loại phần thưởng',
        'amount': 'Số lượng',
        'percent': 'Tỷ lệ',
        'display': 'Hiển thị',
        'update_time': 'Cập nhật'
      },

      select: null,

      reload: 0,

      addVal: {
        name: null,
        type: null,
        amount: null,
        percent: null,
        item_id: null,
        display: 1
      },

      typeVal: [
        { value: 'coin', label: 'Xu' },
        { value: 'coin_lock', label: 'Xu Khóa' },
        { value: 'diamond', label: 'Kim cương' },
        { value: 'wheel', label: 'Lượt quay' },
        { value: 'unlucky', label: 'Mất lượt' },
        { value: 'item', label: 'Vật phẩm' },
      ],

      displayVal: [
        { value: 0, label: 'Ẩn' },
        { value: 1, label: 'Hiện' },
      ]
    }
  },

  methods: {
    async createWheelGift () {
      const create = await this.API('createWheelGift', this.addVal, true)
      if(!!create) return this.onReload()
    },

    async updateWheelGift () {
      const update = await this.API('updateWheelGift', this.select, true)
      if(!!update) return this.onReload()
    },

    async deleteWheelGift () {
      const del = await this.API('deleteWheelGift', {
        wheel_gift_id: this.select.id
      }, true)
      if(!!del) return this.onReload()
    },

    onReload () {
      this.reload = this.reload + 1
      this.addVal = {
        name: null,
        type: null,
        amount: null,
        percent: null,
        item_id: null,
        display: 1
      }
    }
  },
}
</script>
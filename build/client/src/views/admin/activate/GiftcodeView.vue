<template lang="pug">
  div(class="ActivateWheelView")
    UTableAdmin(
      :head="head"
      :reload="reload"
      :select.sync="select"
      get-action="getAllGiftCode"
      first-sort="update_time"
      action-create
      action-one
      action-two
      action-three
      @create="createGiftCode"
      @one="updateGiftCode"
      @two="deleteGiftCode"
      @three="updateGiftCode"
      @open-one="openEdit"
      @open-three="openEdit"
    )
      template(#create)
        UInput(v-model="addVal.name" label-top="Mã GiftCode")
        SelectServerAdmin(v-model="addVal.server_id")
        UInput(v-model="addVal.max" type="number" label-top="Giới hạn người dùng")
        UFlex(align="center" justify="space-between" full class="mb-2")
          UInput(v-model="addVal.expires_time.date" label-top="Ngày hết hạn" type="date" width="49%" class="mb-0")
          UInput(v-model="addVal.expires_time.time" label-top="Thời gian hết hạn" type="time" width="49%")
        USelect(v-model="addVal.display" :list="displayVal" label-top="Hiển thị")

      template(#one v-if="select")
        UInput(v-model="select.name" label-top="Mã GiftCode")
        SelectServerAdmin(v-model="select.server_id")
        UInput(v-model="select.max" type="number" label-top="Giới hạn người dùng")
        UFlex(align="center" justify="space-between" full class="mb-2")
          UInput(v-model="select.expires_time.date" label-top="Ngày hết hạn" type="date" width="49%" class="mb-0")
          UInput(v-model="select.expires_time.time" label-top="Thời gian hết hạn" type="time" width="49%")
        USelect(v-model="select.display" :list="displayVal" label-top="Hiển thị")

      template(#two v-if="select")
        UAlert(color="danger" border) Bạn chắc chắn muốn xóa mã [{{select.name}}] khỏi danh sách ?

      template(#three v-if="select")
        UGiftAdmin(:gifts.sync="select.gifts")
</template>

<script>
export default {
  data() {
    return {
      head: {
        'id': 'ID',
        'name': 'Mã GiftCode',
        'server_id': 'Máy chủ',
        'max': 'Giới hạn',
        'count': 'Số người dùng',
        'expires_time': 'Thời hạn',
        'display': 'Hiển thị',
        'update_time': 'Cập nhật'
      },

      select: null,

      reload: 0,

      addVal: {
        name: null,
        server_id: 'all',
        max: 0,
        gifts: [],
        expires_time: {
          date: null,
          time: null
        },
        display: 1
      },

      displayVal: [
        { value: 0, label: 'Ẩn' },
        { value: 1, label: 'Hiện' },
      ]
    }
  },

  methods: {
    async createGiftCode () {
      const addVal = JSON.parse(JSON.stringify(this.addVal))
      addVal.gifts = JSON.stringify(addVal.gifts)
      const create = await this.API('createGiftCode', addVal, true)
      if(!!create) return this.onReload()
    },

    async updateGiftCode () {
      const select = JSON.parse(JSON.stringify(this.select))
      select.gifts = JSON.stringify(select.gifts)
      const update = await this.API('updateGiftCode', select, true)
      if(!!update) return this.onReload()
    },

    async deleteGiftCode () {
      const del = await this.API('deleteGiftCode', {
        giftcode_id: this.select.id
      }, true)
      if(!!del) return this.onReload()
    },

    openEdit () {
      if(!this.select) return
      const expires_time = this.select.expires_time
      const time = this.$utils.getTime(expires_time)

      this.select.expires_time = {
        date: expires_time != 0 ? time.dateInput : null,
        time: expires_time != 0 ? time.timeInput : null
      }

      this.select.gifts = JSON.parse(this.select.gifts)
    },

    onReload () {
      this.reload = this.reload + 1
      this.addVal = {
        name: null,
        server_id: 'all',
        max: 0,
        gifts: [],
        expires_time: {
          date: null,
          time: null
        },
        display: 1
      }
    }
  },
}
</script>
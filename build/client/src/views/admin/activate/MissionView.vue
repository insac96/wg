<template lang="pug">
  div(class="ActivateMissionView")
    UTableAdmin(
      :head="head"
      :reload="reload"
      :select.sync="select"
      get-action="getAllMission"
      first-sort="update_time"
      action-create
      action-one
      action-two
      action-three
      @create="createMission"
      @one="updateMission"
      @two="deleteMission"
      @three="updateMission"
      @open-one="openEdit"
      @open-three="openEdit"
    )
      template(#create)
        USelect(v-model="addVal.type" :list="typeVal" label-top="Loại nhiệm vụ")
        UInput(v-model="addVal.name" label-top="Tên nhiệm vụ")
        UInput(v-model="addVal.info" label-top="Mô tả")
        UInput(v-model="addVal.need" label-top="Điều kiện")
        UFlex(align="center" justify="space-between" full class="mb-2")
          UInput(v-model="addVal.expires_time.date" label-top="Ngày hết hạn" type="date" width="49%" class="mb-0")
          UInput(v-model="addVal.expires_time.time" label-top="Thời gian hết hạn" type="time" width="49%")
        USelect(v-model="addVal.display" :list="displayVal" label-top="Hiển thị")

      template(#one v-if="select")
        UInput(v-model="select.name" label-top="Tên nhiệm vụ")
        UInput(v-model="select.info" label-top="Mô tả")
        UInput(v-model="select.need" label-top="Điều kiện")
        UFlex(align="center" justify="space-between" full class="mb-2")
          UInput(v-model="select.expires_time.date" label-top="Ngày hết hạn" type="date" width="49%" class="mb-0")
          UInput(v-model="select.expires_time.time" label-top="Thời gian hết hạn" type="time" width="49%")
        USelect(v-model="select.display" :list="displayVal" label-top="Hiển thị")

      template(#two v-if="select")
        UAlert(color="danger" border) Bạn chắc chắn xóa nhiệm vụ này
        
      template(#three v-if="select")
        UGiftAdmin(:gifts.sync="select.gifts")
</template>

<script>
export default {
  data() {
    return {
      head: {
        'id': 'ID',
        'name': 'Tên',
        'type': 'Loại nhiệm vụ',
        'need': 'Điều kiện',
        'display': 'Hiển thị',
        'expires_time': 'Thời hạn',
        'update_time': 'Cập nhật'
      },

      select: null,

      reload: 0,

      addVal: {
        name: null,
        info: null,
        type: null,
        need: null,
        gifts: [],
        expires_time: {
          date: null,
          time: null
        },
        display: 1
      },

      typeVal: [
        { value: 'login_day', label: 'Số Ngày Đăng Nhập' },
        { value: 'referral_count', label: 'Số Người Giới Thiệu' },
        { value: 'vip', label: 'Đặt cấp VIP' },
        { value: 'spend_day', label: 'Tiêu Xu Ngày' },
        { value: 'spend_month', label: 'Tiêu Xu Tháng' },
        { value: 'spend_all', label: 'Tiêu Xu Tổng' },
        { value: 'pay_day', label: 'Tích Nạp Ngày' },
        { value: 'pay_month', label: 'Tích Nạp Tháng' },
        { value: 'pay_all', label: 'Tích Nạp Tổng' },
        { value: 'join_group', label: 'Tham gia Group FB' },
        { value: 'join_zalo', label: 'Tham gia Group Zalo' },
        { value: 'join_telegram', label: 'Tham gia Group Telegram' },
        // { value: 'share_web', label: 'Chia sẻ Website' },
      ],

      displayVal: [
        { value: 0, label: 'Ẩn' },
        { value: 1, label: 'Hiện' },
      ]
    }
  },

  methods: {
    async createMission () {
      const addVal = JSON.parse(JSON.stringify(this.addVal))
      addVal.gifts = JSON.stringify(addVal.gifts)
      const create = await this.API('createMission', addVal, true)
      if(!!create) return this.onReload()
    },

    async updateMission () {
      const select = JSON.parse(JSON.stringify(this.select))
      select.gifts = JSON.stringify(select.gifts)
      const update = await this.API('updateMission', select, true)
      if(!!update) return this.onReload()
    },

    async deleteMission () {
      const del = await this.API('deleteMission', {
        mission_id: this.select.id
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
        info: null,
        type: null,
        need: null,
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
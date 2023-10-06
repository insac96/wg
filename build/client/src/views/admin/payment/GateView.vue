<template lang="pug">
  div(class="PaymentGateView")
    UTableAdmin(
      :head="head"
      :reload="reload"
      :select.sync="select"
      get-action="getAllGate"
      first-sort="update_time"
      action-one
      @one="updateGate"
      @open-one="openEdit"
    )
      template(#one v-if="select")
        UInput(v-model="select.name" label-top="Tên kênh")
        UInput(v-model="select.person" label-top="Người hưởng thụ" v-if="select.type != 2")
        UInput(v-model="select.stk" label-top="Số tài khoản" v-if="select.type != 2")
        UInput(v-model="select.bonus_default" label-top="Khuyến mại mặc định %" type="number")
        UFlex(align="center" justify="space-between" full class="mb-2")
          UInput(v-model="select.bonus" label-top="Khuyến mại có thời hạn %" type="number" width="49%" class="mb-0")
          UInput(v-model="select.expires_bonus.date" label-top="Ngày hết hạn" type="date" width="49%" class="mb-0")
          UInput(v-model="select.expires_bonus.time" label-top="Thời gian hết hạn" type="time" width="49%")
        UInput(v-model="select.icon" label-top="Link ảnh nếu có")
        UInput(v-model="select.qr_link" label-top="Link QR" v-if="select.type != 2")
        USelect(v-model="select.display" :list="displayVal" label-top="Hiển thị")
</template>

<script>
export default {
  data() {
    return {
      head: {
        'id': 'ID',
        'name': 'Tên kênh',
        'bonus_default': 'Khuyến mại mặc định',
        'bonus': 'Khuyến mại có thời hạn',
        'expires_bonus': 'Hạn khuyến mại',
        'display': 'Hiển thị',
        'update_time': 'Cập nhật'
      },

      select: null,

      reload: 0,

      displayVal: [
        { value: 0, label: 'Ẩn' },
        { value: 1, label: 'Hiện' },
      ],
    }
  },

  methods: {
    async updateGate () {
      const update = await this.API('updateGate', this.select, true)
      if(!!update) return this.onReload()
    },

    openEdit () {
      if(!this.select) return
      const expires_bonus = this.select.expires_bonus
      const time = this.$utils.getTime(expires_bonus)

      this.select.expires_bonus = {
        date: expires_bonus != 0 ? time.dateInput : null,
        time: expires_bonus != 0 ? time.timeInput : null
      }
    },

    onReload () {
      this.reload = this.reload + 1
    }
  },
}
</script>
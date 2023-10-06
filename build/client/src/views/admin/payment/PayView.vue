<template lang="pug">
  div(class="PaymentPayView")
    UTableAdmin(
      :head="head"
      :reload="reload"
      :select.sync="select"
      get-action="getAllPay"
      search-action="searchPay"
      first-sort="create_time"
      action-one
      action-two
      @one="verifyPay(1)"
      @two="verifyPay(2)"
      text-one="Duyệt"
      text-two="Từ Chối"
    )
      template(#one v-if="select")
        UAlert(color="info" border class="mb-2") Bạn chắc chắn đồng ý duyệt thành công giao dịch này
        UInput(v-model="select.money" label-top="Số tiền thực nhận")

      template(#two v-if="select")
        UAlert(color="danger" border class="mb-2") Bạn chắc chắn từ chối giao dịch này
        UInput(v-model="reason" label-top="Lý do gửi đến người nạp")
</template>

<script>
export default {
  data() {
    return {
      head: {
        'id': 'ID',
        'account': 'Tài khoản',
        'gate_name': 'Kênh nạp',
        'money': 'Số tiền',
        'code': 'Mã giao dịch',
        'status': 'Trạng thái',
        'verifier': 'Người duyệt',
        'verify_time': 'Thời gian duyệt',
        'create_time': 'Tạo'
      },
      select: null,
      
      reload: 0,

      reason: null
    }
  },

  methods: {
    async verifyPay (status) {
      const verify = await this.API('verifyPay', {
        status: status,
        code: this.select.code,
        real_money: this.select.money,
        reason: this.reason
      }, true)

      if(verify) return this.onReload()
    },

    onReload () {
      this.reload = this.reload + 1
      this.reason = null
    }
  },
}
</script>
<template lang="pug">
  div(class="PaymentWithdrawView")
    UTableAdmin(
      :head="head"
      :reload="reload"
      :select.sync="select"
      get-action="getAllWithdraw"
      search-action="searchWithdraw"
      first-sort="create_time"
      action-one
      action-two
      @one="verifyWithdraw(1)"
      @two="verifyWithdraw(2)"
      text-one="Duyệt"
      text-two="Từ Chối"
    )
      template(#one v-if="select")
        UAlert(color="info" border class="mb-2") Bạn chắc chắn đồng ý duyệt thành công giao dịch này
        UInput(v-model="select.bank_name" label-top="Tên ngân hàng" disabled)
        UInput(v-model="select.bank_person" label-top="Tên người hưởng thụ" disabled)
        UInput(v-model="select.bank_stk" label-top="Số tài khoản" disabled)
        UInput(v-model="select.money" label-top="Số tiền" disabled)

      template(#two v-if="select")
        UAlert(color="danger" border) Bạn chắc chắn từ chối giao dịch này ?
</template>

<script>
export default {
  data() {
    return {
      head: {
        'id': 'id',
        'account': 'Tài khoản',
        'code': 'code',
        'diamond': 'Kim cương rút',
        'money': 'Tiền nhận',
        'status': 'Trạng thái',
        'verifier': 'Người duyệt',
        'verify_time': 'Thời gian duyệt',
        'create_time': 'Tạo'
      },

      select: null,

      reload: 0,
    }
  },

  methods: {
    async verifyWithdraw (status) {
      const verify = await this.API('verifyWithdraw', {
        status: status,
        code: this.select.code
      }, true)

      if(verify) return this.onReload()
    },

    onReload () {
      this.reload = this.reload + 1
    }
  },
}
</script>
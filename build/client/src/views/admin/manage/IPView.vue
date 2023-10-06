<template lang="pug">
  div(class="PaymentPayView")
    UTableAdmin(
      :head="head"
      :reload="reload"
      :select.sync="select"
      get-action="getAllIPClient"
      search-action="searchIPClient"
      first-sort="update_time"
      action-one
      action-two
      @one="setBlockIP(0)"
      @two="setBlockIP(1)"
      text-one="Bỏ chặn"
      text-two="Chặn"
      @select-data="openIPInfo"
    )
      template(#one v-if="select")
        UAlert(color="info" border class="mb-2") Bạn chắc chắn bỏ chặn IP này
        UInput(v-model="select.ip" label-top="Địa chỉ IP" read-only)
        UInput(v-model="reason_unblock" label-top="Lý do bỏ chặn")

      template(#two v-if="select")
        UAlert(color="danger" border class="mb-2") Bạn chắc chắn chặn IP này
        UInput(v-model="select.ip" label-top="Địa chỉ IP" read-only)
        UInput(v-model="reason_block" label-top="Lý do chặn")

    div(v-if="selectIPInfo" class="mt-2")
      UTableAdmin(
        :head="headIPInfo"
        get-action="getAllAccountByIPClient"
        first-sort="create_time"
        :plus-get="plusGet"
      )
        template(#header)
          UChip(full color="dark") {{selectIPInfo.ip}}
</template>

<script>
export default {
  data() {
    return {
      head: {
        'id': 'ID',
        'ip': 'Địa chỉ IP',
        'account_total': 'Tài khoản',
        'connect': 'Truy vấn',
        'block': 'Trạng thái chặn',
        'update_time': 'Truy cập gần nhất'
      },

      headIPInfo: {
        'account': 'Tài khoản',
        'create_time': 'Làm mới lần cuối',
        'update_time': 'Truy cập gần nhất'
      },

      select: null,
      
      reload: 0,

      reason_block: null,

      reason_unblock: null,

      selectIPInfo: null,
    }
  },

  computed: {
    plusGet () {
      if(!this.selectIPInfo) return {}
      return {
        ip: this.selectIPInfo.ip
      }
    }
  },

  methods: {
    async setBlockIP (status) {
      const set = await this.API('setBlockIP', {
        status: status,
        reason_block: this.reason_block,
        reason_unblock: this.reason_unblock,
        ip: this.select.ip
      }, true)

      if(set) return this.onReload()
    },

    openIPInfo (data) {
      this.selectIPInfo = null
      setTimeout(() => this.selectIPInfo = data, 1)
    },

    onReload () {
      this.reload = this.reload + 1
      this.reason_block = null
      this.reason_unblock = null
    }
  },
}
</script>
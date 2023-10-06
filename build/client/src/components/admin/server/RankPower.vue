<template lang="pug">
  div(class="ManageServerRankPower")
    UTableAdmin(
      :head="head"
      get-action="getServerRankPower"
      :plus-get="plus"
      :reload="reload"
      :data-sort.sync="dataSort"
      first-sort="power"
      action-create
      text-create="Gửi quà"
      @create="sendRankGiftPower"
    )
      template(#create)
        UAlert(color="info" border) Chức năng này sẽ dựa trên BXH theo thống kê bạn đã chọn đế gửi phần thưởng đến người chơi
</template>

<script>
export default {
  props: {
    server: { type: Object }
  },
  
  data() {
    return {
      head: {
        'account': 'Tài khoản',
        'role_name': 'Tên nhân vật',
        'power': 'Lực chiến',
      },

      reload: 0,

      plus: {
        server_id: this.server.server_id
      },

      dataSort: null,
    }
  },

  methods: {
    async sendRankGiftPower () {
      if(!this.dataSort) return
      const send = await this.API('sendRankGiftPower', this.dataSort, true)
      if(!!send) return this.onReload()
    },

    onReload () {
      this.reload = this.reload + 1
    }
  },
}
</script>
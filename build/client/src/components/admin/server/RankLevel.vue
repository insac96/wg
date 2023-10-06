<template lang="pug">
  div(class="ManageServerRankLevel")
    UTableAdmin(
      :head="head"
      get-action="getServerRankLevel"
      :plus-get="plus"
      :reload="reload"
      :data-sort.sync="dataSort"
      first-sort="level"
      action-create
      text-create="Gửi quà"
      @create="sendRankGiftLevel"
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
        'level': 'Cấp độ',
      },

      reload: 0,

      plus: {
        server_id: this.server.server_id
      },

      dataSort: null,
    }
  },

  methods: {
    async sendRankGiftLevel () {
      if(!this.dataSort) return
      const send = await this.API('sendRankGiftLevel', this.dataSort, true)
      if(!!send) return this.onReload()
    },

    onReload () {
      this.reload = this.reload + 1
    }
  },
}
</script>
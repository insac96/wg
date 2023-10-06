<template lang="pug">
  div(class="ManageServerRankSpend")
    UTableAdmin(
      :head="head"
      get-action="getServerRankSpend"
      :plus-get="plus"
      :reload="reload"
      :data-sort.sync="dataSort"
      first-sort="spend_all"
      action-create
      text-create="Gửi quà"
      @create="sendRankGiftSpend"
    )
      template(#header)
        UFlex(align="center")
          UInput(v-model="plus.start" type="date" icon="bxs-calendar" size="40px" icon-color="dark" placeholder="Bắt đầu" class="mb-0" width="180px")
          UInput(v-model="plus.end" type="date" placeholder="Kết thúc" size="40px" class="mb-0" width="150px")

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
        'spend_all': 'Tổng tiêu phí',
        'spend_recharge': 'Tiêu phí trong game',
        'spend_item': 'Tiêu phí trên web',
      },

      reload: 0,

      plus: {
        start: this.$utils.getTime(new Date() / 1000).dateInput,
        end: this.$utils.getTime(new Date() / 1000).dateInput,
        server_id: this.server.server_id
      },

      dataSort: null,
    }
  },

  watch: {
    'plus.start' () {
      this.onReload()
    },
    'plus.end' () {
      this.onReload()
    }
  },

  methods: {
    async sendRankGiftSpend () {
      if(!this.dataSort) return
      const send = await this.API('sendRankGiftSpend', this.dataSort, true)
      if(!!send) return this.onReload()
    },

    onReload () {
      this.reload = this.reload + 1
    }
  },
}
</script>
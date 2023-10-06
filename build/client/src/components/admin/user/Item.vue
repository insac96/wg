<template lang="pug">
  UFlex(justify="center")
    UCard(class="box-resize-50" title="Gửi vật phẩm" v-if="listServer")
      UAlert(border v-if="listServer.length == 0") Người chơi chưa có nhân vật ở bất cứ máy chủ nào
      div(v-else)
        USelect(v-model="server_id" :list="listServer" label-top="Chọn máy chủ" value="server_id" label="server_name")
        UInput(v-model="reason" label-top="Lý do")
        UGiftAdmin(:gifts.sync="gifts" send title="Vật phẩm")
      template(#footer v-if="listServer.length != 0")
        UFlex(align="center" justify="flex-end")
          UButton(color="success" class="mr-1" @click="sendItemToUser") Xác nhận
</template>

<script>
export default {
  props: {
    user: { type: Object }
  },

  data() {
    return {
      listServer: null,
      server_id: null,
      reason: null,
      gifts: []
    }
  },
  
  watch: {
    user () {
      this.getAllServerByAccount()
    }
  },

  created() {
    this.getAllServerByAccount()
  },

  methods: {
    async getAllServerByAccount () {
      const get = await this.API('getAllServerByAccount', {
        account: this.user.account
      }, true)

      if(!!get) return this.listServer = get
    },

    async sendItemToUser () {
      if(!this.server_id) return this.notify('Vui lòng chọn máy chủ trước')
      if(!this.reason) return this.notify('Vui lòng nhập lý do')
      if(this.gifts.length == 0) return this.notify('Vui lòng thêm vật phẩm trước')

      const gifts = JSON.stringify(this.gifts)
      const send = await this.API('sendItemToUser', {
        account: this.user.account,
        server_id: this.server_id,
        gifts: gifts,
        reason: this.reason
      }, true)

      if(!!send) return this.reason = null
    }
  },
}
</script>
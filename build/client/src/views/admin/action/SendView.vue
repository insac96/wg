<template lang="pug">
  UFlex(justify="center" align="center" type="column")
    div(class="box-resize-50")
      UTab(v-model="tab" :list="tabList")

    UCard(class="box-resize-50")
      SelectServer(v-model="server_id" no-role class="mb-2")

      UInput(v-model="account" placeholder="Tên tài khoản" icon="user" icon-color="user" v-if="tab == 'account'")

      UInput(v-model="role" placeholder="Tên nhân vật" icon="user" icon-color="user" v-if="tab == 'role'")

      UInput(v-model="reason" placeholder="Lý do" icon="alert" icon-color="danger")

      UGiftAdmin(:gifts.sync="gifts" send title="Vật phẩm")

      template(#footer)
        UFlex(align="center" justify="flex-end")
          UButton(color="success" @click="sendItemToUser") Xác nhận gửi
</template>

<script>
export default {
  props: {
    user: { type: Object }
  },

  data() {
    return {
      tabList: [
        { value: 'account', label: 'Gửi theo tài khoản' },
        { value: 'role', label: 'Gửi theo tên nhân vật' },
      ],

      tab: 'account',
      server_id: null,
      account: null,
      role: null,
      reason: 'ADMIN',
      gifts: []
    }
  },

  computed: {
    place () {
      return this.tab == 'account' ? 'Tên tài khoản' : 'Tên nhân vật'
    }
  },

  methods: {
    async sendItemToUser () {
      if(!this.server_id) return this.notify('Vui lòng chọn máy chủ')
      if(this.tab == 'account' && !this.account) return this.notify('Vui lòng nhập tên tài khoản')
      if(this.tab == 'role' && !this.role) return this.notify('Vui lòng nhập tên nhân vật')
      if(!this.reason) return this.notify('Vui lòng nhập lý do')

      const send = await this.API('sendItemToUser', {
        tab: this.tab,
        account: this.account,
        role: this.role,
        server_id: this.server_id,
        gifts: JSON.stringify(this.gifts),
        reason: this.reason
      }, true)

      if(!!send) return this.reset()
    },

    reset () {
      
    }
  },
}
</script>
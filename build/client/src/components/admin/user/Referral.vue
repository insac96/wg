<template lang="pug">
  div(v-if="user")
    UTableAdmin(
      :head="head"
      get-action="getLogUserReferral"
      :plus-get="plusGet"
      first-sort="create_time"
    )
</template>

<script>
export default {
  props: {
    user: { type: Object }
  },

  data() {
    return {
      head: {
        'id': 'ID',
        'invitee': 'Người được mời',
        'pay_all': 'Tổng nạp',
        'create_time': 'Thời gian mời'
      },
      selectUser: JSON.parse(JSON.stringify(this.user))
    }
  },

  computed: {
    plusGet () {
      return {
        account: this.selectUser ? this.selectUser.account : null
      }
    }
  },
  
  watch: {
    user (val) {
      this.selectUser = JSON.parse(JSON.stringify(val))
    }
  }
}
</script>
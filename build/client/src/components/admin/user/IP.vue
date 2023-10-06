<template lang="pug">
  div(v-if="user")
    UTableAdmin(
      :head="head"
      get-action="getLogUserIP"
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
        'ip': 'Địa chỉ IP',
        'block': 'Trạng thái khóa',
        'create_time': 'Làm mới lần cuối',
        'update_time': 'Truy cập gần nhất'
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
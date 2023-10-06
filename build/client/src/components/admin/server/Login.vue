<template lang="pug">
  div(class="ManageServerLogin")
    UTableAdmin(
      :head="head"
      get-action="getLogServerLogin"
      :plus-get="date"
      :reload="reload"
      :data-list.sync="dataList"
      first-sort="table_time"
      :sum="['sign_in']"
    )
      template(#header)
        UFlex(align="center")
          UInput(v-model="date.start" type="date" icon="bxs-calendar" size="40px" icon-color="dark" placeholder="Bắt đầu" class="mb-0" width="180px")
          UInput(v-model="date.end" type="date" placeholder="Kết thúc" size="40px" class="mb-0" width="150px")
</template>

<script>
export default {
  props: {
    server: { type: Object }
  },
  
  data() {
    return {
      head: {
        'table_time': 'Ngày',
        'sign_in': 'Người đăng nhập',
      },

      reload: 0,

      date: {
        start: null,
        end: this.$utils.getTime(new Date() / 1000).dateInput,
        server_id: this.server.server_id
      },

      dataList: null,
    }
  },

  watch: {
    'date.start' () {
      this.onReload()
    },
    'date.end' () {
      this.onReload()
    }
  },

  methods: {
    onReload () {
      this.reload = this.reload + 1
    }
  },
}
</script>
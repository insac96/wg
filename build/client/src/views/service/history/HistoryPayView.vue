<template lang="pug">
  UTable(class="HistoryPayView" v-if="list" :no-data="list.length == 0")
    template(#head)
      tr
        th Trạng thái
        th Kênh
        th Số tiền
        th Mã
        th Thời gian
    template(#default)
      tr(v-for="pay in list" :key="pay.id")
        td
          UChip(full :color="`status-${pay.status}`") {{ statusView[pay.status] }}
        td
          UChip() {{ pay.gate_name }}
        td
          UChip() {{ $utils.getMoney(pay.money, false) }}
        td
          UChip() {{ pay.code }}
        td
          UChip() {{ $utils.getTime(pay.create_time).full }}
          
    template(#footer)
      UFlex(justify="flex-end")
        UPagination(:total="total" :page.sync="page" color="pay")
</template>

<script>
export default {
  data() {
    return {
      list: null,
      page: 1,
      total: null,

      statusView : {
        '0': 'Chưa duyệt',
        '1': 'Thành công',
        '2': 'Từ chối'
      },
    }
  },

  created() {
    this.getAllPay()
  },

  watch: {
    page () {
      this.getAllPay()
    }
  },

  methods: {
    async getAllPay () {
      const get = await this.API('getAllPay', {
        limit: 5,
        page: this.page,
        sort: {
          by: 'create_time',
          type: 'DESC'
        }
      })

      if(!get) return

      this.list = get.list
      this.total = get.total_page
    },
  },
}
</script>
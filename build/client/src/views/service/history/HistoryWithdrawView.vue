<template lang="pug">
  UTable(class="HistoryWithdrawView" v-if="list" :no-data="list.length == 0")
    template(#head)
      tr
        th Trạng thái
        th Kim cương
        th Số tiền
        th Mã
        th Thời gian
    template(#default)
      tr(v-for="withdraw in list" :key="withdraw.id")
        td
          UChip(full :color="`status-${withdraw.status}`") {{ statusView[withdraw.status] }}
        td
          UChip() {{ $utils.getMoney(withdraw.diamond, false) }}
        td
          UChip() {{ $utils.getMoney(withdraw.money, false) }}
        td
          UChip() {{ withdraw.code }}
        td
          UChip() {{ $utils.getTime(withdraw.create_time).full }}

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
    this.getAllWithdraw()
  },

  watch: {
    page () {
      this.getAllWithdraw()
    }
  },

  methods: {
    async getAllWithdraw () {
      const get = await this.API('getAllWithdraw', {
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
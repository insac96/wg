<template lang="pug">
  div(class="NotifyView")
    UTab(:list="tabs" v-model="tab" color="time" class="mb-2")

    transition(name="up")
      UAlert(border color="time" v-if="list && list.length == 0") Bạn chưa có thông báo nào
      UCard(v-if="list && list.length != 0")
        div(class="Notify" v-for="notify in list" :key="notify.id")
          UText(full color="time" size="0.75rem" weight="700" class="mb-1") {{ $utils.getTime(notify.create_time).from }}
          UText(weight="500" size="0.9rem") {{ notify.content }}

        template(#footer v-if="total > 1")
          UFlex(justify="flex-end")
            UPagination(:total="total" :page.sync="page" color="time")
</template>

<script>
export default {
  data() {
    return {
      list: null,
      page: 1,
      total: null,

      tab: 'all',
      tabs: [
        { value: 'all', label: 'Tất cả' },
        { value: 'pay', label: 'Nạp tiền' },
        { value: 'referral', label: 'Giới thiệu' },
      ]
    }
  },

  created () {
    this.getAllNotify()
  },

  watch: {
    page () {
      this.getAllNotify()
    },
    tab () {
      this.list = null
      setTimeout(() => this.getAllNotify(), 1)
    }
  },

  methods: {
    async getAllNotify () {
      const get = await this.API('getAllNotify', {
        limit: 5,
        page: this.page,
        sort: {
          by: 'create_time',
          type: 'DESC'
        },
        tab: this.tab
      })

      if(!get) return

      this.list = get.list
      this.total = get.total_page
    }
  },
}
</script>

<style lang="sass">
.NotifyView
  .Notify
    margin-bottom: calc(var(--space) * 2)
    border-bottom: 1px solid rgba(var(--ui-dark), 0.2)
    padding-bottom: var(--space)
    &:last-child
      margin-bottom: 0px !important
      border-bottom: none
      padding-bottom: none
</style>

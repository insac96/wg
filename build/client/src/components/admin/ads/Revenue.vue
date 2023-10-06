<template lang="pug">
  UTableAdmin(
    :head="head"
    get-action="getAdsRevenue"
    :plus-get="plus"
    :reload="reload"
    first-sort="date"
    :sum="['user_pay', 'pay_all', 'pay_banking', 'pay_card', 'pay_momo']"
  )
    template(#header)
      UFlex(align="center")
        UInput(v-model="plus.start" type="date" icon="bxs-calendar" size="40px" icon-color="dark" placeholder="Bắt đầu" class="mb-0" width="180px")
        UInput(v-model="plus.end" type="date" placeholder="Kết thúc" size="40px" class="mb-0" width="150px")
</template>

<script>
export default {
  props: {
    ads: { type: Object }
  },

  data() {
    return {
      head: {
        'date': 'Ngày',
        'user_pay': 'Người nạp',
        'pay_all': 'Tổng doanh thu',
        'pay_banking': 'Ngân hàng',
        'pay_card': 'Thẻ cào',
        'pay_momo': 'Momo',
      },

      reload: 0,

      plus: {
        ads_id: this.ads ? this.ads.id : null,
        start: null,
        end: this.$utils.getTime(new Date() / 1000).dateInput
      }
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
    onReload () {
      this.reload = this.reload + 1
    }
  },
}
</script>
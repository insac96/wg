<template lang="pug">
  UTableAdmin(
    :head="head"
    get-action="getAdsSignUp"
    :plus-get="plus"
    :reload="reload"
    first-sort="table_date"
    :sum="['sign_up_all', 'sign_up_no_referral', 'sign_up_referral']"
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
        'table_date': 'Ngày',
        'sign_up_all': 'Tổng đăng ký',
        'sign_up_no_referral': 'Đăng Ký thường',
        'sign_up_referral': 'Đăng ký kèm mã Mời',
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
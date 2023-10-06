<template lang="pug">
  UFlex(class="mb-2" align="center" justify="center" wrap="wrap" v-if="revenue")
    UBox(title="Hôm nay" color="info" class="box-resize-20-50")
      UFlex(justify="center")
        UText(size="1.3rem" weight="700") {{ $utils.getMoney(revenue.day, false) }}
    UBox(title="Hôm qua" color="success" class="box-resize-20-50")
      UFlex(justify="center")
        UText(size="1.3rem" weight="700") {{ $utils.getMoney(revenue.prev_day, false) }}
    UBox(title="Tháng này" color="warn" class="box-resize-20-50")
      UFlex(justify="center")
        UText(size="1.3rem" weight="700") {{ $utils.getMoney(revenue.month, false) }}
    UBox(title="Tháng trước" color="danger" class="box-resize-20-50")
      UFlex(justify="center")
        UText(size="1.3rem" weight="700") {{ $utils.getMoney(revenue.prev_month, false) }}
    UBox(title="Tổng" color="box" class="box-resize-20-50")
      UFlex(justify="center") 
        UText(size="1.3rem" weight="700") {{ $utils.getMoney(revenue.all, false) }}
</template>

<script>
export default {
  data() {
    return {
      revenue: null,
    }
  },

  created() {
    this.getStatisticalRevenue()
  },

  methods: {
    async getStatisticalRevenue () {
      const revenue = await this.API('getStatisticalRevenue', null, true)
      if(!!revenue) return this.revenue = revenue
    }
  },
}
</script>
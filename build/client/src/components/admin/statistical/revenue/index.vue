<template lang="pug">
  div(class="ManageStatisticalRevenue")
    transition(name="up")
      RevenueFast
    RevenueTable
</template>

<script>
import RevenueFast from '@/components/admin/statistical/revenue/Fast.vue'
import RevenueTable from '@/components/admin/statistical/revenue/Table.vue'

export default {
  components: {
    RevenueFast,
    RevenueTable
  }
}
</script>
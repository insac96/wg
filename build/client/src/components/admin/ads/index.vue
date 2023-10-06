<template lang="pug">
  div(class="ManageAdsInfo" v-if="ads")
    UFlex(align="center" class="mb-2")
      UChip(class="mr-auto") {{ ads.name }}
      UTab(:list="list" v-model="tab")

    transition(name="up" mode="out-in")
      AdsRevenue(v-if="tab == 'revenue'" :ads="ads")
      AdsSignUp(v-if="tab == 'signup'" :ads="ads")
</template>

<script>
import AdsRevenue from '@/components/admin/ads/Revenue.vue'
import AdsSignUp from '@/components/admin/ads/SignUp.vue'

export default {
  components: {
    AdsRevenue,
    AdsSignUp
  },

  props: {
    ads: { type: Object },
    reload: { type: Number }
  },

  data() {
    return {
      tab: 'revenue',
      list: [
        { value: 'revenue', label: 'Doanh thu' },
        { value: 'signup', label: 'Đăng ký' }
      ]
    }
  },

  methods: {
    onReload () {
      this.$emit('reload')
    }
  },
}
</script>
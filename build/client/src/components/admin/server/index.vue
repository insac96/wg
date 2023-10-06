<template lang="pug">
  div(class="ManageUserInfo" v-if="server")
    UTab(:list="list" v-model="tab")

    transition(name="up" mode="out-in")
      ServerLogin(v-if="tab == 'login'" :server="server")
      ServerSpend(v-if="tab == 'spend'" :server="server")
      ServerRankSpend(v-if="tab == 'rank_spend'" :server="server")
      ServerRankPower(v-if="tab == 'rank_power'" :server="server")
      ServerRankLevel(v-if="tab == 'rank_level'" :server="server")
      ServerRankGift(v-if="tab == 'rank_gift'" :server="server")
</template>

<script>
import ServerLogin from '@/components/admin/server/Login.vue'
import ServerSpend from '@/components/admin/server/Spend.vue'
import ServerRankSpend from '@/components/admin/server/RankSpend.vue'
import ServerRankPower from '@/components/admin/server/RankPower.vue'
import ServerRankLevel from '@/components/admin/server/RankLevel.vue'
import ServerRankGift from '@/components/admin/server/RankGift.vue'

export default {
  components: {
    ServerLogin,
    ServerSpend,
    ServerRankSpend,
    ServerRankPower,
    ServerRankLevel,
    ServerRankGift
  },

  props: {
    server: { type: Object }
  },

  data() {
    return {
      tab: 'login',
      list: [
        { value: 'login', label: 'Truy cập' },
        { value: 'spend', label: 'Giao dịch' },
        { value: 'rank_spend', label: 'TOP Tiêu phí' },
        { value: 'rank_power', label: 'TOP Lực chiến' },
        { value: 'rank_level', label: 'TOP Cấp' },
        { value: 'rank_gift', label: 'Quà xếp hạng' },
      ]
    }
  }
}
</script>
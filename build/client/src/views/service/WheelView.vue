<template lang="pug">
  div(class="WheelView")
    transition(name="up")
      UCard(class="mb-2" v-if="isLogin && routerPath != '/game' && gifts && gifts.length != 0")
        UFlex(justify="center")
          UserCurrency
    
    transition(name="up")
      UAlert(border color="danger" v-if="!!gifts && gifts.length == 0") Vòng quay may mắn hiện đang bảo trì, vui lòng quay lại sau
      WheelCircle(v-else :list="gifts" @reload="reload")

    transition(name="up")
      WheelLogs(:list="logs" class="mt-2" title="Lịch sử của bạn")

    transition(name="up")
      WheelLogs(:list="world" class="mt-2" title="May mắn nhất" world)
</template>

<script>
import WheelCircle from '@/components/service/wheel/Circle'
import WheelLogs from '@/components/service/wheel/Logs'

export default {
  components: {
    WheelCircle,
    WheelLogs
  },

  data() {
    return {
      gifts: null,
      logs: null,
      world: null
    }
  },

  created () {
    this.getWheel()
  },

  methods: {
    async getWheel () {
      const wheel = await this.API('getWheel')
      if(!wheel) return

      this.gifts = wheel.gifts || []
      this.logs = wheel.logs
      this.world = wheel.world
    },

    reload () {
      this.getWheel()
      this.getUser()
    },
  },
}
</script>
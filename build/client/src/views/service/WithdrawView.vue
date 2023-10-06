<template lang="pug">
  div(class="WithdrawView")
    transition(name="up")
      UCard(class="mb-2" v-if="isLogin")
        UFlex(justify="center")
          UserCurrency

    UCard(class="WithdrawView" title="Rút tiền mặt")
      transition(name="zoom")
        UFlex(align="center" class="mb-2" v-if="review > 0")
          UChip(color="diamond" icon="diamond" class="mr-auto") - {{ $utils.getMoney(diamond, false) }}
          UChip(color="money" icon="money" v-if="review.coin != 0") + {{ $utils.getMoney(review, false) }}

      UFlex(type="column" align="center")
        UInput(v-model="diamond" type="number" icon-color="diamond" icon="diamond" placeholder="Nhập số kim cương muốn rút" width="100%")
      
      template(#footer)
        UFlex(justify="space-between" align="center")
          UChip(@click="$router.push('/history-withdraw')") Xem lịch sử rút tiền
          UButton(color="diamond" @click="withdrawMoney") Tạo Lệnh
</template>

<script>
export default {
  data() {
    return {
      diamond: null
    }
  },

  computed: {
    review () {
      if(!this.storeUser) return 0
      return Number(this.storeUser.vip.diamond_to_money) * Number(this.diamond || 0)
    }
  },

  watch: {
    diamond (val) {
      if(!val) return
      if(Number(val) < 0) return this.diamond = 0
      if(Number(val) > this.storeUser.diamond) return this.diamond = this.storeUser.diamond
    }
  },
  
  methods: {
    async withdrawMoney () {
      if(this.storeUser.diamond <= 0) return this.notify('Bạn không có kim cương để rút')
      if(this.diamond <= 0 || !this.diamond) return this.notify('Vui lòng nhập số lượng kim cương')

      const withdraw = await this.API('withdrawMoney', {
        diamond: this.diamond,
      })
      if(!withdraw) return

      this.getUser()
      this.diamond = null
    },
  },
}
</script>
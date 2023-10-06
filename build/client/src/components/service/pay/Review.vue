<template lang="pug">
  UCard(class="PayReview" title="Xem trước" v-if="gate")
    transition(name="zoom")
      UFlex(align="center" class="mb-2" v-if="money > 0")
        UChip(color="money" icon="money" class="mr-auto") - {{ $utils.getMoney(money) }}
        UChip(color="coin" icon="coin" v-if="review.coin != 0") + {{ $utils.getMoney(review.coin) }}
        UChip(color="coin_lock" icon="coin_lock" class="ml-1" v-if="review.coin_lock_all != 0") + {{ $utils.getMoney(review.coin_lock_all) }}
        UChip(color="wheel" icon="wheel" class="ml-1" v-if="review.wheel != 0") + {{ $utils.getMoney(review.wheel) }}
    //- Bank and Momo
    UFlex(type="column" align="center" v-if="gate.type != 2")
      UInput(v-model="money" type="number" :icon-color="`gate-${gate.type}`" icon="money" placeholder="Nhập số tiền" width="100%")
    //- Card
    UFlex(type="column" align="center" v-if="gate.type == 2")
      USelect(v-model="net.name" :list="listNet" icon-color="primary" icon="bxs-planet" placeholder="Chọn nhà mạng" width="100%")
      USelect(v-model="money" :list="listMoney" :icon-color="`gate-${gate.type}`" icon="money" placeholder="Chọn mệnh giá" width="100%")
      UInput(v-model="net.serial" icon-color="info" icon="code" placeholder="Nhập số Seri" width="100%")
      UInput(v-model="net.pin" icon-color="warn" icon="bxs-rename" placeholder="Nhập mã PIN" width="100%")
    //- Button
    template(#footer)
      UFlex(justify="flex-end")
        UButton(:color="`gate-${gate.type}`" @click="createPayCard" v-if="gate.type == 2") Tạo Giao Dịch
        UButton(:color="`gate-${gate.type}`" @click="createPayBanking" v-else) Tạo Giao Dịch
</template>

<script>
export default {
  props: {
    gate: { type: Object },
    pay: { type: Object },
  },

  data() {
    return {
      money: null,
      
      net: {
        name: null,
        serial: null,
        pin: null,
      },

      listNet: [
        { label: 'Viettel', value: 'VTT' },
        { label: 'Mobifone', value: 'VMS' },
        { label: 'Vinaphone', value: 'VNP' },
        // { label: 'Vietnam Mobile', value: 'VNM' },
        // { label: 'GATE', value: 'GATE' },
        // { label: 'ZING', value: 'ZING' },
      ],

      listMoney: [
        { label: '10.000', value: 10000 },
        { label: '20.000', value: 20000 },
        { label: '30.000', value: 30000 },
        { label: '50.000', value: 50000 },
        { label: '100.000', value: 100000 },
        { label: '200.000', value: 200000 },
        { label: '300.000', value: 300000 },
        { label: '500.000', value: 500000 },
        { label: '1.000.000', value: 1000000 },
      ]
    }
  },

  computed: {
    review () {
      const expires = this.$utils.getExpires(this.gate.expires_bonus)
      const bonus = expires.active ? Number(this.gate.bonus) : Number(this.gate.bonus_default)
      const vipPayToWheel = !!this.isLogin ? Number(this.storeUser['vip']['pay_to_wheel']) : 0
      const vipPayBonusCoin = !!this.isLogin ? Number(this.storeUser['vip']['pay_bonus']) : 0
      const vipPayBonusCoinFromReferraler = !!this.isLogin ? Number(!!this.storeUser['referraler'] ? this.storeUser['referraler']['referral_pay_bonus'] : 0) : 0

      const money = Number(this.money)
      const coin = money
      const coin_lock = Math.floor(money * bonus / 100)
      const coin_lock_vip = Math.floor(money * vipPayBonusCoin / 100)
      const coin_lock_referraler = Math.floor(money * vipPayBonusCoinFromReferraler / 100);
      const coin_lock_all = coin_lock + coin_lock_vip + coin_lock_referraler
      const wheel = vipPayToWheel != 0 ? Math.floor(money / vipPayToWheel) : 0

      return {
        coin, coin_lock, coin_lock_vip, coin_lock_all, coin_lock_referraler, wheel
      }
    }
  },

  watch: {
    gate () {
      this.resetVal()
    },

    money (val) {
      if(!val) return
      if(Number(val) < 0) return this.money = null
      if(Number(val) > 10000000) return this.money = 10000000
    }
  },

  methods: {
    resetVal () {
      this.money = null
      this.net.name = null
      this.net.serial = null
      this.net.pin = null
    },

    async createPayBanking () {
      if(!this.isLogin) return this.notify('Vui lòng đăng nhập trước')
      if(!this.money) return this.notify('Vui lòng nhập số tiền')
      if(this.money <= 0) return this.notify('Số tiền phải lớn hơn 0')

      const pay = await this.API('createPay', {
        money: this.money,
        gate_id: this.gate.id
      })
      if(!pay) return

      pay.review = JSON.parse(JSON.stringify(this.review))
      this.$emit('update:pay', pay)
    },

    async createPayCard () {
      if(!this.isLogin) return this.notify('Vui lòng đăng nhập trước')
      if(!this.net.name || !this.net.serial || !this.net.pin) return this.notify('Vui lòng nhập đầy đủ thông tin')
      if(!this.money) return this.notify('Vui lòng chọn số tiền')
      
      const pay = await this.API('createPay', {
        money: this.money,
        serial: this.net.serial,
        pin: this.net.pin,
        name: this.net.name,
        gate_id: this.gate.id
      })
      if(!pay) return

      pay.net = JSON.parse(JSON.stringify(this.net))
      pay.review = JSON.parse(JSON.stringify(this.review))
      this.$emit('update:pay', pay)
    },
  },
}
</script>
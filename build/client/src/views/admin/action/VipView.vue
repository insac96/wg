<template lang="pug">
  div(class="ActionVipView")
    UTableAdmin(
      :head="head"
      :reload="reload"
      :select.sync="select"
      get-action="getAllVip"
      first-sort="number"
      action-one
      @one="updateVip"
    )
      template(#one v-if="select")
        UInput(v-model="select.number" label-top="Cấp VIP" type="number" disabled)
        UInput(v-model="select.need_exp" label-top="Kinh nghiệm cần đạt (? EXP)" type="number")
        UInput(v-model="select.discount_shop" label-top="Giảm giá cửa hàng (% Giá)" type="number")
        UInput(v-model="select.pay_bonus" label-top="Nạp tặng thêm Xu (% Tiền)" type="number")
        UInput(v-model="select.referral_pay_bonus" label-top="Người được giới thiệu nạp tặng Kim Cương (% Tiền)" type="number")
        UInput(v-model="select.referral_bonus_coin" label-top="Giới thiệu tặng Xu (? Xu)" type="number")
        UInput(v-model="select.pay_to_wheel" label-top="Tiền Nạp thành Lượt Quay (? VNĐ = 1 Lượt)" type="number")
        UInput(v-model="select.diamond_to_money" label-top="Kim Cương thành Tiền (1 Kim Cương = ? VNĐ)" type="number")
        UInput(v-model="select.max_invite" label-top="Giới hạn mời" type="number")
        UInput(v-model="select.max_spin_wheel" label-top="Giới hạn quay vòng quay" type="number")
</template>

<script>
export default {
  data() {
    return {
      head: {
        'number': 'Level',
        'need_exp': 'EXP',
        'discount_shop': 'Discount Shop',
        'pay_bonus': 'Pay Bonus Coin',
        'referral_pay_bonus': 'Invitee Pay Bonus Diamond',
        'referral_bonus_coin': 'Referral Bonus Coin',
        'pay_to_wheel': 'Money To Wheel',
        'diamond_to_money': 'Diamond To Money',
        'max_invite': 'Max Invite',
        'max_spin_wheel': 'Max Spin Wheel'
      },

      select: null,

      reload: 0,
    }
  },

  methods: {
    async updateVip () {
      const select = JSON.parse(JSON.stringify(this.select))
      const update = await this.API('updateVip', select, true)
      if(!!update) return this.onReload()
    },

    onReload () {
      this.reload = this.reload + 1
    }
  },
}
</script>
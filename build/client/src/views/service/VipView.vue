<template lang="pug">
  div(class="VipView" v-if="list")
    UScrollX(class="mb-2")
      UBox(
        v-for="vip in list"
        :key="vip.number"
        :title="`VIP ${vip.number}`"
        :color="`vip-${vip.number}`"
        class="VIP box-resize-scroll"
        @click="vipSelect = vip"
      )
        img(:src="`${publicPath}images/avatar/${vip.number || 1}.webp`" width="100%" :alt="vip.number")
        template(#footer)
          UFlex(justify="center")
            UChip(flat color="dark") {{ $utils.getMoney(vip.need_exp, false) }} EXP

    UCard(:title="`Đặc quyền VIP ${vipSelect.number}`" v-if="vipSelect")
      UFlex(align="center" justify="space-between" class="mb-2")
        UText(size="0.85rem") Giảm giá Cửa Hàng
        UChip(icon="coin" color="coin") - {{ vipSelect.discount_shop }}%
      UFlex(align="center" justify="space-between" class="mb-2")
        UText(size="0.85rem") Nạp thưởng Xu Khóa
        UChip(icon="coin_lock" color="coin_lock") + {{ vipSelect.pay_bonus }}%
      UFlex(align="center" justify="space-between" class="mb-2")
        UText(size="0.85rem") Nạp thưởng Vòng Quay
        UChip(icon="wheel" color="wheel") {{ $utils.getMoney(vipSelect.pay_to_wheel, false) }} VNĐ /
      UFlex(align="center" justify="space-between" class="mb-2")
        UText(size="0.85rem") Tỷ giá đổi Kim Cương
        UChip(icon="diamond" color="diamond") {{ $utils.getMoney(vipSelect.diamond_to_money, false) }} VNĐ /
      UFlex(align="center" justify="space-between" class="mb-2")
        UText(size="0.85rem") Giới thiệu thưởng
        UChip(icon="user" color="user") {{ $utils.getMoney(vipSelect.referral_bonus_coin, false) }} Xu / 
      UFlex(align="center" justify="space-between" class="mb-2")
        UText(size="0.85rem") Người bạn giới thiệu nạp thưởng
        UChip(icon="diamond" color="diamond") {{ vipSelect.referral_pay_bonus }}%
      UFlex(align="center" justify="space-between" class="mb-2")
        UText(size="0.85rem") Giới hạn giới thiệu
        UChip(icon="user" color="user") {{ vipSelect.max_invite }}
      UFlex(align="center" justify="space-between")
        UText(size="0.85rem") Giới hạn lượt quay mỗi ngày
        UChip(icon="wheel" color="wheel") {{ vipSelect.max_spin_wheel }}
      
</template>

<script>
export default {
  data() {
    return {
      list: null,
      vipSelect: null
    }
  },

  created() {
    this.getAllVip()
  },

  methods: {
    async getAllVip () {
      const list = await this.API('getAllVip')
      if(!list) return
      this.list = list
      this.vipSelect = list[0]
    }
  },
}
</script>

<style lang="sass">
.VipView
  .VIP
    .UiBox__Body
      padding: 0
</style>
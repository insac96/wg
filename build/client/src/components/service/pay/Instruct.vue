<template lang="pug">
  div(class="PayInstruct" v-if="gate && pay")
    UCard(title="Thông tin giao dịch")
      //- Bank and Momo
      div(v-if="gate.type != 2")
        UFlex(align="center" justify="space-between" class="mb-2")
          UText(size="0.85rem") Kênh chuyển
          UChip(icon="gate" :color="`gate-${gate.type}`") {{gate.name}}
        UFlex(align="center" justify="space-between" class="mb-2")
          UText(size="0.85rem") Chủ tài khoản
          UChip(icon="user" color="user") {{gate.person }}
        UFlex(align="center" justify="space-between" class="mb-2")
          UText(size="0.85rem") Số tài khoản
          UChip(icon="pay" color="pay") {{gate.stk}}
        UFlex(align="center" justify="space-between" class="mb-2")
          UText(size="0.85rem") Nội dung
          UChip(icon="pcode" color="dark") {{pay.code}}
      //- Card
      div(v-if="gate.type == 2")
        UFlex(align="center" justify="space-between" class="mb-2" v-if="pay.net")
          UText(size="0.85rem") Nhà mạng
          UChip(icon="bxs-planet" :color="`gate-${gate.type}`") {{pay.net.name}}
        UFlex(align="center" justify="space-between" class="mb-2" v-if="pay.net")
          UText(size="0.85rem") Số Seri
          UChip(icon="code" color="info") {{pay.net.serial}}
        UFlex(align="center" justify="space-between" class="mb-2" v-if="pay.net")
          UText(size="0.85rem") Mã thẻ
          UChip(icon="bxs-rename" color="warn") {{pay.net.pin}}
      //- Public
      UFlex(align="center" justify="space-between" class="mb-2")
        UText(size="0.85rem") Số tiền
        UChip(icon="money" color="money") {{ $utils.getMoney(pay.money, false) }}
      //- Review
      UFlex(align="center" justify="space-between" class="mb-2" v-if="pay.review.coin != 0")
        UText(size="0.85rem") Xu nhận
        UChip(icon="coin" color="coin") + {{ $utils.getMoney(pay.review.coin, false) }}
      UFlex(align="center" justify="space-between" class="mb-2" v-if="pay.review.coin_lock != 0")
        UText(size="0.85rem") Khuyến mại
        UChip(icon="coin_lock" color="coin_lock") + {{ $utils.getMoney(pay.review.coin_lock, false) }}
      UFlex(align="center" justify="space-between" class="mb-2" v-if="pay.review.coin_lock_vip != 0")
        UText(size="0.85rem") VIP {{storeUser.vip.number}} thêm
        UChip(icon="coin_lock" color="coin_lock") + {{ $utils.getMoney(pay.review.coin_lock_vip, false) }}
      UFlex(align="center" justify="space-between" class="mb-2" v-if="pay.review.coin_lock_referraler != 0")
        UText(size="0.85rem") Từ người giới thiệu
        UChip(icon="coin_lock" color="coin_lock") + {{ $utils.getMoney(pay.review.coin_lock_referraler, false) }} 
      UFlex(align="center" justify="space-between" v-if="pay.review.wheel != 0")
        UText(size="0.85rem") Vòng quay
        UChip(icon="wheel" color="wheel") + {{ $utils.getMoney(pay.review.wheel, false) }}
      
      template(#footer)
        UFlex(align="center")
          UChip(class="mr-auto" @click="$router.push('/history-pay')") Xem lịch sử giao dịch
          UButton(color="dark" @click="qr = true" avatar class="mr-1" v-if="pay.qr")
            UIcon(src="bx-qr-scan" size="1.3rem")
          UButton(color="pay" @click="newPay") Giao dịch mới

    UDialog(v-model="qr" max="300px" blur v-if="pay.qr")
      UBox(title="Mã QR Code" no-padding)
        img(:src="pay.qr" width="100%" height="auto" alt="qrcode")
</template>

<script>
export default {
  props: {
    gate: { type: Object },
    pay: { type: Object }
  },

  data() {
    return {
      qr: false
    }
  },

  methods: {
    newPay () {
      this.$emit('update:pay', null)
      this.$emit('update:gate', null)
    }
  },
}
</script>
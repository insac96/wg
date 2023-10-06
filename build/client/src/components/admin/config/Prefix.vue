<template lang="pug">
  UCard(v-if="configConvert")
    UInput(v-model="configConvert.prefix_pay" label-top="Mã Nạp Tiền")
    UInput(v-model="configConvert.prefix_withdraw" label-top="Mã Rút Tiền")
    UInput(v-model="configConvert.prefix_referral" label-top="Mã Giới Thiệu")
    template(#footer)
      UFlex(justify="flex-end")
        UButton(@click="$emit('save', configConvert)") Lưu
</template>

<script>
export default {
  props: {
    config: { type: Object }
  },

  data() {
    return {
      configConvert: null
    }
  },

  created () {
    this.configConvert = JSON.parse(JSON.stringify(this.config))
  },
}
</script>
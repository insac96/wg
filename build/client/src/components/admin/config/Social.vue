<template lang="pug">
  UCard(v-if="configConvert")
    UInput(v-model="configConvert.fanpage_link" label-top="Link Fanpage")
    UInput(v-model="configConvert.group_link" label-top="Link Group Facebook")
    UInput(v-model="configConvert.messenger_link" label-top="Link Group Messenger")
    UInput(v-model="configConvert.zalo_link" label-top="Link Group Zalo")
    UInput(v-model="configConvert.telegram_link" label-top="Link Group Telegram")
    UInput(v-model="configConvert.phone_support" label-top="Số điện thoại hỗ trợ")
    UInput(v-model="configConvert.email_support" label-top="Email hỗ trợ")
    
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
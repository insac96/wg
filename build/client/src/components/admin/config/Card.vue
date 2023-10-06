<template lang="pug">
  UCard(v-if="configConvert")
    UInput(v-model="configConvert.api_key_card" label-top="API KEY CARD")
    UInput(v-model="configConvert.url_callback_card" label-top="URL CALLBACK CARD")
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
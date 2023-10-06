<template lang="pug">
  UCard(v-if="configConvert")
    UInput(v-model="configConvert.api_key_banking" label-top="API KEY BANK")
    UInput(v-model="configConvert.url_callback_banking" label-top="URL CALLBACK BANK")
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
<template lang="pug">
  UCard(v-if="configConvert")
    UInput(v-model="configConvert.api_key_momo" label-top="API KEY MOMO")
    UInput(v-model="configConvert.url_callback_momo" label-top="URL CALLBACK MOMO")
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
<template lang="pug">
  UCard(v-if="configConvert")
    UInput(v-model="configConvert.game_name" label-top="Tên trò chơi")
    UInput(v-model="configConvert.game_info" label-top="Mô tả")
    UInput(v-model="configConvert.game_logo" label-top="Logo")
    UInput(v-model="configConvert.game_banner" label-top="Banner")
    UInput(v-model="configConvert.game_icon_path" label-top="Đường dẫn Icon")
    UInput(v-model="configConvert.web_link" label-top="Link Trang Web")
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
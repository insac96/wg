<template lang="pug">
  UCard(title="Cài đặt Xúc Xắc" class="ActivateDiceView box-resize-50" v-if="config")
    UInput(v-model="config.default_jar" placeholder="Nhập số xu" type="number" label-top="Hũ mặc định")
    USelect(v-model="config.need_vip" placeholder="Chọn cấp VIP" label-top="Cấp VIP cần để chơi" :list="listVip")
    UInput(v-model="config.percent_jar_six" placeholder="Nhập tỷ lệ" type="number" label-top="Tỷ lệ nổ hũ 666")
    UInput(v-model="config.percent_jar_other" placeholder="Nhập tỷ lệ" type="number" label-top="Tỷ lệ nổ hũ khác")
    template(#footer)
      UFlex(justify="flex-end")
        UButton(@click="updateDiceConfig") Lưu
</template>

<script>
export default {
  data() {
    return {
      config: null
    }
  },
  computed: {
    listVip () {
      const list = []
      for (let i = 0; i <= 24; i++) {
        list.push({ value: i, label: `VIP ${i}` })
      }
      return list
    }
  },
  mounted () {
    this.getDiceConfig()
  },
  methods: {
    async getDiceConfig () {
      const config = await this.API('getDiceConfig', {}, true)
      if(!!config) return this.config = config
    },
    async updateDiceConfig () {
      const update = await this.API('updateDiceConfig', this.config, true)
      if(!!update) return this.getDiceConfig()
    }
  },
}
</script>
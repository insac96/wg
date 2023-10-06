<template lang="pug">
  UCard(class="PayGate" v-if="list" title="Kênh nạp")
    UFlex(justify="center" align="center" wrap="wrap")
      UBox(
        v-for="item in list"
        :key="item.id"
        :title="item.name"
        :color="(gate.id == item.id) && `gate-${item.type}`"
        class="box-resize"
        @click="setGate(item)"
      )
        UFlex(justify="center")
          img(
            :src="item.icon || `${publicPath}images/gate/${typeView[item.type]}.png`" 
            :alt="item.name" 
            width="80%" 
            height="auto"
          )
        template(#footer)
          UFlex(justify="center")
            UText(weight="500" size="0.8rem" no-wrap) +{{ bonus(item) }}% Xu
</template>

<script>
export default {
  props: {
    gate: { type: Object }
  },

  data() {
    return {
      list: null,

      typeView: {
        1: 'banking',
        2: 'card',
        3: 'momo'
      }
    }
  },

  watch: {
    gate (val) {
      if(!val) return this.getAllGate()
    }
  },

  created() {
    this.getAllGate()
  },

  methods: {
    async getAllGate () {
      const list = await this.API('getAllGate')
      if(!list) return

      this.list = list
      this.setGate(this.list[0])
    },

    setGate (gate) {
      if(!gate) return
      this.$emit('update:gate', gate)
    },

    bonus (gate) {
      const expires = this.$utils.getExpires(gate.expires_bonus)
      return expires.active ? gate.bonus : gate.bonus_default
    }
  },
}
</script>
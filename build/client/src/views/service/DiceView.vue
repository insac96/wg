<template lang="pug">
  div(class="DiceView")
    transition(name="up")
      UCard(class="mb-2" v-if="isLogin && routerPath != '/game'")
        UFlex(justify="center")
          UserCurrency
    
    transition(name="up")
      DiceMain(@reload="reload" :jar="jar")

    transition(name="up")
      DiceLogs(:list="logs" class="mt-2" title="Lịch sử của bạn")

    transition(name="up")
      DiceLogs(:list="world" class="mt-2" title="May mắn nhất" world)
</template>

<script>
import DiceMain from '@/components/service/dice/Main'
import DiceLogs from '@/components/service/dice/Logs'

export default {
  components: {
    DiceMain,
    DiceLogs
  },

  data() {
    return {
      jar: null,
      logs: null,
      world: null
    }
  },

  created () {
    this.getDice()
  },

  methods: {
    async getDice () {
      const dice = await this.API('getDice')
      if(!dice) return
      
      this.jar = dice.jar
      this.logs = dice.logs
      this.world = dice.world
    },

    reload () {
      this.getDice()
      this.getUser()
    },
  },
}
</script>
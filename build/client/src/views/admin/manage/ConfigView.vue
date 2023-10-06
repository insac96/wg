<template lang="pug">
  div(class="ManageConfigView" v-if="config")
    UTab(:list="list" v-model="tab" color="shop" class="mb-2")

    transition(name="up" mode="out-in")
      ConfigWeb(v-if="tab == 'web'" :config="config" @save="saveConfig")
      ConfigSocial(v-if="tab == 'social'" :config="config" @save="saveConfig")
      ConfigPrefix(v-if="tab == 'prefix'" :config="config" @save="saveConfig")
      ConfigCard(v-if="tab == 'card'" :config="config" @save="saveConfig")
      ConfigMomo(v-if="tab == 'momo'" :config="config" @save="saveConfig")
      ConfigBanking(v-if="tab == 'banking'" :config="config" @save="saveConfig")
</template>

<script>
import ConfigWeb from '@/components/admin/config/Web.vue'
import ConfigPrefix from '@/components/admin/config/Prefix.vue'
import ConfigSocial from '@/components/admin/config/Social.vue'
import ConfigCard from '@/components/admin/config/Card.vue'
import ConfigMomo from '@/components/admin/config/Momo.vue'
import ConfigBanking from '@/components/admin/config/Banking.vue'

export default {
  components: {
    ConfigWeb,
    ConfigPrefix,
    ConfigCard,
    ConfigMomo,
    ConfigBanking,
    ConfigSocial
  },

  data() {
    return {
      tab: 'web',
      list: [
        { value: 'web', label: 'Trang' },
        { value: 'social', label: 'Cộng đồng' },
        { value: 'prefix', label: 'Prefix' },
        { value: 'card', label: 'Thẻ cào' },
        { value: 'momo', label: 'Momo' },
        { value: 'banking', label: 'Banking' },
      ],
      config: null
    }
  },

  created () {
    this.getConfigAdmin()
  },

  methods: {
    async getConfigAdmin () {
      this.config = await this.API('getConfig', null, true)
    },

    async saveConfig (config) {
      const save = await this.API('saveConfig', {
        config: config
      }, true)

      if(!!save) return this.getConfigAdmin()
    }
  },
}
</script>
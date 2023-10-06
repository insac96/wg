<template lang="pug">
  UCard(v-if="config" class="ActionLinkView")
    UInput(@click="make('group')" v-model="linkMissionGroup" placeholder="Bấm để tạo" read-only label-top="Facebook")

    UInput(@click="make('zalo')" v-model="linkMissionZalo" read-only placeholder="Bấm để tạo" label-top="Zalo")

    UInput(@click="make('telegram')" v-model="linkMissionTelegram" placeholder="Bấm để tạo" read-only label-top="Telegram")
</template>

<script>
export default {
  data() {
    return {
      config: null,
      loading: false,
      linkMissionZalo: null,
      linkMissionGroup: null,
      linkMissionTelegram: null
    }
  },

  created () {
    this.getConfigAdmin()
  },

  methods: {
    async getConfigAdmin () {
      this.config = await this.API('getConfig', null, true)
    },
    
    async make (type) {
      if(!!this.isLoading) return this.notify('Đang tạo, vui lòng đợi')
      if(!this.config.web_link) return this.notify('Vui lòng cập nhật Link trang Web trước')

      this.$store.commit('setLoading', true)
      const weblink = this.config.web_link
      const originalLink = `${weblink}/client/complete/${type}`
      const apiUrl = `https://api.shrtco.de/v2/shorten?url=${originalLink}`;

      try {
        const response = await fetch(apiUrl)
        const data = await response.json()
        const link = data.result.full_short_link

        if(type == 'zalo'){
          this.linkMissionZalo = link
        }
        if(type == 'group'){
          this.linkMissionGroup = link
        }
        if(type == 'telegram'){
          this.linkMissionTelegram = link
        }

        this.$store.commit('setLoading', false)

      } catch (e) {
        this.notify('Có lỗi xảy ra, vui lòng thử lại sau')
        this.$store.commit('setLoading', false)
      }
    }
  },
}
</script>
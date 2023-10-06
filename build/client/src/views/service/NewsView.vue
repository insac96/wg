<template lang="pug">
  UCard(class="NewsView" v-if="news")
    template(#header)
      UFlex(justify="space-between" align="center")
        UChip() {{ news.viewer }} lượt xem
        UChip(icon="time" color="time") {{ $utils.getTime(news.update_time).from }}
    div(v-html="news.content" class="NewsMain")
</template>

<script>
export default {
  data() {
    return {
      news: null
    }
  },

  created () {
    this.getNews()
  },

  methods: {
    async getNews () {
      const title_seo = String(this.$route.params.title)

      this.news = await this.API('getNews', {
        title_seo: title_seo
      })
    }
  },
}
</script>

<style lang="sass">
.NewsView
  .NewsMain
    position: relative
    box-shadow: none !important
    border: none !important
    overflow: hidden
    img
      position: relative
      max-width: 90%
      margin: 0 auto
</style>
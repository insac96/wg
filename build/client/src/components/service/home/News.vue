<template lang="pug">
  div(class="HomeNews" v-if="list")
    UAlert(v-if="list.length == 0" icon="news" border) Hiện tại không có tin tức mới

    UFlex(wrap="wrap")
      div(v-for="news in list" :key="news.id" class="News box-resize-50" @click="to(news.title_seo)")
        img(:src="news.img ? news.img : `${publicPath}images/news.png`" alt="news")
        div(class="News__Content")
          UText(size="1rem" weight="700" mini) {{ news.title }}
          UText(size="0.8rem" color="gray-600" mini) {{ news.description }}
        UChip(class="News__Time") {{ $utils.getTime(news.update_time).from }}
        
    UFlex(justify="flex-end" class="mt-2" v-if="page > 1")
      UPagination(:total="total" :page.sync="page")
</template>

<script>
export default {
  props: {
    tab: { type: String }
  },

  data() {
    return {
      list: null,
      page: 1,
      total: null
    }
  },

  created () {
    this.getAllNews()
  },

  watch: {
    page () {
      this.getAllNews()
    },

    tab () {
      this.list = null
      setTimeout(() => this.getAllNews(), 1)
    }
  },

  methods: {
    async getAllNews () {
      const get = await this.API('getAllNews', {
        limit: 4,
        page: this.page,
        sort: {
          by: 'update_time',
          type: 'DESC'
        },
        tab: this.tab
      })

      if(!get) return

      this.list = get.list
      this.total = get.total_page
    },

    to (title_seo) {
      this.$router.push(`/news/${title_seo}`)
    }
  },
}
</script>

<style lang="sass">
.HomeNews
  .News
    position: relative
    display: flex
    justify-content: center
    align-items: center
    border-radius: var(--radius)
    overflow: hidden
    cursor: pointer
    img
      width: 100%
      aspect-ratio: 16 / 9
      object-fit: cover
    &__Content
      position: absolute
      bottom: 0
      left: 0
      width: 100%
      padding: var(--space)
      background: rgba(var(--ui-content), 0.8)
      z-index: 1
      .UiText:first-child
        text-transform: capitalize
        margin-bottom: 1px
    &__Time
      position: absolute
      top: var(--space)
      right: var(--space)
</style>
<template>
  <UFlex align="center" class="UiPagination" v-if="total && total > 1">
    <UChip height="33px" color="dark" @click="prev" v-if="page > 1 && total > 3">
      <UIcon src="bx-chevrons-left"></UIcon>
    </UChip>

    <UChip height="33px" v-for="i in list" :key="i" :color="color" :full="i == page" @click="select(i)">{{ i }}</UChip>

    <UChip height="33px" color="dark" @click="next" v-if="page < total && total > 3">
      <UIcon src="bx-chevrons-right"></UIcon>
    </UChip>
  </UFlex>
</template>

<script>
export default {
  props: {
    total: { type: Number || String },
    page: { type: Number || String },
    color: { type: String },
  },

  methods: {
    prev () {
      if(this.page == 1) return
      this.$emit('update:page', Number(this.page) - 1)
    },

    next () {
      if(this.page == this.total) return
      this.$emit('update:page', Number(this.page) + 1)
    },

    select (page) {
      if(page == '...') return this.next()
      this.$emit('update:page', Number(page))
    }
  },

  computed: {
    list () {
      if(this.total <= 3) return this.total

      const list = []
      const key = ['start', 'prev', 'now', 'next', 'end' ]
      const set = {
        start: null, 
        prev: null,
        now: null, 
        next: null, 
        end: null
      }

      set.now = this.page
      set.end = this.total

      if(this.page == 1){
        set.next = '...'
      }
      if(this.page > 1){
        set.start = 1
        if(this.page > set.start + 1){
          set.prev = set.now - 1
        }
        if(this.page < set.end - 1){
          set.next = set.now + 1
        }
        if(this.page == set.end){
          set.end = null
        }
      }

      key.forEach(i => {
        if(!!set[i]){
          list.push(set[i])
        }
      })

      return list
    }
  },
}
</script>

<style lang="sass">
.UiPagination
  div
    margin: 0 3px
</style>
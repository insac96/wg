<template lang="pug">
  div(class="EventList" v-if="list")
    UAlert(border color="event" v-if="list.length == 0") Chưa có sự kiện nào khả dụng, vui lòng quay lại sau

    UScrollX
      UBox(
        v-for="item in list"
        :key="item.id"
        :title="item.name"
        class="box-resize-scroll"
        :color="(event && item.id == event.id) && 'dark'"
        @click="setEvent(item)"
      )
        UFlex(justify="center")
          img(
            :src="`${publicPath}images/event/${item.type}.png`" 
            :alt="item.name" 
            width="70%" 
            height="auto"
          )

        template(#footer)
          UFlex(justify="center")
            UChip(color="time" :full="(event && item.id == event.id)" :border="(event && item.id != event.id)") {{ $utils.getExpires(item.expires_time).text }}
</template>

<script>
export default {
  props: {
    event: { type: Object }
  },

  data() {
    return {
      list: null
    }
  },

  created () {
    this.getAllEvent()
  },

  methods: {
    async getAllEvent () {
			const list = await this.API('getAllEvent')
      if(!list) return
      this.$emit('update:event', list[0])
      this.list = list
		},

    setEvent (event) {
      this.$emit('update:event', null)

      setTimeout(() => {
        this.$emit('update:event', event)
      }, 1);
    }
  },
}
</script>
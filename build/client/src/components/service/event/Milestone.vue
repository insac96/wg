<template lang="pug">
  div(class="EventMilestone" v-if="list")
    UAlert(border color="danger" v-if="list.length == 0") Sự kiện chưa có mốc thưởng

    UBox(
      class="Milestone"
      v-for="milestone in list"
      :key="milestone.id" 
      :title="`${event.prefix} ${$utils.getMoney(milestone.need, false)} ${event.suffix}`"
    )
      UFlex(align="center")
        div(class="mr-auto" class="ListGift")
          UChip(v-if="$utils.getGifts(milestone.gifts).length == 0") Chưa cập nhật phần thưởng
          UFlex(v-else wrap="wrap")
            UItem(v-for="(gift, index) in $utils.getGifts(milestone.gifts)" :key="index" :item="gift")
        UChip(
          v-if="milestone.active.type > 0"
          class="ml-2" full
          :color="typeColor[milestone.active.type]"
          @click="setMilestone(milestone)"
        ) {{ milestone.active.text }}

    UDialog(v-model="dialog")
      UBox(width="100%" title="Thông tin" v-if="milestoneSelect")
        SelectServer(v-model="serverSelect" class="mb-2")  
        UFlex(align="center" justify="space-between" class="mb-2")
          UText(size="0.85rem") Sự kiện
          UChip() {{event.name}}  
        UFlex(align="center" justify="space-between" class="mb-2")
          UText(size="0.85rem") Mốc nhận
          UChip() {{`${event.prefix} ${$utils.getMoney(milestoneSelect.need)} ${event.suffix}`}}

        template(#footer)
          UFlex(align="center" justify="flex-end")
            UButton(color="success" @click="receiveMilestone" class="mr-1") Nhận
            UButton(color="gray" @click="cancel") Không
</template>

<script>
export default {
  props: {
    event: { type: Object }
  },

  data() {
    return {
      list: null,
      milestoneSelect: null,
      serverSelect: null,
      dialog: false,
      typeColor: {
        '1': 'danger',
        '2': 'primary',
        '3': 'success'
      }
    }
  },

   created() {
    if(!!this.event) return this.getAllMilestone()
  },

  watch: {
    event (val) {
      if(!val) return
      this.getAllMilestone()
    }
  },

  methods: {
    async getAllMilestone () {
      const list = await this.API('getAllMilestone', {
        event_id: this.event.id
      })
      if(!!list) return this.list = list
    },

    async receiveMilestone () {
      if(!this.isLogin) return this.notify('Vui lòng đăng nhập trước')
      if(!this.milestoneSelect) return this.notify('Vui lòng chọn mốc nhận trước')
      if(!this.serverSelect) return this.notify('Vui lòng chọn máy chủ trước')

      const receive = await this.API('receiveMilestone', {
        milestone_id: this.milestoneSelect.id,
        server_id: this.serverSelect
      })
      if(!receive) return
      this.cancel()
      this.getAllMilestone()
    },

    setMilestone (milestone) {
      if(milestone.active.type != 2) return this.notify(milestone.active.msg)
      this.milestoneSelect = milestone
      this.dialog = true
    },

    cancel () {
      this.dialog = false
      this.milestoneSelect = null
      this.serverSelect = null
    }
  }
}
</script>

<style lang="sass">
.EventMilestone
  .Milestone
    margin-bottom: var(--space)
    &:last-child
      margin-bottom: 0
    .ListGift
      width: 100%
      flex-grow: 1
      margin-right: var(--space)
</style>
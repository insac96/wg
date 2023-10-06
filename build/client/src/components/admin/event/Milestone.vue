<template lang="pug">
  div(class="ActivateEventMilestoneView")
    UTableAdmin(
      :head="head"
      :reload="reload"
      :select.sync="select"
      get-action="getAllEventMilestone"
      :plus-get="plusGet"
      first-sort="need"
      action-create
      action-one
      action-two
      action-three
      @create="createEventMilestone"
      @one="updateEventMilestone"
      @two="deleteEventMilestone"
      @three="updateEventMilestone"
      @open-one="openEdit"
      @open-three="openEdit"
    )
      template(#create)
        UInput(v-model="addVal.need" label-top="Điều kiện" type="number")

      template(#one v-if="select && event")
        UInput(v-model="select.need" label-top="Điều kiện" type="number")

      template(#two v-if="select && event")
        UAlert(color="danger" border) Bạn chắc chắn muốn xóa mốc [{{`${event.prefix} ${select.need} ${event.suffix}`}}] khỏi sự kiện [{{event.name}}]?
        
      template(#three v-if="select && event")
        UGiftAdmin(:gifts.sync="select.gifts")
</template>

<script>
export default {
  props: {
    event: { type: Object }
  },

  data() {
    return {
      head: {
        'id': 'ID',
        'need': 'Điều kiện',
        'gifts': 'Phần thưởng',
      },

      select: null,

      reload: 0,

      addVal: {
        need: null,
        event_id: null,
        gifts: []
      }
    }
  },

  watch: {
    event (val) {
      if(val) return this.onReload()
    }
  },

  computed: {
    plusGet () {
      if(!this.event) return null
      return {
        event_id: this.event.id
      }
    }
  },

  methods: {
    async createEventMilestone () {
      if(!this.event) return
      const addVal = JSON.parse(JSON.stringify(this.addVal))
      addVal.event_id = this.event.id
      addVal.gifts = JSON.stringify(addVal.gifts)
      const create = await this.API('createEventMilestone', addVal, true)
      if(!!create) return this.onReload()
    },

    async updateEventMilestone () {
      if(!this.event) return
      const select = JSON.parse(JSON.stringify(this.select))
      select.gifts = JSON.stringify(select.gifts)
      const update = await this.API('updateEventMilestone', select, true)
      if(!!update) return this.onReload()
    },

    async deleteEventMilestone () {
      const del = await this.API('deleteEventMilestone', {
        milestone_id: this.select.id
      }, true)
      if(!!del) return this.onReload()
    },

    openEdit () {
      if(!this.select) return
      this.select.gifts = JSON.parse(this.select.gifts)
    },

    onReload () {
      this.reload = this.reload + 1
      this.addVal = {
        need: null,
        event_id: null,
        gifts: []
      }
    }
  },
}
</script>
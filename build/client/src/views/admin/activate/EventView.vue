<template lang="pug">
  div(class="ActivateEventView")
    EventList(:event.sync="event")
    EventMilestone(:event.sync="event" v-if="event" class="mt-2")
</template>

<script>
import EventList from '@/components/admin/event/List.vue'
import EventMilestone from '@/components/admin/event/Milestone.vue'

export default {
  components: {
    EventList,
    EventMilestone
  },

  data () {
    return {
      event: null
    }
  }
}
</script>
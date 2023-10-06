<template lang="pug">
  div(class="EventView")
    transition(name="up")
      EventList(:event.sync="event" class="mb-2")
    transition(name="up")
      EventMilestone(:event.sync="event" v-if="event")
</template>

<script>
import EventList from '@/components/service/event/List'
import EventMilestone from '@/components/service/event/Milestone'

export default {
  components: {
    EventList,
    EventMilestone
  },

  data() {
    return {
      event: null
    }
  },
}
</script>
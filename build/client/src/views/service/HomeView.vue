<template lang="pug">
  div(class="HomeView")
    UTab(:list="list" v-model="tab" class="mb-2")
    transition(name="up")
      HomeNews(:tab="tab")
</template>

<script>
import HomeNews from '@/components/service/home/News'

export default {
  components: {
    HomeNews
  },

  data() {
    return {
      tab: 'all',
      list: [
        { value: 'all', label: 'Tất cả' },
        { value: 'new', label: 'Mới' },
        { value: 'hot', label: 'Hot' },
        { value: 'update', label: 'Update' },
      ]
    }
  },
}
</script>
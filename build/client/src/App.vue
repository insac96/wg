<template lang="pug">
  router-view
</template>

<script>
export default {
  sockets: {
    notify: function (data) {
      this.notifySocket(data)
    }
  },

  created() {
    this.getConfig()
    this.getDark()
  },
}
</script>

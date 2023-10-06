<template lang="pug">
  UCard(class="GameConfigView" title="Cài đặt")
    UFlex(align="center" justify="space-between" class="mb-2")
      UText(size="0.85rem") Thông báo
      UChip(full :color="storeGameConfig.notify ? 'success' : 'danger'" @click="toggleNotify") {{ storeGameConfig.notify ? 'Bật' : 'Tắt' }}
    UFlex(align="center" justify="space-between" class="mb-2")
      UText(size="0.85rem") Giao diện
      UChip(@click="toggleDark") {{ storeDark ? 'Tối' : 'Sáng' }}
    UFlex(align="center" justify="space-between")
      UText(size="0.85rem") Toàn màn hình
      UChip(@click="openFullscreen") Bấm để mở
</template>

<script>
export default {
  methods: {
    toggleNotify () {
      const config = JSON.parse(JSON.stringify(this.storeGameConfig))
      config.notify = !config.notify
      this.$store.commit('setGameConfig', config)
    },

    toggleDark () {
      const dark = !this.storeDark
      this.$store.commit('setDark', dark)
      document.body.setAttribute('dark', dark)
      window.localStorage.setItem('dark', dark)
    },

    openFullscreen () {
      var elem = document.documentElement;
      if (elem.requestFullscreen) {
        elem.requestFullscreen();
      } else if (elem.webkitRequestFullscreen) {
        elem.webkitRequestFullscreen();
      } else if (elem.msRequestFullscreen) { 
        elem.msRequestFullscreen();
      }
    }
  },
}
</script>
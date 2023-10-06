<template lang="pug">
  UDialog(v-model="show" @hide="$emit('update:open', false)" max="700px")
    div(class="GameLayoutMenu")
      UFlex(class="MenuControl" align="center" full)
        UButton(size="2.5rem" avatar :color="item.icon" v-for="item in list" :key="item.icon" @click="tab = item.value")
          UIcon(:src="item.icon" size="1.2rem")
        UButton(size="2.5rem" avatar color="dark" @click="tab = 'ConfigView'")
          UIcon(src="bx-cog" size="1.2rem")
        UButton(size="2.5rem" avatar color="danger" class="ml-auto" @click="$router.push('/home')")
          UIcon(src="home" size="1.2rem")

      div(class="MenuView")
        transition(name="up" mode="out-in")
          component(:is="tab")
</template>

<script>
import ShopView from '@/views/service/ShopView.vue'
import EventView from '@/views/service/EventView.vue'
import MissionView from '@/views/service/MissionView.vue'
import WheelView from '@/views/service/WheelView.vue'
import GiftcodeView from '@/views/service/GiftcodeView.vue'
import DiceView from '@/views/service/DiceView.vue'
import PayView from '@/views/service/PayView.vue'
import ConfigView from '@/components/game/Config.vue'

export default {
  components: {
    ShopView,
    EventView,
    MissionView,
    WheelView,
    DiceView,
    GiftcodeView,
    PayView,
    ConfigView
  },

  props: {
    open: { type: Boolean, default: false },
  },

  data() {
    return {
      show: false,
      tab: 'ShopView',
      list: [
        { title: 'Cửa Hàng', icon: 'shop', value: 'ShopView' },
        { title: 'Sự Kiện', icon: 'event', value: 'EventView' },
        { title: 'Nhiệm Vụ', icon: 'mission', value: 'MissionView' },
        { title: 'Vòng Quay', icon: 'wheel', value: 'WheelView' },
        { title: 'Xúc Xắc', icon: 'dice', value: 'DiceView' },
        { title: 'GiftCode', icon: 'giftcode', value: 'GiftcodeView' },
        { title: 'Nạp Xu', icon: 'pay', value: 'PayView' },
      ]
    }
  },

  watch: {
    open (val) {
      this.show = val
    }
  },

  mounted() {
    this.show = this.open
  },
}
</script>

<style lang="sass">
.GameLayoutMenu
  display: flex
  flex-direction: column
  align-items: center
  width: 100%
  background: rgb(var(--ui-background))
  border-radius: var(--radius)
  .MenuControl
    background: rgb(var(--ui-content))
    padding: calc(var(--space) / 2)
    border-radius: var(--radius) var(--radius) 0 0
    box-shadow: 0 5px 20px 0 rgba(0,0,0,0.1)
    .UiButton
      margin-right: 3px
  .MenuView
    width: 100%
    min-height: 60vh
    max-height: 60vh
    padding: var(--space)
    overflow-x: hidden
    overflow-y: auto
</style>
<template>
  <div class="UiItem" :style="{ '--ui-item-size': size }">
    <div class="UiItem__Img" @click="dialog = true">
      <img :src="imgItem(item.icon)" width="100%" height="auto" :alt="item.name">
    </div>

    <div class="UiItem__Amount" @click="dialog = true">x{{$utils.getMoney(item.amount)}}</div>

    <UDialog v-model="dialog" max="180px">
      <UBox class="View" :title="item.name" width="100%" @click="dialog = false">
        <UFlex align="center" type="column">
          <img :src="imgItem(item.icon)" width="70%" height="auto" :alt="item.name">
        </UFlex>

        <template #footer>
          <UFlex align="center" justify="center">
            <UChip border color="dark">Số lượng x {{$utils.getMoney(item.amount)}}</UChip>
          </UFlex>
        </template>
      </UBox>
    </UDialog>
  </div>
</template>

<script>
export default {
  props: {
    size: { type: String, default: null },
    item: { type: Object, default: null },
  },

  data() {
    return {
      dialog: false
    }
  },

  methods: {
    imgItem (icon) {
      const iconPath = this.storeConfig ? this.storeConfig.game_icon_path : null
      if(!!icon && !!iconPath){
        return `${iconPath}/${icon}.png`
      }
      else {
        return `${this.publicPath}images/icon/item_game.png`
      }
    },
  },
}
</script>

<style lang="sass">
.UiItem
  --ui-item-size: 50px

.UiItem
  position: relative
  display: inline-flex
  align-items: center
  justify-content: center
  width: var(--ui-item-size)
  height: var(--ui-item-size)
  min-width: var(--ui-item-size)
  min-height: var(--ui-item-size)
  max-width: var(--ui-item-size)
  max-height: var(--ui-item-size)
  border-radius: 50%
  margin: 3px
  padding: 1px
  background: rgb(var(--ui-gray-200))
  border-radius: var(--radius)
  border: 1px solid rgba(var(--ui-dark), 0.1)
  cursor: pointer
  &__Img
    width: 100%
    height: 100%
    border-radius: inherit
    overflow: hidden
  &__Amount
    position: absolute
    bottom: -2px
    right: -2px
    background: rgb(var(--ui-dark))
    color: rgb(var(--ui-light))
    border-radius: 3px
    padding: 3px 5px
    font-size: 0.6rem
    font-weight: 700
</style>
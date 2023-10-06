<template lang="pug">
  UFlex(class="UserMini" v-if="!!storeUser && !!isLogin")
    div(class="Avatar mr-2")
      img(:src="`${publicPath}images/avatar/${storeUser.vip.number || 1}.webp`" :alt="storeUser.account")
    UFlex(class="Content" justify="center" type="column")
      UFlex(align="center" class="mb-2")
        UChip(class="capitalize") {{storeUser.account}}
        UChip(:color="`vip-${storeUser.vip.number}`" full) VIP {{storeUser.vip.number}}
        UChip(color="type-2" full @click="$router.push('/admin')" v-if="storeUser.type > 0") ADMIN
        UButton(color="danger" avatar size="33px" class="ml-auto" @click="logout")
          UIcon(src="bx-power-off" size="1.2rem")
      UFlex(align="center" class="EXP")
        UText(class="mr-2" weight="700" size="0.8rem" no-wrap) EXP
        div(:style="{'--ui-exp-width': vipEXP.percent, '--ui-exp-color': `var(--ui-vip-${storeUser.vip.number})`}")
        UText(class="ml-2" weight="700" size="0.8rem" no-wrap) {{vipEXP.next}}
</template>

<script>
export default {
  data() {
    return {
      typeView : {
        0: 'MEMBER',
        1: 'SMOD',
        2: 'ADMIN'
      }
    }
  },

  computed: {
    vipEXP () {
      if(this.storeUser.next_vip == 'max') return {
        next: 'MAX',
        percent: '100%'
      }

      const percent = Math.floor(Number(this.storeUser.vip_exp) / Number(this.storeUser.next_vip.need_exp) * 100)
      
      return {
        next: 'VIP '+ (Number(this.storeUser.next_vip.number)),
        percent: `${percent}%`
      }
    }
  }
}
</script>

<style lang="sass">
.UserMini
  position: relative
  background: rgba(var(--ui-content))
  border-radius: var(--radius)
  box-shadow: 0 0 20px -10px rgba(var(--ui-black), 0.2)
  border: 1px solid rgba(var(--ui-dark), 0.1)
  padding: var(--space)
  .Avatar
    position: relative
    display: flex
    align-items: center
    justify-content: center
    width: 75px
    max-width: 75px
    height: 75px
    max-height: 75px
    border-radius: var(--radius)
    overflow: hidden
    img
      width: 100%
      height: 100%
      border-radius: inherit
  .Content
    flex-grow: 1
    .UiChip
      margin-right: 3px
    .EXP
      div
        flex-grow: 1
        position: relative
        width: 100%
        height: 10px
        background: rgba(var(--ui-gray), 0.1)
        border-radius: var(--radius)
        overflow: hidden
        &::after
          position: absolute
          content: ''
          width: var(--ui-exp-width)
          height: 100%
          left: 0
          top: 0
          background-image: linear-gradient(90deg, rgb(var(--ui-exp-color)), rgba(var(--ui-exp-color), 0.7))
</style>
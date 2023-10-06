<template lang="pug">
  UFlex(class="UserCurrency" align="center" justify="flex-end" v-if="!!isLogin && !!storeUser")
    UChip(icon="coin" color="coin" v-if="coin") {{ $utils.getMoney(storeUser.coin) }}
    UChip(icon="coin_lock" color="coin_lock" v-if="coin_lock") {{ $utils.getMoney(storeUser.coin_lock) }}
    UChip(icon="diamond" color="diamond" v-if="diamond") {{ $utils.getMoney(storeUser.diamond) }}
    UChip(icon="wheel" color="wheel" v-if="wheel") {{ $utils.getMoney(storeUser.wheel) }}
</template>

<script>
export default {
  props: {
    coin: { type: Boolean, default: true },
    coin_lock: { type: Boolean, default: true },
    diamond: { type: Boolean, default: true },
    wheel: { type: Boolean, default: true },
  }
}
</script>

<style lang="sass">
.UserCurrency
  .UiChip
    margin-right: 6px
    &:last-child
      margin-right: 0
</style>
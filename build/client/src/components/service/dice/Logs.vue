<template lang="pug">
  UCard(class="DiceLogs" :title="title" v-if="list && list.length > 0")
    div(class="Logs")
      transition-group(tag="div" name="log")
        UAlert(border icon="dice" :color="log.money < 0 ? 'danger' : 'success'" v-for="log in list" :key="log.id")
          UText(class="mr-auto" mini) {{ world ? `[${log.account}]` : '' }} {{ log.action }}
          UChip(class="ml-2" :color="log.money < 0 ? 'danger' : 'success'" full) {{$utils.getTime(log.create_time).from}}
</template>

<script>
export default {
  props: {
    list: { type: Array },
    title: { type: String },
    world: { type: Boolean }
  }
}
</script>

<style lang="sass">
.DiceLogs
  .Logs
    position: relative
    overflow: hidden
    .UiAlert
      margin-top: var(--space)
      border: none
      &:first-child
        margin-top: 0

    .log-enter-active, .log-leave-active
      transition: all 0.25s ease
    .log-leave-active
      position: absolute
    .log-enter
      opacity: 0
      transform: translateY(-100%)
    .log-leave-to
      opacity: 0
</style>
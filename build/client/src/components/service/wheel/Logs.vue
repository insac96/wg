<template lang="pug">
  UCard(class="WheelLogs" :title="title" v-if="list && list.length > 0")
    div(class="Logs")
      transition-group(tag="div" name="log")
        UAlert(border :icon="log.gift_type" :color="log.gift_type" v-for="log in list" :key="log.id")
          UText(class="mr-auto" mini) {{ world ? `[${log.account}]` : '' }} {{ log.action }}
          UChip(class="ml-2" :color="log.gift_type" full) {{$utils.getTime(log.create_time).from}}
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
.WheelLogs
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
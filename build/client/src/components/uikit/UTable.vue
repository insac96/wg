<template>
  <div class="UiTable">
    <UScrollX class="Table">
      <table class="Table__Content">
        <thead cellspacing="0"><slot name="head"></slot></thead>
        <tbody><slot></slot></tbody>
      </table>
    </UScrollX>

    <div class="UiTable__NoData" v-if="noData">Không có dữ liệu</div>

    <div class="UiTable__Footer" v-if="$slots.footer">
      <slot name="footer"></slot>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    noData: { type: Boolean, default: false}
  }
}
</script>

<style lang="sass">
.UiTable
  .UiChip
    display: inline-flex
  &__NoData
    padding: var(--space)
    font-size: 0.8rem
    text-align: center
    background: rgba(var(--ui-black), 0.05)
    border-radius: 0 0 var(--radius) var(--radius)
  &__Footer
    padding: calc(var(--space) / 2)
    background: rgba(var(--ui-black), 0.05)
    border-radius: 0 0 var(--radius) var(--radius)
  .Table
    width: 100%
    border-radius: var(--radius)
    background: rgba(var(--ui-content))
    border-radius: var(--radius) var(--radius)  0 0
    box-shadow: 0 0 20px -10px rgba(var(--ui-black), 0.2)
    border: 1px solid rgba(var(--ui-dark), 0.1)
    &__Content
      position: relative
      width: 100%
      border-collapse: collapse
      border-radius: inherit
      overflow: hidden
      thead, tbody
        width: 100%
      thead
        th
          padding: var(--space)
          font-weight: 600
          font-size: 0.8rem
          text-transform: capitalize
          white-space: nowrap
          background: rgba(var(--ui-black), 0.05)
          text-align: start
      tbody
        tr
          margin: 6px 0
          text-align: left
          td
            padding: 6px var(--space)
            background: rgba(var(--ui-content),0.4)
            white-space: normal
</style>
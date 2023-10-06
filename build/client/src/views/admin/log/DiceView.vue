<template lang="pug">
  div(class="LogDiceView")
    UTableAdmin(
      :head="head"
      :plus-search="plusSearch"
      get-action="getAllLogDice"
      search-action="searchLog"
      first-sort="create_time"
    )
</template>

<script>
export default {
  data() {
    return {
      head: {
        'account': 'Tài khoản',
        'action': 'Hành động',
        'create_time': 'Thời gian'
      },

      plusSearch: {
        type: 'dice'
      }
    }
  }
}
</script>
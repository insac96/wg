<template lang="pug">
  div(class="LogEventView")
    UTableAdmin(
      :head="head"
      :plus-search="plusSearch"
      get-action="getAllLogEvent"
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
        'server_id': 'Máy chủ',
        'event_id': 'ID Sự kiện',
        'action': 'Hành động',
        'create_time': 'Thời gian'
      },

      plusSearch: {
        type: 'event'
      }
    }
  }
}
</script>
<template lang="pug">
  div(class="LogWheelView")
    UTableAdmin(
      :head="head"
      :plus-search="plusSearch"
      get-action="getAllLogWheel"
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
        'gift_id': 'ID Phần thưởng',
        'action': 'Hành động',
        'create_time': 'Thời gian'
      },

      plusSearch: {
        type: 'wheel'
      }
    }
  }
}
</script>
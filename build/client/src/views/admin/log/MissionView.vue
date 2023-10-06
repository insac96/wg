<template lang="pug">
  div(class="LogMissionView")
    UTableAdmin(
      :head="head"
      :plus-search="plusSearch"
      get-action="getAllLogMission"
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
        'mission_id': 'ID Nhiệm vụ',
        'action': 'Hành động',
        'create_time': 'Thời gian'
      },

      plusSearch: {
        type: 'mission'
      }
    }
  }
}
</script>
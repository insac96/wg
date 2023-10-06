<template lang="pug">
  div(class="LogAdminView")
    UTableAdmin(
      :head="head"
      :plus-search="plusSearch"
      get-action="getAllLogAdmin"
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
        'type': 'Loại',
        'action': 'Hành động',
        'create_time': 'Thời gian'
      },

      plusSearch: {
        type: 'admin'
      }
    }
  }
}
</script>
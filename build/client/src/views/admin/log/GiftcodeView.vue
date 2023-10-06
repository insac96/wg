<template lang="pug">
  div(class="LogGiftcodeView")
    UTableAdmin(
      :head="head"
      :plus-search="plusSearch"
      get-action="getAllLogGiftcode"
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
        'giftcode_id': 'ID GiftCode',
        'action': 'Hành động',
        'create_time': 'Thời gian'
      },

      plusSearch: {
        type: 'giftcode'
      }
    }
  }
}
</script>
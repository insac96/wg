<template lang="pug">
  div(class="LogShopView")
    UTableAdmin(
      :head="head"
      :plus-search="plusSearch"
      get-action="getAllLogShop"
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
        'shop_type': 'Loại cửa hàng',
        'price': 'Giá mua',
        'action': 'Hành động',
        'create_time': 'Thời gian'
      },

      plusSearch: {
        type: 'shop'
      }
    }
  }
}
</script>
<template lang="pug">
  div(class="AdminLayoutSidebar" ref="sidebar")
    UFlex(align="center" class="AdminLayoutSidebar__Header") Admin Pannel
    
    div(class="AdminLayoutSidebar__Body")
      UBox(class="Tab" v-for="(tab, i) in list" :key="i" :title="tab.title")
        UFlex(class="Item" align="center" v-for="(item, j) in tab.child" :key="j" @click="to(item.to)") {{ item.title }}
    div(class="AdminLayoutSidebar__Footer")
</template>

<script>
export default {
  props: {
    open: { type: Boolean }
  },

  data() {
    return {
      show: this.open,
      list: [
        {
          title: 'Quản lý chung',
          child: [
            { title: 'Thống kê', to: '/admin/manage-statistical' },
            { title: 'Máy chủ', to: '/admin/manage-server' },
            { title: 'Tài khoản', to: '/admin/manage-user' },
            { title: 'Quảng cáo', to: '/admin/manage-ads' },
            { title: 'Địa chỉ IP', to: '/admin/manage-ip' },
            { title: 'Cài đặt', to: '/admin/manage-config' },
          ]
        },
        {
          title: 'Chức năng',
          child: [
            { title: 'Quản lý VIP', to: '/admin/action-vip' },
            { title: 'Bộ quà tặng', to: '/admin/action-gift' },
            { title: 'Kênh Chat', to: '/admin/action-socket' },
            { title: 'Gửi vật phẩm', to: '/admin/action-send' },
          ]
        },
        {
          title: 'Thanh toán',
          child: [
            { title: 'Kênh nạp', to: '/admin/payment-gate' },
            { title: 'Nạp tiền', to: '/admin/payment-pay' },
            { title: 'Rút tiền', to: '/admin/payment-withdraw' },
          ]
        },
        {
          title: 'Cửa hàng',
          child: [
            { title: 'Gói nạp', to: '/admin/shop-recharge' },
            { title: 'Vật phẩm', to: '/admin/shop-item' },
            { title: 'Tiền tệ', to: '/admin/shop-currency' },
            { title: 'Hiệu ứng', to: '/admin/shop-effect' },
          ]
        },
        {
          title: 'Hoạt động',
          child: [
            { title: 'Tin tức', to: '/admin/activate-news' },
            { title: 'Sự kiện', to: '/admin/activate-event' },
            { title: 'Nhiệm vụ', to: '/admin/activate-mission' },
            { title: 'Vòng quay', to: '/admin/activate-wheel' },
            { title: 'Xúc xắc', to: '/admin/activate-dice' },
            { title: 'GiftCode', to: '/admin/activate-giftcode' },
          ]
        },
        {
          title: 'Ghi chép',
          child: [
            { title: 'Quản trị viên', to: '/admin/log-admin' },
            { title: 'Cửa hàng', to: '/admin/log-shop' },
            { title: 'Sự kiện', to: '/admin/log-event' },
            { title: 'Nhiệm vụ', to: '/admin/log-mission' },
            { title: 'Vòng quay', to: '/admin/log-wheel' },
            { title: 'Xúc xắc', to: '/admin/log-dice' },
            { title: 'Giftcode', to: '/admin/log-giftcode' },
          ]
        },
      ]
    }
  },

  watch: {
    open (val) {
      if(!!val){
        this.show = true
        window.addEventListener('click', this.clickOutside)
      }

      if(!val){
        this.show = false
        window.removeEventListener('click', this.clickOutside)
      }
    }
  },

  methods: {
    close () {
      this.$emit('update:open', false)
    },

    to (link) {
      if(link == this.$route.path) return
      this.close()
      this.$router.push(link)
    },

    clickOutside (event) {
      const el = this.$refs['sidebar']
      if(!el) return
      if(
        el == event.target 
        || el.contains(event.target) 
        || event.target.classList.contains('bx-menu-alt-left')
      ) return
      return this.$emit('update:open', false)
    }
  },
}
</script>

<style lang="sass">
.AdminLayoutSidebar
  display: flex
  flex-direction: column
  background: rgb(var(--ui-content))
  box-shadow: 3px 0 20px -10px rgba(0,0,0,0.3)
  overflow: hidden
  &__Header
    width: 100%
    min-height: 55px
    max-height: 55px
    padding: 0 var(--space)
    font-size: 1rem
    font-weight: 700
    background: rgba(var(--ui-primary), 1)
    color: rgba(var(--ui-light))
  &__Body
    flex-grow: 1
    overflow-y: auto
    padding: var(--sapce)
  &__Footer
    height: var(--space)

  .Tab
    border-radius: 0px !important
    box-shadow: none !important
    border: none !important
    .UiBox__Header
      border-radius: 0 !important
      font-weight: 700 !important
    .UiBox__Body
      padding: 0 0 0 var(--space)
    .Item
      width: 100%
      padding: var(--space)
      color: rgba(var(--ui-text), 0.8)
      font-size: 0.85rem
      font-weight: 500
      cursor: pointer
</style>
import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

const originalPush = VueRouter.prototype.push
VueRouter.prototype.push = function push(location) {
  return originalPush.call(this, location).catch(err => err)
}

const routes = [
  // Layout Service
  {
    path: '/',
    name: 'service',
    redirect: { path: '/home' },
    component: () => import(/* webpackChunkName: "route" */ '@/layouts/ServiceLayout.vue'),
    children: [
      {
        path: 'home',
        name: 'Trang Chủ',
        component: () => import(/* webpackChunkName: "route" */ '@/views/service/HomeView.vue'),
      },
      {
        path: 'news/:title',
        name: 'Tin Tức',
        component: () => import(/* webpackChunkName: "route" */ '@/views/service/NewsView.vue'),
      },
      {
        path: 'pay',
        name: 'Nạp Xu',
        component: () => import(/* webpackChunkName: "route" */ '@/views/service/PayView.vue'),
      },
      {
        path: 'shop',
        name: 'Cửa Hàng',
        component: () => import(/* webpackChunkName: "route" */ '@/views/service/ShopView.vue'),
      },
      {
        path: 'event',
        name: 'Sự Kiện',
        component: () => import(/* webpackChunkName: "route" */ '@/views/service/EventView.vue'),
      },
      {
        path: 'mission',
        name: 'Nhiệm Vụ',
        component: () => import(/* webpackChunkName: "route" */ '@/views/service/MissionView.vue'),
      },
      {
        path: 'wheel',
        name: 'Vòng Quay',
        component: () => import(/* webpackChunkName: "route" */ '@/views/service/WheelView.vue'),
      },
      {
        path: 'dice',
        name: 'Xúc Xắc',
        component: () => import(/* webpackChunkName: "route" */ '@/views/service/DiceView.vue'),
      },
      {
        path: 'giftcode',
        name: 'GiftCode',
        component: () => import(/* webpackChunkName: "route" */ '@/views/service/GiftcodeView.vue'),
      },
      {
        path: 'rank',
        name: 'Xếp Hạng',
        component: () => import(/* webpackChunkName: "route" */ '@/views/service/RankView.vue'),
      },
      {
        path: 'vip',
        name: 'VIP',
        component: () => import(/* webpackChunkName: "route" */ '@/views/service/VipView.vue'),
      },
      {
        path: 'withdraw',
        name: 'Rút Tiền',
        component: () => import(/* webpackChunkName: "route" */ '@/views/service/WithdrawView.vue'),
      },
      {
        path: 'history-pay',
        name: 'Lịch Sử Nạp Tiền',
        component: () => import(/* webpackChunkName: "route" */ '@/views/service/history/HistoryPayView.vue'),
      },
      {
        path: 'history-withdraw',
        name: 'Lịch Sử Rút Tiền',
        component: () => import(/* webpackChunkName: "route" */ '@/views/service/history/HistoryWithdrawView.vue'),
      },
      {
        path: 'user',
        name: 'Tài Khoản',
        component: () => import(/* webpackChunkName: "route" */ '@/views/service/UserView.vue'),
      },
      {
        path: 'notify',
        name: 'Thông báo',
        component: () => import(/* webpackChunkName: "route" */ '@/views/service/NotifyView.vue'),
      },
      {
        path: 'sign-in',
        name: 'Đăng Nhập',
        component: () => import(/* webpackChunkName: "route" */ '@/views/service/auth/SignInView.vue'),
      },
      {
        path: 'sign-up',
        name: 'Đăng Ký',
        component: () => import(/* webpackChunkName: "route" */ '@/views/service/auth/SignUpView.vue'),
      },
      {
        path: 'referral/:code',
        name: 'Đăng Ký',
        component: () => import(/* webpackChunkName: "route" */ '@/views/service/auth/SignUpView.vue'),
      },
      {
        path: 'sign-forgot',
        name: 'Quên Mật Khẩu',
        component: () => import(/* webpackChunkName: "route" */ '@/views/service/auth/ForgotView.vue'),
      }
    ]
  },

  // Layout Game
  {
    path: '/game',
    name: 'game',
    component: () => import(/* webpackChunkName: "route" */ '@/layouts/GameLayout.vue'),
  },

  // Layout Admin
  {
    path: '/admin',
    name: 'admin',
    redirect: { path: '/admin/manage-statistical' },
    component: () => import(/* webpackChunkName: "route" */ '@/layouts/AdminLayout.vue'),
    children: [
      {
        path: 'manage-statistical',
        name: 'Thống kê',
        component: () => import(/* webpackChunkName: "route" */ '@/views/admin/manage/StatisticalView.vue'),
      },
      {
        path: 'manage-server',
        name: 'Máy chủ',
        component: () => import(/* webpackChunkName: "route" */ '@/views/admin/manage/ServerView.vue'),
      },
      {
        path: 'manage-user',
        name: 'Tài khoản',
        component: () => import(/* webpackChunkName: "route" */ '@/views/admin/manage/UserView.vue'),
      },
      {
        path: 'manage-ads',
        name: 'Quảng cáo',
        component: () => import(/* webpackChunkName: "route" */ '@/views/admin/manage/AdsView.vue'),
      },
      {
        path: 'manage-ip',
        name: 'Quản lý IP',
        component: () => import(/* webpackChunkName: "route" */ '@/views/admin/manage/IPView.vue'),
      },
      {
        path: 'manage-config',
        name: 'Cài đặt',
        component: () => import(/* webpackChunkName: "route" */ '@/views/admin/manage/ConfigView.vue'),
      },
      {
        path: 'action-vip',
        name: 'Quản lý VIP',
        component: () => import(/* webpackChunkName: "route" */ '@/views/admin/action/VipView.vue'),
      },
      {
        path: 'action-socket',
        name: 'Thời gian thực',
        component: () => import(/* webpackChunkName: "route" */ '@/views/admin/action/SocketView.vue'),
      },
      {
        path: 'action-gift',
        name: 'Bộ quà tặng',
        component: () => import(/* webpackChunkName: "route" */ '@/views/admin/action/GiftView.vue'),
      },
      {
        path: 'action-link',
        name: 'Link nhiệm vụ',
        component: () => import(/* webpackChunkName: "route" */ '@/views/admin/action/LinkView.vue'),
      },
      {
        path: 'action-send',
        name: 'Gửi vật phẩm',
        component: () => import(/* webpackChunkName: "route" */ '@/views/admin/action/SendView.vue'),
      },
      {
        path: 'payment-gate',
        name: 'Kênh nạp',
        component: () => import(/* webpackChunkName: "route" */ '@/views/admin/payment/GateView.vue'),
      },
      {
        path: 'payment-pay',
        name: 'Nạp tiền',
        component: () => import(/* webpackChunkName: "route" */ '@/views/admin/payment/PayView.vue'),
      },
      {
        path: 'payment-withdraw',
        name: 'Rút tiền',
        component: () => import(/* webpackChunkName: "route" */ '@/views/admin/payment/WithdrawView.vue'),
      },
      {
        path: 'shop-recharge',
        name: 'Gói nạp',
        component: () => import(/* webpackChunkName: "route" */ '@/views/admin/shop/RechargeView.vue'),
      },
      {
        path: 'shop-item',
        name: 'Vật phẩm',
        component: () => import(/* webpackChunkName: "route" */ '@/views/admin/shop/ItemView.vue'),
      },
      {
        path: 'shop-currency',
        name: 'Tiền tệ',
        component: () => import(/* webpackChunkName: "route" */ '@/views/admin/shop/CurrencyView.vue'),
      },
      {
        path: 'shop-effect',
        name: 'Hiệu ứng',
        component: () => import(/* webpackChunkName: "route" */ '@/views/admin/shop/EffectView.vue'),
      },
      {
        path: 'activate-news',
        name: 'Tin tức',
        component: () => import(/* webpackChunkName: "route" */ '@/views/admin/activate/NewsView.vue'),
      },
      {
        path: 'activate-event',
        name: 'Sự kiện',
        component: () => import(/* webpackChunkName: "route" */ '@/views/admin/activate/EventView.vue'),
      },
      {
        path: 'activate-mission',
        name: 'Nhiệm vụ',
        component: () => import(/* webpackChunkName: "route" */ '@/views/admin/activate/MissionView.vue'),
      },
      {
        path: 'activate-wheel',
        name: 'Vòng quay',
        component: () => import(/* webpackChunkName: "route" */ '@/views/admin/activate/WheelView.vue'),
      },
      {
        path: 'activate-dice',
        name: 'Xúc xắc',
        component: () => import(/* webpackChunkName: "route" */ '@/views/admin/activate/DiceView.vue'),
      },
      {
        path: 'activate-giftcode',
        name: 'GiftCode',
        component: () => import(/* webpackChunkName: "route" */ '@/views/admin/activate/GiftcodeView.vue'),
      },
      {
        path: 'log-admin',
        name: 'Quản trị viên',
        component: () => import(/* webpackChunkName: "route" */ '@/views/admin/log/AdminView.vue'),
      },
      {
        path: 'log-shop',
        name: 'Cửa hàng',
        component: () => import(/* webpackChunkName: "route" */ '@/views/admin/log/ShopView.vue'),
      },
      {
        path: 'log-event',
        name: 'Sự kiện',
        component: () => import(/* webpackChunkName: "route" */ '@/views/admin/log/EventView.vue'),
      },
      {
        path: 'log-mission',
        name: 'Nhiệm vụ',
        component: () => import(/* webpackChunkName: "route" */ '@/views/admin/log/MissionView.vue'),
      },
      {
        path: 'log-wheel',
        name: 'Vòng quay',
        component: () => import(/* webpackChunkName: "route" */ '@/views/admin/log/WheelView.vue'),
      },
      {
        path: 'log-dice',
        name: 'Xúc xắc',
        component: () => import(/* webpackChunkName: "route" */ '@/views/admin/log/DiceView.vue'),
      },
      {
        path: 'log-giftcode',
        name: 'GiftCode',
        component: () => import(/* webpackChunkName: "route" */ '@/views/admin/log/GiftcodeView.vue'),
      },
    ]
  },

  { path: '*', redirect: { path: '/' } }
]

const router = new VueRouter({
  mode: 'history',
  base: '/client/',
  routes
})

export default router

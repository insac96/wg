<template lang="pug">
  div(class="UserInfo" v-if="storeUser")
    //- Chi Tiết
    UCard(title="Thông tin" class="mb-2")
      UFlex(align="center" justify="space-between" class="mb-2" v-if="storeUser.referraler")
        UText(size="0.85rem") Người giới thiệu
        UChip(icon="referraler" color="referraler") {{ storeUser.referraler.account }}

      UFlex(align="center" justify="space-between" class="mb-2" v-if="storeUser.referral_code")
        UText(size="0.85rem") Mã mời
        UChip(icon="code" color="info" @click="dialog.referral = true") Bấm để xem

      UFlex(align="center" justify="space-between" class="mb-2" v-if="storeUser.referral_code")
        UText(size="0.85rem") Đã giới thiệu
        UChip(icon="user" color="user") {{ storeUser.referral_count }}

      UFlex(align="center" justify="space-between" class="mb-2")
        UText(size="0.85rem") Số điện thoại
        UChip(icon="phone" color="phone" v-if="!!storeUser.phone") {{ storeUser.phone }}
        UChip(icon="phone" color="phone" @click="dialog.phone = true" v-else) Bấm cập nhật

      UFlex(align="center" justify="space-between" class="mb-2")
        UText(size="0.85rem") Ngày đăng nhập
        UChip(icon="bxs-calendar" color="info") {{ storeUser.login_day }}
      
      UFlex(align="center" justify="space-between" class="mb-2")
        UText(size="0.85rem") Hôm nay quay
        UChip(icon="wheel" color="wheel") {{ $utils.getMoney(storeUser.spin_wheel_count, false) }}

      UFlex(align="center" justify="space-between" class="mb-2")
        UText(size="0.85rem") Hiệu ứng
        UChip(icon="bxs-party" color="success" @click="dialog.effect = true") Thay đổi 

      UFlex(align="center" justify="space-between")
        UText(size="0.85rem") Đặc quyền VIP
        UChip(icon="bxl-discord-alt" :color="`vip-${storeUser.vip.number}`" @click="$router.push('/vip')") Bấm để xem

      template(#footer)
        UFlex(justify="space-between" align="center")
          UChip(@click="goToWithdraw") Rút tiền mặt
          UChip(@click="dialog.password = true" full) Đổi mật khẩu

    //- Tiền tệ
    UCard(title="Tiền tệ" class="mb-2")
      UFlex(align="center" justify="space-between" class="mb-2")
        UText(size="0.85rem") Xu
        UChip(icon="coin" color="coin") {{ $utils.getMoney(storeUser.coin, false) }}
      UFlex(align="center" justify="space-between" class="mb-2")
        UText(size="0.85rem") Xu khóa
        UChip(icon="coin_lock" color="coin_lock") {{ $utils.getMoney(storeUser.coin_lock, false) }}
      UFlex(align="center" justify="space-between" class="mb-2")
        UText(size="0.85rem") Kim Cương
        UChip(icon="diamond" color="diamond") {{ $utils.getMoney(storeUser.diamond, false) }}
      UFlex(align="center" justify="space-between")
        UText(size="0.85rem") Lượt quay
        UChip(icon="wheel" color="wheel") {{ $utils.getMoney(storeUser.wheel, false) }}

    //- Nạp tiền
    UCard(title="Nạp tiền" class="mb-2")
      UFlex(align="center" justify="space-between" class="mb-2")
        UText(size="0.85rem") Hôm nay nạp
        UChip(icon="money" color="money") {{ $utils.getMoney(storeUser.pay_day, false) }}
      UFlex(align="center" justify="space-between" class="mb-2")
        UText(size="0.85rem") Tháng này nạp
        UChip(icon="money" color="money") {{ $utils.getMoney(storeUser.pay_month, false) }}
      UFlex(align="center" justify="space-between")
        UText(size="0.85rem") Tổng nạp
        UChip(icon="money" color="money") {{ $utils.getMoney(storeUser.pay_all, false) }}
      template(#footer)
        UFlex(justify="space-between" align="center")
          UChip(@click="$router.push('/history-pay')") Xem lịch sử nạp
          UChip(@click="$router.push('/pay')" full) Nạp thêm

    //- Tiêu phí
    UCard(title="Tiêu phí")
      UFlex(align="center" justify="space-between" class="mb-2")
        UText(size="0.85rem") Hôm nay tiêu
        UChip(icon="coin" color="coin") {{ $utils.getMoney(storeUser.spend_day, false) }}
      UFlex(align="center" justify="space-between" class="mb-2")
        UText(size="0.85rem") Tháng này tiêu
        UChip(icon="coin" color="coin") {{ $utils.getMoney(storeUser.spend_month, false) }}
      UFlex(align="center" justify="space-between")
        UText(size="0.85rem") Tổng tiêu
        UChip(icon="coin" color="coin") {{ $utils.getMoney(storeUser.spend_all, false) }}
      //- template(#footer)
      //-   UFlex(justify="space-between" align="center")
      //-     UChip(@click="notify('Chức năng sắp ra mắt')") Xem lịch sử tiêu phí
      //-     UChip(@click="$router.push('/shop')" full) Tiêu thêm

    //- Dialog - Mã mời
    UDialog(v-model="dialog.referral" @show="makeLink" @hide="")
      UBox(title="Mã mời của tôi" width="100%")
        UFlex(align="center" justify="space-between")
          UText(size="0.85rem") Mã mời
          UChip(icon="code" color="info" class="select-all") {{ storeUser.referral_code }}
        UFlex(align="center" justify="space-between" class="mt-2")
          UText(size="0.85rem" class="mr-2" no-wrap) Link mời
          UChip(icon="bx-link" color="dark" large class="select-all") {{ linkReferral || 'Đang tạo...' }}

    //- Dialog - Đổi mật khẩu
    UDialog(v-model="dialog.password" @hide="close")
      UBox(title="Đổi mật khẩu" width="100%")
        UInput(v-model="update.oldPassword" type="password" icon="password" icon-color="dark" placeholder="Nhập mật khẩu cũ")
        UInput(v-model="update.newPassword" type="password" icon="password" icon-color="password" placeholder="Nhập mật khẩu mới")
        template(#footer)
          UFlex(justify="flex-end")
            UButton(@click="changePassword" color="password") Xác nhận

    //- Dialog - Cập nhật số điện thoại
    UDialog(v-model="dialog.phone" @hide="close")
      UBox(title="Cập nhật số điện thoại" width="100%")
        UInput(v-model="update.phone" icon="phone" icon-color="phone" placeholder="Nhập số điện thoại")
        template(#footer)
          UFlex(justify="flex-end")
            UButton(@click="updateAuthPhone" color="phone") Xác nhận

    //- Dialog - Cập nhật thông tin ngân hàng
    UDialog(v-model="dialog.bank" @hide="close" v-if="!storeUser.bank_name")
      UBox(title="Cập nhật thông tin ngân hàng" width="100%")
        UInput(v-model="update.bank.name" icon="gate" icon-color="primary" placeholder="Tên ngân hàng")
        UInput(v-model="update.bank.person" icon="user" icon-color="user" placeholder="Chủ tài khoản")
        UInput(v-model="update.bank.stk" icon="code" icon-color="password" placeholder="Số tài khoản")
        template(#footer)
          UFlex(justify="flex-end")
            UButton(@click="updateAuthBank") Xác nhận

    //- Dialog - Cập nhật hiệu ứng
    UDialog(v-model="dialog.effect" @hide="close" @show="getAllUserEffect")
      UBox(title="Thay đổi hiệu ứng" width="100%" v-if="userEffect")
        USelect(v-model="update.effect" :list="userEffect" value="type" label="name" icon="bxs-party" icon-color="success")
        template(#footer)
          UFlex(justify="flex-end")
            UButton(@click="updateUserEffect" color="success") Xác nhận
</template>

<script>
export default {
  data () {
    return {
      dialog: {
        password: false,
        referral: false,
        phone: false,
        bank: false,
        effect: false
      },

      linkReferral: null,

      userEffect: null,

      update: {
        oldPassword: null,
        newPassword: null,
        phone: null,
        bank: {
          name: null,
          person: null,
          stk: null
        },
        effect: null
      }
    }
  },

  computed: {
    async makeLink () {
      if(!this.isLogin) return null
      if(!this.storeConfig) return null
      if(!this.storeUser) return null

      const code = this.storeUser.referral_code || null
      const weblink = this.storeConfig.web_link || null

      if(!code || !weblink) return null
      const originalLink = `${weblink}/client/referral/${code}`
      const apiUrl = `https://api.shrtco.de/v2/shorten?url=${originalLink}`;

      try {
        const response = await fetch(apiUrl);
        const data = await response.json();
        const link = data.result.full_short_link;
        this.linkReferral = link

      } catch (e) {
        this.linkReferral = originalLink
      }
    }
  },

  methods: {
    goToWithdraw () {
      if(!this.storeUser) return
      if(!!this.storeUser.bank_name) return this.$router.push('/withdraw')
      this.dialog.bank = true
      this.notify('Vui lòng cập nhật thông tin ngân hàng trước')
      
    },

    async updateAuthPhone () {
      if(!this.update.phone) return this.notify('Vui lòng nhập đầy đủ thông tin')
      
      const update = await this.API('updateAuthPhone', {
        phone: this.update.phone
      })

      if(!update) return
      this.getUser()
      this.close()
    },

    async updateAuthBank () {
      if(
        !this.update.bank.name 
        || !this.update.bank.person
        || !this.update.bank.stk
      ) return this.notify('Vui lòng nhập đầy đủ thông tin')

      const update = await this.API('updateAuthBank', this.update.bank)

      if(!update) return 
      this.getUser()
      this.close()
    },

    async changePassword () {
      if(
        !this.update.oldPassword 
        || !this.update.newPassword
      ) return this.notify('Vui lòng nhập đầy đủ thông tin')

      const change = await this.API('changePassword', {
        old_password: this.update.oldPassword,
        password: this.update.newPassword
      })

      if(!change) return
      this.logout()
    },

    async getAllUserEffect () {
      this.update.effect = this.storeUser.effect
      const list = await this.API('getAllUserEffect')
      if(!list) return

      const defaultList = [{ id: 0, name: 'Theo cấp VIP', type: 'vip' }]
      this.userEffect = defaultList.concat(list)
    },

    async updateUserEffect () {
      if(!this.update.effect) return this.notify('Vui lòng chọn hiệu ứng trước')

      const update = await this.API('updateUserEffect', {
        effect_type: this.update.effect
      })
      if(!update) return 
      this.getUser()
      this.close()
    },

    close () {
      this.update = {
        oldPassword: null,
        newPassword: null,
        phone: null,
        bank: {
          name: null,
          person: null,
          stk: null
        },
        effect: null
      }

      this.dialog = {
        password: false,
        referral: false,
        phone: false,
        bank: false,
        effect: false
      }
    }
  },
}
</script>
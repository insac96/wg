<template lang="pug">
  div(class="ManageUserView")
    UTableAdmin(
      :head="head"
      :reload="reload"
      :select.sync="select"
      get-action="getAllUser"
      search-action="searchUser"
      first-sort="create_time"
      action-one
      action-three
      @one="updateUserAuth"
      @three="updateUserInfo"
      @open-three="openAdd"
      @select-data="openUserInfo"
    )
      template(#one v-if="select")
        UInput(v-model="select.account" label-top="Tài khoản" disabled)
        UInput(v-model="password" label-top="Mật khẩu mới" type="password")
        UInput(v-model="select.phone" label-top="Số điện thoại")
        USelect(v-model="select.block" label-top="Khóa" :list="blockVal")
        USelect(v-model="select.type_user" label-top="Quyền" :list="typeVal")

      template(#three v-if="select")
        UInput(v-model="addVal.account" label-top="Tài khoản" disabled)
        UInput(v-model="addVal.coin" label-top="Thêm Xu" type="number")
        UInput(v-model="addVal.coin_lock" label-top="Thêm Xu Khóa" type="number")
        UInput(v-model="addVal.diamond" label-top="Thêm Kim Cương" type="number")
        UInput(v-model="addVal.wheel" label-top="Thêm Lượt Quay" type="number")
        UInput(v-model="addVal.reason" label-top="Lý do")

    transition(name="up")
      UserInfo(:user="selectUserInfo" v-if="selectUserInfo" @reload="onReload" class="mt-2")
</template>

<script>
import UserInfo from  '@/components/admin/user/index.vue'

export default {
  components: {
    UserInfo
  },

  data() {
    return {
      head: {
        'id': 'ID',
        'account': 'Tên',
        'vip': 'VIP',
        'pay_all': 'Tổng nạp',
        'referraler': 'Người giới thiệu',
        'referral_count': 'Mời',
        'block': 'Khóa',
        'type_user': 'Quyền',
        'create_time': 'Đăng ký'
      },
      select: null,
      
      reload: 0,

      blockVal: [
        { value: 0, label: 'Không' },
        { value: 1, label: 'Có' },
      ],

      typeVal: [
        { value: 0, label: 'MEMBER' },
        { value: 1, label: 'SMOD' },
        { value: 2, label: 'ADMIN' },
      ],

      password: null,

      addVal: {
        account: null,
        coin: 0,
        coin_lock: 0,
        diamond: 0,
        wheel: 0,
        reason: 'ADMIN'
      },

      selectUserInfo: null,
    }
  },

  methods: {
    async updateUserAuth () {
      this.select.password = this.password
      const update = await this.API('updateUserAuth', this.select, true)
      if(!!update) return this.onReload()
    },

    async updateUserInfo () {
      const update = await this.API('updateUserInfo', this.addVal, true)
      if(!!update) return this.selectUserInfo = null, this.onReload()
    },

    openAdd () {
      if(!this.select) return
      this.addVal.account = this.select.account
    },

    openUserInfo (data) {
      this.selectUserInfo = null
      setTimeout(() => this.selectUserInfo = data, 1)
    },

    onReload () {
      this.reload = this.reload + 1
      this.password = null
      this.addVal = {
        account: null,
        coin: 0,
        coin_lock: 0,
        diamond: 0,
        wheel: 0,
        reason: 'ADMIN'
      }
    }
  },
}
</script>
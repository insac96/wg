<template lang="pug">
  div(class="ManageUserInfo" v-if="user")
    UTab(:list="list" v-model="tab")

    transition(name="up" mode="out-in")
      UserInfo(v-if="tab == 'info'" :user="user" @reload="onReload")
      UserIP(v-if="tab == 'ip'" :user="user")
      UserReferral(v-if="tab == 'referral'" :user="user")
      UserMission(v-if="tab == 'mission'" :user="user" @reload="onReload")
</template>

<script>
import UserInfo from '@/components/admin/user/Info.vue'
import UserIP from '@/components/admin/user/IP.vue'
import UserReferral from '@/components/admin/user/Referral.vue'
import UserMission from '@/components/admin/user/Mission.vue'

export default {
  components: {
    UserInfo,
    UserIP,
    UserReferral,
    UserMission
  },

  props: {
    user: { type: Object },
    reload: { type: Number }
  },

  data() {
    return {
      tab: 'info',
      list: [
        { value: 'info', label: this.user ? this.user.account.toUpperCase() : 'Thông tin' },
        { value: 'ip', label: 'Địa chỉ IP' },
        { value: 'referral', label: 'Giới thiệu' },
        { value: 'mission', label: 'Nhiệm vụ' }
      ]
    }
  },

  methods: {
    onReload () {
      this.$emit('reload')
    }
  },
}
</script>
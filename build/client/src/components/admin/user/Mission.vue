<template lang="pug">
  UFlex(justify="center")
    UCard(class="box-resize-50" title="Cập nhật nhiệm vụ" v-if="selectUser")
      USelect(v-model="selectUser.join_group" label-top="Group Facebook" :list="missionVal")
      USelect(v-model="selectUser.join_zalo" label-top="Group Zalo" :list="missionVal")
      USelect(v-model="selectUser.join_telegram" label-top="Group Telegram" :list="missionVal")
      USelect(v-model="selectUser.share_web" label-top="Share Website" :list="missionVal")
      template(#footer)
        UFlex(align="center" justify="flex-end")
          UButton(color="primary" class="mr-1" @click="updateUserMission") Lưu
</template>

<script>
export default {
  props: {
    user: { type: Object }
  },

  data() {
    return {
      selectUser: JSON.parse(JSON.stringify(this.user)),
      missionVal: [
        { value: 0, label: 'Chưa hoàn thành' },
        { value: 1, label: 'Hoàn thành' },
      ]
    }
  },
  
  watch: {
    user (val) {
      this.selectUser = JSON.parse(JSON.stringify(val))
    }
  },

  methods: {
    async updateUserMission () {
      if(!this.selectUser) return this.notify('Vui lòng chọn tài khoản trước');
      const update = await this.API('updateUserMission', this.selectUser, true)
      if(!update) return 
      this.$emit('reload')
    },
  },
}
</script>
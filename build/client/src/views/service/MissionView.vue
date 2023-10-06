<template lang="pug">
  div(class="MissionView" v-if="list")
    UAlert(border color="mission" v-if="list.length == 0") Chưa có nhiệm vụ nào khả dụng, vui lòng quay lại sau

    UFlex(wrap="wrap" align="center")
      UBox(
        v-for="item in list"
        :key="item.id"
        :title="item.name"
        class="box-resize"
        @click="setMission(item)"
      )
        UFlex(justify="center")
          img(
            :src="`${publicPath}images/mission/default.png`" 
            :alt="item.name" 
            width="70%" 
            height="auto"
          )
        template(#footer)
          UFlex(justify="center")
            UChip(color="time" border v-if="!$utils.getExpires(item.expires_time).active || !isLogin") {{ $utils.getExpires(item.expires_time).text }}
            UChip(
              v-if="!!$utils.getExpires(item.expires_time).active && !!isLogin"
              :color="typeColor[item.active.type]"
              full
            ) {{ item.active.text }}

    UDialog(v-model="dialog")
      UBox(width="100%" title="Thông tin" v-if="missionSelect")
        SelectServer(v-model="serverSelect" class="mb-2" v-if="missionSelect.active.type == 2")  
        UFlex(align="center" justify="space-between" class="mb-2")
          UText(size="0.85rem") Nhiệm vụ
          UChip() {{missionSelect.name}}  
        UFlex(align="center" justify="space-between" class="mb-2")
          UText(size="0.85rem") Điều kiện
          UChip() {{missionSelect.info}}
        UFlex(align="center" justify="space-between" class="mb-2")
          UText(size="0.85rem") Phần thưởng
          UChip(v-if="$utils.getGifts(missionSelect.gifts).length == 0") Chưa cập nhật
          UFlex(v-else wrap="wrap")
            UItem(v-for="(gift, index) in $utils.getGifts(missionSelect.gifts)" :key="index" :item="gift")

        template(#footer)
          UFlex(align="center" justify="flex-end" v-if="missionSelect.active.type == 2")
            UButton(color="success" @click="receiveMission" class="mr-1") Nhận
            UButton(color="gray" @click="cancel") Không
          UFlex(align="center" justify="flex-end" v-if="missionSelect.active.type != 2")
            UButton(color="gray" @click="cancel") Đóng
</template>

<script>
export default {
  data() {
    return {
      list: null,
      missionSelect: null,
      serverSelect: null,
      dialog: false,
      typeColor: {
        '-1': 'gray',
        '0': 'gray',
        '1': 'danger',
        '2': 'primary',
        '3': 'success'
      }
    }
  },

  created () {
    this.getAllMission()
  },

  methods: {
    async getAllMission () {
			const list = await this.API('getAllMission')
      if(!list) return
      this.list = list
		},

    async receiveMission () {
      if(!this.serverSelect) return this.notify('Vui lòng chọn máy chủ trước')

      const receive = await this.API('receiveMission', {
        mission_id: this.missionSelect.id,
        server_id: this.serverSelect
      })

      if(!receive) return
      this.cancel()
      this.getAllMission()
    },

    setMission (mission) {
      if(!this.isLogin) return this.notify('Vui lòng đăng nhập trước')
      this.missionSelect = mission
      this.dialog = true
    },

    cancel () {
      this.dialog = false
      this.missionSelect = null
      this.serverSelect = null
    },
  },
}
</script>
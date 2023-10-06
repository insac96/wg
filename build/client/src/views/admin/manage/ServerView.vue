<template lang="pug">
  div(class="ServerListView")
    UTableAdmin(
      :head="head"
      :reload="reload"
      :select.sync="select"
      get-action="getAllServer"
      first-sort="id"
      action-two
      @two="deleteServer"
      text-two="Xóa"
      @select-data="openServerInfo"
    )
      template(#header)
        UButton(class="ml-auto" color="dark" @click="syncServer") Đồng bộ
      template(#two v-if="select")
        UAlert(color="danger" border class="mb-2") Bạn chắc chắn muốn xóa máy chủ này

    transition(name="up")
      ServerInfo(:server="selectServerInfo" v-if="selectServerInfo" class="mt-2")
</template>

<script>
import ServerInfo from  '@/components/admin/server/index.vue'

export default {
  components: {
    ServerInfo
  },

  data() {
    return {
      head: {
        'server_id': 'ID',
        'server_name': 'Tên máy chủ',
        'db_name': 'Dữ liệu',
        'update_time': 'Cập nhật'
      },

      select: null,

      selectServerInfo: null,

      reload: 0
    }
  },

  methods: {
    async syncServer () {
      const sync = await this.API('syncServer', null, true)
      if(!!sync) return this.onReload()
    },

    async deleteServer () {
      const stop = await this.API('deleteServer', {
        server_id: this.select.server_id
      }, true)
      if(!!stop) return this.selectServerInfo = null, this.onReload()
    },

    openServerInfo (data) {
      this.selectServerInfo = null
      setTimeout(() => this.selectServerInfo = data, 1)
    },

    onReload () {
      this.reload = this.reload + 1
    }
  },
}
</script>
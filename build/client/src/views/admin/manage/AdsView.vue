<template lang="pug">
  div(class="ManageAdsView")
    UTableAdmin(
      :head="head"
      :reload="reload"
      :select.sync="select"
      get-action="getAllAds"
      first-sort="create_time"
      action-create
      action-one
      @create="createAds"
      @one="updateAds"
      @select-data="openAdsInfo"
    )
      template(#create)
        UInput(v-model="addVal.name" label-top="Tên quảng cáo")
        USelect(v-model="addVal.type" :list="typeVal" label-top="Loại quảng cáo")
        USelect(v-model="addVal.display" :list="displayVal" label-top="Hiển thị")

      template(#one v-if="select")
        UInput(v-model="select.name" label-top="Tên quảng cáo")
        USelect(v-model="select.type" :list="typeVal" label-top="Loại quảng cáo")
        USelect(v-model="select.display" :list="displayVal" label-top="Hiển thị")

    transition(name="up")
      AdsInfo(:ads="selectAdsInfo" v-if="selectAdsInfo" @reload="onReload" class="mt-2")
</template>

<script>
import AdsInfo from  '@/components/admin/ads/index.vue'

export default {
  components: {
    AdsInfo
  },

  data() {
    return {
      head: {
        'id': 'ID',
        'name': 'Tên',
        'type': 'Loại',
        'display': 'Hiển thị',
        'create_time': 'Ngày tạo'
      },

      select: null,

      selectAdsInfo: null,

      reload: 0,

      addVal: {
        name: null,
        type: null,
        display: 1
      },

      typeVal: [
        { value: 'facebook', label: 'Facebook' },
        { value: 'messenger', label: 'Messenger' },
        { value: 'zalo', label: 'Zalo' },
        { value: 'google', label: 'Google' },
        { value: 'telegram', label: 'Telegram' },
        { value: 'web', label: 'Web' },
      ],

      displayVal: [
        { value: 0, label: 'Ẩn' },
        { value: 1, label: 'Hiện' },
      ]
    }
  },

  methods: {
    async createAds () {
      const create = await this.API('createAds', this.addVal, true)
      if(!!create) return this.onReload()
    },

    async updateAds () {
      const update = await this.API('updateAds', this.select, true)
      if(!!update) return this.onReload()
    },

    openAdsInfo (data) {
      this.selectAdsInfo = null
      setTimeout(() => this.selectAdsInfo = data, 1)
    },

    onReload () {
      this.reload = this.reload + 1
      this.addVal = {
        name: null,
        type: null,
        display: 1
      }
    }
  },
}
</script>
<template lang="pug">
  div(class="RankView")
    UCard(title="Xếp Hạng" class="mb-2")
      SelectServer(v-model="server_id" class="mb-2" no-role)  
      USelect(v-model="type" :list="typeView" icon-color="rank" icon="rank" placeholder="Chọn loại xếp hạng")
      template(#footer)
        UFlex(justify="flex-end")
          UButton(@click="getServerRank") Xem

    transition(name="up")
      div(v-if="!!get")
        //- Tabs
        UTab(:list="tabs" v-model="tab" class="mb-2")
        
        //- Ranks
        UTable(v-if="ranks && tab == 'ranks'" :no-data="ranks.length == 0")
          template(#head)
            tr
              th Hạng
              th Nhân Vật
              th {{ type == 'power' ? 'Lực chiến' : 'Cấp độ' }}
          template(#default)
            tr(v-for="item in ranks" :key="item.rank")
              td
                UChip() {{ item.rank }}
              td
                UChip() {{ item.role_name }}
              td
                UChip() {{ type == 'power' ? $utils.getMoney(item.power, false) : item.level }}

        //- Gifts
        UTable(v-if="gifts && tab == 'gifts'" :no-data="gifts.length == 0")
          template(#head)
            tr
              th Hạng
              th Phần thưởng
          template(#default)
            tr(v-for="item in gifts" :key="item.id")
              td
                UChip() {{ item.min == item.max ? item.min : `${item.min}-${item.max}` }}
              td
                UChip(v-if="getGift(item.gifts).length == 0") Chưa cập nhật
                UItem(v-for="(gift, iGift) in getGift(item.gifts)" :key="iGift" :item="gift")
</template>

<script>
export default {
  name: 'GiftCodeView',

  data() {
    return {
      type: null,
      server_id: null,
      ranks: null,
      gifts: null,
      get: false,

      tab: 'ranks',
      tabs: [
        { value: 'ranks', label: 'Xếp Hạng' },
        { value: 'gifts', label: 'Phần thưởng' },
      ],

      typeView: [
        { label: 'TOP Lực Chiến', value: 'power' },
        { label: 'TOP Cấp Độ', value: 'level' }
      ],
    }
  },

  watch: {
    server_id () {
      this.get = false
    },
    type () {
      this.get = false
    },
  },

  methods: {
    async getServerRank () {
      if(!this.server_id) return this.notify('Vui lòng chọn máy chủ')
      if(!this.type) return this.notify('Vui lòng chọn loại xếp hạng')
      const get = await this.API('getServerRank', {
        type: this.type,
        server_id: this.server_id
      })

      if(!get) return

      this.get = false
      setTimeout(() => {
        this.get = true
        this.ranks = get.ranks
        this.gifts = get.gifts
      }, 1)
      
    },

    getGift (data) {
      return JSON.parse(data)
    }
  },
}
</script>
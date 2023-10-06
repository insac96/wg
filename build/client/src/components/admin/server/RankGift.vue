<template lang="pug">
  div(class="ManageServerRankGift")
    UTableAdmin(
      :head="head"
      :reload="reload"
      :select.sync="select"
      get-action="getAllServerRankGift"
      :plus-get="plus"
      first-sort="min"
      action-create
      action-one
      action-two
      action-three
      @create="createServerRankGift"
      @one="updateServerRankGift"
      @two="deleteServerRankGift"
      @three="updateServerRankGift"
      @open-one="openEdit"
      @open-three="openEdit"
    )
      template(#header)
        USelect(v-model="plus.type" :list="typeView" icon="bx-gift" icon-color="primary" placeholder="Chọn loại phần thưởng" size="40px" class="mb-0")

      template(#create)
        UInput(v-model="addVal.min" label-top="Hạng nhỏ nhất" type="number")
        UInput(v-model="addVal.max" label-top="Hạng lớn nhất" type="number")

      template(#one v-if="select")
        UInput(v-model="select.min" label-top="Hạng nhỏ nhất" type="number")
        UInput(v-model="select.max" label-top="Hạng lớn nhất" type="number")

      template(#two v-if="select")
        UAlert(color="danger" border) Bạn chắc chắn muốn xóa quà xếp hạng này?
        
      template(#three v-if="select")
        UGiftAdmin(:gifts.sync="select.gifts")
</template>

<script>
export default {
  props: {
    server: { type: Object }
  },

  data() {
    return {
      head: {
        'min': 'Hạng nhỏ nhất',
        'max': 'Hạng lớn nhất',
        'gifts': 'Phần thưởng',
      },

      select: null,

      reload: 0,

      plus: {
        type: 'spend',
        server_id: this.server.server_id
      },

      typeView: [
        { label: 'TOP Tiêu Phí', value: 'spend' },
        { label: 'TOP Lực Chiến', value: 'power' },
        { label: 'TOP Cấp Độ', value: 'level' }
      ],

      addVal: {
        server_id: null,
        min: null,
        max: null,
        gifts: []
      }
    }
  },

  watch: {
    'plus.type' () {
      this.onReload()
    }
  },

  methods: {
    async createServerRankGift () {
      if(!this.server) return
      const addVal = JSON.parse(JSON.stringify(this.addVal))
      addVal.server_id = this.server.server_id
      addVal.type = this.plus.type
      addVal.gifts = JSON.stringify(addVal.gifts)
      const create = await this.API('createServerRankGift', addVal, true)
      if(!!create) return this.onReload()
    },

    async updateServerRankGift () {
      if(!this.select) return
      const select = JSON.parse(JSON.stringify(this.select))
      select.gifts = JSON.stringify(select.gifts)
      const update = await this.API('updateServerRankGift', select, true)
      if(!!update) return this.onReload()
    },

    async deleteServerRankGift () {
      if(!this.select) return
      const del = await this.API('deleteServerRankGift', {
        rank_gift_id: this.select.id
      }, true)
      if(!!del) return this.onReload()
    },

    openEdit () {
      if(!this.select) return
      this.select.gifts = JSON.parse(this.select.gifts)
    },

    onReload () {
      this.reload = this.reload + 1
      this.addVal = {
        server_id: null,
        min: null,
        max: null,
        gifts: []
      }
    }
  },
}
</script>
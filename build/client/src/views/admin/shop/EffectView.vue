<template lang="pug">
  div(class="ShopEffectView")
    UTableAdmin(
      :head="head"
      :reload="reload"
      :select.sync="select"
      get-action="getAllShopEffect"
      first-sort="update_time"
      action-one
      @one="updateShopEffect"
    )
      template(#one v-if="select")
        UInput(v-model="select.name" label-top="Tên hiệu ứng")
        UInput(v-model="select.price" label-top="Giá mua" type="number")
        USelect(v-model="select.display" :list="displayVal" label-top="Hiển thị")
</template>

<script>
export default {
  data() {
    return {
      head: {
        'id': 'ID',
        'name': 'Tên',
        'price': 'Giá mua',
        'display': 'Hiển thị',
        'update_time': 'Cập nhật'
      },

      select: null,

      reload: 0,

      displayVal: [
        { value: 0, label: 'Ẩn' },
        { value: 1, label: 'Hiện' },
      ],

      typeVal: [
        { value: 'coin', label: 'Xu' },
        { value: 'coin_lock', label: 'Xu Khóa' },
        { value: 'diamond', label: 'Kim Cương' },
        { value: 'wheel', label: 'Lượt Quay' },
      ]
    }
  },

  methods: {
    async updateShopEffect () {
      const update = await this.API('updateShopEffect', this.select, true)
      if(!!update) return this.onReload()
    },

    onReload () {
      this.reload = this.reload + 1
    }
  },
}
</script>
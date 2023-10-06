<template lang="pug">
  div(class="UGiftAdmin")
    UFlex(align="center" class="mb-2")
      USelect(v-if="dbGift && dbGift.length > 0" v-model="selectDbGift" :list="dbGift" label="name" value="list" placeholder="Chọn bộ quà tặng có sẵn" icon="bx-gift" icon-color="primary" class="mb-0")
      UButton(@click="dialog.add = true" class="ml-auto") Thêm

    UTable(v-if="list" :no-data="list.length == 0")
      template(#head)
        tr
          th ID
          th(v-if="!send") Tên
          th Số lượng
          th Chức năng
      template(#default)
        tr(v-for="(item, index) in list" :key="index")
          td
            UChip() {{ item.id }}
          td(v-if="!send")
            UChip(large) {{ item.name }}
          td
            UChip() {{ $utils.getMoney(item.amount) }}
          td
            UFlex(align="center")
              UChip(full color="info" class="mr-1" @click="selectEdit(item)") Sửa
              UChip(full color="danger" @click="removeGift(index)") Xóa

    UDialog(v-model="dialog.add" max="500px")
      UBox(:title="`Thêm ${title}`" width="100%")
        UInput(v-model="addVal.id" label-top="ID Vật phẩm")
        UInput(v-model="addVal.name" label-top="Tên vật phẩm" v-if="!send")
        UInput(v-model="addVal.amount" label-top="Số lượng")
        UInput(v-model="addVal.icon" label-top="Mã Icon nếu có" v-if="!send")
        template(#footer)
          UFlex(align="center" justify="flex-end")
            UButton(color="danger" @click="addGift") Thực Hiện
            UButton(color="dark" @click="cancel") Hủy Bỏ

    UDialog(v-model="dialog.edit" max="500px")
      UBox(:title="`Sửa ${title}`" v-if="select" width="100%")
        UInput(v-model="select.id" label-top="ID Vật phẩm")
        UInput(v-model="select.name" label-top="Tên vật phẩm" v-if="!send")
        UInput(v-model="select.amount" label-top="Số lượng")
        UInput(v-model="select.icon" label-top="Mã Icon nếu có" v-if="!send")
        template(#footer)
          UFlex(align="center" justify="flex-end")
            UButton(color="danger" @click="editGift") Thực Hiện
            UButton(color="dark" @click="cancel") Hủy Bỏ
</template>

<script>
export default {
  props: {
    gifts: { type: Array },
    send: { type: Boolean },
    title: { type: String, default: 'Phần thưởng' }
  },

  data() {
    return {
      select: null,
      list: null,

      selectDbGift: null,
      dbGift: null,
      
      addVal: {
        id: null,
        name: null,
        amount: null,
        icon: null
      },

      dialog: {
        add: false,
        edit: false
      }
    }
  },

  watch: {
    selectDbGift (val) {
      if(!val) return
      
      const nowList = JSON.parse(JSON.stringify(this.list))
      const jsonVal = JSON.parse(val)

      if(!this.list){
        this.list = jsonVal
      }
      else {
        this.list = [...nowList, ...jsonVal];
      }
      
      this.done()
      this.selectDbGift = null
    }
  },

  created() {
    this.list = JSON.parse(JSON.stringify(this.gifts))
    this.getAllGiftSelect()
  },

  methods: {
    selectEdit (gift) {
      this.select = gift
      this.dialog.edit = true
    },

    async getAllGiftSelect () {
      const dbGift = await this.API('getAllGiftSelect', null, true)
      if(!!dbGift) return this.dbGift = dbGift
    },

    addGift () {
      if(!!this.send){
        if(!this.addVal.id || !this.addVal.amount) return this.notify('Vui lòng nhập đầy đủ')
      }
      else {
        if(!this.addVal.id || !this.addVal.name || !this.addVal.amount) return this.notify('Vui lòng nhập đầy đủ')
      }
      this.list.push(this.addVal)
      this.done()
    },

    editGift () {
      if(!!this.send){
        if(!this.select.id || !this.select.amount) return this.notify('Vui lòng nhập đầy đủ')
      }
      else {
        if(!this.select.id || !this.select.name || !this.select.amount) return this.notify('Vui lòng nhập đầy đủ')
      }

      const index = this.list.findIndex(i => i.id == this.select.id)
      if(index == -1) return this.notify('Lỗi dữ liệu')

      this.list[index] = this.select
      this.done()
    },

    removeGift (index) {
      this.$delete(this.list, index)
      this.done()
    },

    done () {
      this.$emit('update:gifts', this.list)
      this.cancel()
    },

    cancel () {
      this.select = null

      this.dialog.add = false
      this.dialog.edit = false
      
      this.addVal = {
        id: null,
        name: null,
        amount: null,
        icon: null
      }
    }
  },
}
</script>
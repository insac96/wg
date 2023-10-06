<template lang="pug">
  UFlex(justify="center" class="ActionSocketView")
    div(class="box-resize-50")
      UCard(title="Cài đặt Chat")
        UFlex(align="center" class="mb-2")
          UInput(v-model="pin" icon="bxs-cat" icon-color="primary" placeholder="Nhập nội dung ghim" width="100%" height="35px" class="mb-0 mr-1")
          UButton(@click="updatePin" height="35px") Lưu
        UFlex(align="center" justify="space-between" class="mb-2")
          UText(size="0.85rem") Xóa ghim
          UChip(@click="resetPin" color="danger" full) Bấm để xóa
        UFlex(align="center" justify="space-between")
          UText(size="0.85rem") Xóa toàn bộ tin nhắn
          UChip(@click="resetChats" color="danger" full) Bấm để xóa
</template>

<script>
export default {
  data() {
    return {
      pin: null
    }
  },
  methods: {
    updatePin () {
      this.$socket.emit('update-pin', this.pin)
      this.notify('Cập nhật thành công', 'success')
    },
    resetPin () {
      this.$socket.emit('reset-pin')
      this.notify('Xóa thành công', 'success')
    },
    resetChats () {
      this.$socket.emit('reset-chats')
      this.notify('Xóa thành công', 'success')
    }
  },
}
</script>
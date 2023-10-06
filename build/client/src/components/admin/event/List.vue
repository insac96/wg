<template lang="pug">
  div(class="ActivateEventListView")
    UTableAdmin(
      :head="head"
      :reload="reload"
      :select.sync="select"
      get-action="getAllEvent"
      first-sort="update_time"
      action-create
      action-one
      action-two
      @create="createEvent"
      @one="updateEvent"
      @two="deleteEvent"
      @open-one="openEdit"
      @select-data="selectEvent"
    )
      template(#create)
        USelect(v-model="addVal.type" :list="typeVal" label-top="Loại sự kiện")
        UInput(v-model="addVal.name" label-top="Tên sự kiện")
        UFlex(align="center" justify="space-between" full class="mb-2")
          USelect(v-model="addVal.milestone_type" :list="milestoneTypeVal" label-top="Kiểu dữ liệu mốc thưởng" width="49%" class="mb-0")
          USelect(v-model="addVal.comparison" :list="comparisonVal" label-top="Phép so sánh" width="49%")
        UFlex(align="center" justify="space-between" full class="mb-2")
          UInput(v-model="addVal.prefix" label-top="Tiền tố đầu" no-icon width="49%" class="mb-0")
          UInput(v-model="addVal.suffix" label-top="Tiền tố cuối" no-icon width="49%")
        UFlex(align="center" justify="space-between" full class="mb-2")
          UInput(v-model="addVal.expires_time.date" label-top="Ngày hết hạn" type="date" no-icon width="49%" class="mb-0")
          UInput(v-model="addVal.expires_time.time" label-top="Thời gian hết hạn" type="time" no-icon width="49%")
        USelect(v-model="addVal.display" :list="displayVal" label-top="Hiển thị")

      template(#one v-if="select")
        USelect(v-model="select.type" :list="typeVal" label-top="Loại sự kiện")
        UInput(v-model="select.name" label-top="Tên sự kiện")
        UFlex(align="center" justify="space-between" full class="mb-2")
          USelect(v-model="select.milestone_type" :list="milestoneTypeVal" label-top="Kiểu dữ liệu mốc thưởng" width="49%" class="mb-0")
          USelect(v-model="select.comparison" :list="comparisonVal" label-top="Phép so sánh" width="49%")
        UFlex(align="center" justify="space-between" full class="mb-2")
          UInput(v-model="select.prefix" label-top="Tiền tố đầu" no-icon width="49%" class="mb-0")
          UInput(v-model="select.suffix" label-top="Tiền tố cuối" no-icon width="49%")
        UFlex(align="center" justify="space-between" full class="mb-2")
          UInput(v-model="select.expires_time.date" label-top="Ngày hết hạn" type="date" no-icon width="49%" class="mb-0")
          UInput(v-model="select.expires_time.time" label-top="Thời gian hết hạn" type="time" no-icon width="49%")
        USelect(v-model="select.display" :list="displayVal" label-top="Hiển thị")

      template(#two v-if="select")
        UAlert(color="danger" border) Bạn chắc chắn muốn xóa sự kiện [{{select.name}}] khỏi danh sách ?
</template>

<script>
export default {
  props: {
    event: { type: Object }
  },

  data() {
    return {
      head: {
        'id': 'ID',
        'name': 'Tên',
        'type': 'Loại nhiệm vụ',
        'milestone_type': 'Kiểu mốc thưởng',
        'comparison': 'Phép so sánh',
        'display': 'Hiển thị',
        'expires_time': 'Thời hạn',
        'update_time': 'Cập nhật'
      },

      select: null,

      reload: 0,

      addVal: {
        name: null,
        info: null,
        type: null,
        milestone_type: null,
        comparison: null,
        prefix: null,
        suffix: null,
        expires_time: {
          date: null,
          time: null
        },
        display: 1
      },

      typeVal: [
        { value: 'login_day', label: 'Số Ngày Đăng Nhập' },
        { value: 'spend_day', label: 'Tiêu Xu Ngày' },
        { value: 'spend_month', label: 'Tiêu Xu Tháng' },
        { value: 'spend_all', label: 'Tiêu Xu Tổng' },
        { value: 'pay_day', label: 'Tích Nạp Ngày' },
        { value: 'pay_month', label: 'Tích Nạp Tháng' },
        { value: 'pay_all', label: 'Tích Nạp Tổng' },
      ],

      comparisonVal: [
        { value: '>', label: 'Lớn hơn' },
        { value: '<', label: 'Nhỏ hơn' },
        { value: '>=', label: 'Lớn hơn hoặc bằng' },
        { value: '<=', label: 'Nhỏ hơn hoặc bằng' },
        { value: '=', label: 'So sánh bằng' },
      ],

      milestoneTypeVal: [
        { value: 'number', label: 'Số' },
        { value: 'time', label: 'Thời gian' },
        { value: 'money', label: 'Tiền, Xu' },
      ],

      displayVal: [
        { value: 0, label: 'Ẩn' },
        { value: 1, label: 'Hiện' },
      ]
    }
  },

  methods: {
    async createEvent () {
      const create = await this.API('createEvent', this.addVal, true)
      if(!!create) return this.onReload()
    },

    async updateEvent () {
      const update = await this.API('updateEvent', this.select, true)
      if(!!update) return this.onReload()
    },

    async deleteEvent () {
      const del = await this.API('deleteEvent', {
        event_id: this.select.id
      }, true)
      if(!!del) return this.onReload()
    },

    selectEvent (event) {
      this.$emit('update:event', null)
      setTimeout(() => {
        this.$emit('update:event', event)
      }, 1);
    },

    openEdit () {
      if(!this.select) return
      const expires_time = this.select.expires_time
      const time = this.$utils.getTime(expires_time)

      this.select.expires_time = {
        date: expires_time != 0 ? time.dateInput : null,
        time: expires_time != 0 ? time.timeInput : null
      }
    },

    onReload () {
      this.reload = this.reload + 1
      this.addVal = {
        name: null,
        info: null,
        type: null,
        milestone_type: null,
        comparison: null,
        prefix: null,
        suffix: null,
        expires_time: {
          date: null,
          time: null
        },
        display: 1
      }
    }
  },
}
</script>
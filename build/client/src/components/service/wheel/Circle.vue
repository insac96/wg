<template lang="pug">
  UCard(class="WheelCircle" title="Vòng quay may mắn")
    template(#header v-if="isLogin")
      UFlex(justify="space-between" align="center")
        UText(weight="600") Vòng quay may mắn
        UChip(full @click="dialog.server = true")
          span(v-if="!server_id") Chọn máy chủ
          p(v-else) 
            span Máy chủ 
            span(class="uppercase") {{ server_id }}

    div(:class="{'Wheel': true, 'Wheel--spin': !!this.spin }" :style="{'--ui-circle-deg': `${this.now}deg`}")
      div(class="Circle" ref="circle")
        div(class="Gift" v-for="(item, index) in list" :key="item.id" :style="styleGift(index)")
          div(class="Gift__Content")
            span(v-if="item.type == 'unlucky'") {{ item.name }}
            span(v-else-if="item.type == 'item'") Vật phẩm
            span(v-else-if="item.type == 'wheel'") + {{ item.amount }} Lượt
            span(v-else) + {{ $utils.getMoney(item.amount, false) }}
            UIcon(:src="item.type")

      div(class="Spin" @click="spinWheel")
        UIcon(src="wheel")

    UDialog(v-model="dialog.result" @hide="$emit('reload')" max="180px")
      UBox(v-if="gift" title="Kết quả lượt quay" width="100%" @click="dialog.result = false")
        UFlex(class="py-2" type="column" justify="center" align="center")
          UIcon(class="mb-2" :src="gift.type" :color="gift.type" size="4rem")
          UText(v-if="gift.type == 'unlucky'" weight="600") Đừng Buồn
          UText(v-else-if="gift.type == 'item'" weight="600") {{gift.name}}
          UText(v-else weight="600") + {{$utils.getMoney(gift.amount, true)}}
        template(#footer)
          UFlex(justify="center") 
            UText(weight="700") {{ typeView[gift.type] }} 

    UDialog(v-model="dialog.server")
      UBox(title="Chọn máy chủ" width="100%")
        SelectServer(v-model="server_id")
        template(#footer)
          UFlex(justify="flex-end")
            UButton(@click="dialog.server = false") Xác nhận
</template>

<script>
export default {
  props: {
    list: { type: Array },
  },

  data() {
    return {
      server_id: null,
      now: 0,
      end: 0,
      spin: false,
      dialog: {
        result: false,
        server: false
      },
      anim: null,
      circle: null,
      gift: null,
      colors: [
        '#f4803a', '#e83c48', '#4b5cab', '#54aee3',
        '#6ec431', '#bf5aa2', '#8742f5', '#f5b042',
        '#34eba8', '#eb3467'
      ],
      typeView: {
        'coin': 'Xu',
        'coin_lock': 'Xu Khóa',
        'wheel': 'Thêm Lượt',
        'diamond': 'Kim Cương',
        'unlucky': 'Mất Lượt',
        'item': 'Vật phẩm',
      }
    }
  },

  mounted () {
    this.circle = this.$refs.circle
    this.circle.addEventListener('transitionend', this.endAnim)
  },

  beforeDestroy () {
    this.circle.removeEventListener('transitionend', this.endAnim)
  },

  methods: {
    styleGift (index) {
      return {
        '--ui-gift-color': this.colors[index],
        '--ui-gift-deg': `${(36 * index) + 18}deg`
      }
    },

    async spinWheel () {
      if(!this.isLogin) return this.notify('Vui lòng đăng nhập trước')
      if(!this.server_id) return this.notify('Vui lòng chọn máy chủ trước')
      if(!!this.spin) return
      
      const gift = await this.API('spinWheel', {
        server_id: this.server_id
      })
      if(!gift) return
      this.gift = gift
      this.end = this.getDegGift() + (Math.floor(this.now / 360) - 20) * 360
      this.startAnim()
    },

    getDegGift () {
      const index = this.list.findIndex((item) => item.id == this.gift.id)
      const min = Math.ceil((36 * index) + 5)
      const max = Math.floor((36 * index) + 36 - 5)
      const deg = Math.floor(Math.random() * (max - min + 1) + min)
      return deg * -1
    },

    startAnim () {
      this.spin = true
      this.anim = window.requestAnimationFrame(this.animation)
    },

    endAnim () {
      this.spin = false
      this.dialog.result = true
    },

    animation () {
      if(this.now > this.end){
        this.now += Math.floor(Math.PI * 18) * -1
        window.requestAnimationFrame(this.animation)
      }
      else {
        this.now = this.end
        window.cancelAnimationFrame(this.animation)
        this.anim = null
      }
    }
  }
}
</script>

<style lang="sass">
.WheelCircle
  .UiCard__Body
    display: flex
    justify-content: center
    overflow: hidden

  @keyframes rotate
    0%
      transform: rotate(0deg)
    100%
      transform: rotate(360deg)

  .Wheel
    --ui-wheel-size: 350px
    position: relative
    display: flex
    align-items: center
    justify-content: center
    width: var(--ui-wheel-size)
    height: var(--ui-wheel-size)
    min-width: var(--ui-wheel-size)
    min-height: var(--ui-wheel-size)
    max-width: var(--ui-wheel-size)
    max-width: var(--ui-wheel-size)
    @media (min-width: 769px)
      --ui-wheel-size: 400px
    &--spin
      .Spin
        animation: rotate 4.2s linear
      
    .Spin
      position: absolute
      display: flex
      align-items: center
      justify-content: center
      width: 70px
      height: 70px
      background: rgb(var(--ui-content))
      border-radius: 50%
      box-shadow: 0px 0px 0px 4px rgba(var(--ui-shadow), 0.5)
      font-size: 2rem
      cursor: pointer
      &::after
        content: ''
        position: absolute
        top: -40%
        width: 60%
        height: 60%
        background: inherit
        clip-path: polygon(50% 0%, 20% 100%, 80% 100%)
        z-index: 0

    .Circle
      position: absolute
      display: flex
      justify-content: center
      width: 100%
      height: 100%
      border-radius: 50%
      box-shadow: 0px 0px 0px 4px rgba(var(--ui-dark), 1)
      transform: rotate(var(--ui-circle-deg))
      transition: transform 2s ease
      overflow: hidden
      .Gift
        position: absolute
        display: flex
        align-items: center
        justify-content: center
        width: 50%
        height: 50%
        clip-path: polygon(17.5% 0 , 50% 100% , 82.5% 0)
        background: var(--ui-gift-color)
        transform: rotate(var(--ui-gift-deg))
        transform-origin: bottom
        z-index: 0
        &__Content
          position: absolute
          display: flex
          align-items: center
          justify-content: flex-end
          width: 100%
          white-space: nowrap
          transform: rotate(90deg) translateX(-38%)
          overflow: hidden
          color: rgb(var(--ui-light))
          font-weight: 600
          span
            margin-right: 6px
          i
            font-size: 1.3rem
</style>
<template>
  <div 
    :class="{
      'UiInput': true,
      'UiInput--icon': icon,
    }"
    :style="{
      '--ui-input-color': !!color ? `var(--ui-${_color(color)})` : null,
      '--ui-input-icon-color': !!iconColor ? `var(--ui-${_color(iconColor)})` : null,
      '--ui-input-width': width,
      '--ui-input-height': height,
    }"
    ref="select"
  >
    <div class="UiInput__Label" v-if="labelTop">{{labelTop}}</div>

    <div class="UiInput__Content">
      <div class="UiInput__Content__Icon mr-2" v-if="icon">
        <UIcon :src="icon" size="1.1rem"></UIcon>
      </div>
      
      <input
        class="UiInput__Content__Input"
        type="text"
        :value="val"
        :placeholder="placeholder"
        :readonly="true"
        :disabled="disabled"
        @click="show = !show"
      />
    </div>

    <transition name="select">
      <div class="UiSelect" v-if="!!show && list.length > 0">
        <div class="UiSelect__Item" v-for="(item, i) in list" :key="i" @click="selectItem(item)">
          <span>{{ item[label] || 'Định dạng chưa đúng' }}</span>
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
export default {
  props: {
    width: { type: String, default: null },
    height: { type: String, default: null },
    icon: { type: String, default: null },
    color: { type: String, default: null },
    iconColor: { type: String, default: null },

    model: { type: String || Number, default: null },
    placeholder: { type: String, default: null },
    labelTop: { type: String, default: null },
    disabled: { type: Boolean, default: false },

    list: { type: Array, default: [] },
    label: { type: String, default: 'label' },
    value: { type: String, default: 'value' },
  },

  model: {
    prop: 'model',
    event: 'change'
  },

  data() {
    return {
      show: false,
      select: null
    }
  },

  computed: {
    val () {
      if(!this.select) return null
      if(this.select[this.label]) return this.select[this.label]
      return null
    }
  },

  watch: {
    show (val) {
      if(!!val){
        window.addEventListener('click', this.clickOutside)
      }
      else {
        window.removeEventListener('click', this.clickOutside)
      }
    }
  },

  mounted() {
    if(!this.model) return
    const index = this.list.findIndex((i) => i[this.value] == this.model)
    if(index != -1) return this.select = this.list[index]
  },

  methods: {
    selectItem (item) {
      this.$emit('change', null)
      this.$emit('input', null)
      this.select = null

      setTimeout(() => {
        this.$emit('change', item[this.value])
        this.$emit('input', item[this.value])
        this.select = item
        this.show = false
      }, 1)
    },

    clickOutside (event) {
      const el = this.$refs['select']
      if(!el) return
      if(!(el == event.target || el.contains(event.target))) return this.show = false
    }
  }
}
</script>

<style lang="sass">
.UiInput
  .UiSelect
    position: absolute
    top: calc(100% + 1px)
    left: 0
    width: 100%
    max-height: calc(38px * 5)
    background: rgba(var(--ui-content))
    border-radius: var(--radius)
    box-shadow: 0 0 20px -5px rgba(var(--ui-black), 0.2)
    border: 1px solid rgba(var(--ui-dark), 0.1)
    overflow: auto
    z-index: 99
    &__Item
      display: flex
      align-items: center
      width: 100%
      height: 38px
      max-height: 38px
      padding: 0 var(--space)
      font-size: 0.8rem
      font-weight: 500
      cursor: pointer

    @keyframes select-effect 
      0% 
        opacity: 0
        transform: translateY(12px)
      100% 
        opacity: 1
        transform: translateY(0)
    &.select-enter-active 
      animation: select-effect .25s ease forwards
    &.select-leave-active 
      animation: select-effect .25s reverse ease forwards
</style>
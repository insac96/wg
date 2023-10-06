<template>
  <i 
    :class="{
      'UiIcon': true,
      'bx': true,
      [`${_icon(src)}`]: true,
      'pointer': !!$listeners.click
    }" 
    :style="{ 
      color: !!color ? `rgb(var(--ui-${_color(color)}))` : null,
      'font-size': size
    }"
    @click="$emit('click')"
  ></i>
</template>

<script>
export default {
  props: {
    color: { type: String, default: null },
    src: { type: String, default: null },
    size: { type: String, default: null },
  },
}
</script>
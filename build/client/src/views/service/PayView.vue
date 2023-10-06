<template lang="pug">
  div(class="PayView")
    transition(name="up")
      PayGate(class="mb-2" :gate.sync="gate" v-if="!pay")
    
    transition(name="up")
      PayReview(class="mb-2" v-if="!pay && !!gate" :gate.sync="gate" :pay.sync="pay")
    
    transition(name="up")
      PayInstruct(:gate.sync="gate" :pay.sync="pay")
  </div>
</template>

<script>
import PayGate from '@/components/service/pay/Gate'
import PayReview from '@/components/service/pay/Review'
import PayInstruct from '@/components/service/pay/Instruct'

export default {
  components: {
    PayGate,
    PayReview,
    PayInstruct
  },

  data() {
    return {      
      gate: null,
      pay: null,
    }
  }
}
</script>
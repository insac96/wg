<template lang="pug">
  div(class="ManageStatisticalSignIn")
    UFlex(wrap="wrap" class="mb-2" v-if="!!loaderChart")
      UCard(class="box-resize-50")
        Bar(:options="chartOptions" :data="chartDataBar")
      UCard(class="box-resize-50")
        LineChartGenerator(:options="chartOptions" :data="chartDataLine")

    UTableAdmin(
      :head="head"
      get-action="getStatisticalSignIn"
      :plus-get="date"
      :reload="reload"
      :data-list.sync="dataList"
      first-sort="table_time"
      :sum="['sign_in']"
    )
      template(#header)
        UFlex(align="center")
          UInput(v-model="date.start" type="date" icon="bxs-calendar" size="40px" icon-color="dark" placeholder="Bắt đầu" class="mb-0" width="180px")
          UInput(v-model="date.end" type="date" placeholder="Kết thúc" size="40px" class="mb-0" width="150px")
</template>

<script>
import { Bar, Line as LineChartGenerator } from 'vue-chartjs'

import { 
  Chart as ChartJS, 
  Tooltip, Legend, 
  BarElement, LineElement, 
  CategoryScale, LinearScale, 
  PointElement,
} from 'chart.js'

ChartJS.register(
  Tooltip, Legend, 
  BarElement, LineElement, 
  CategoryScale, LinearScale, 
  PointElement
)

export default {
  components: {
    Bar,
    LineChartGenerator
  },

  data() {
    return {
      head: {
        'table_time': 'Ngày',
        'sign_in': 'Người đăng nhập',
      },

      reload: 0,

      date: {
        start: null,
        end: this.$utils.getTime(new Date() / 1000).dateInput
      },

      dataList: null,
      
      loaderChart: false,
      chartDataBar: null,
      chartDataLine: null,
      chartOptions: {
        responsive: true
      }
    }
  },

  watch: {
    'date.start' () {
      this.onReload()
    },
    'date.end' () {
      this.onReload()
    },
    dataList () {
      this.makeChart()
    }
  },

  methods: {
    makeChart () {
      if(!this.dataList) return

      this.loaderChart = false
      const list = JSON.parse(JSON.stringify(this.dataList)).reverse()
      const labels = []
      const sign_in = []

      list.forEach(item => {
        labels.push(item.table_time)
        sign_in.push(item.sign_in)
      })

      this.chartDataBar = {
        labels,
        datasets: [
          { 
            label: 'Người đăng nhập',
            data: sign_in,
            backgroundColor: 'rgb(6,122,203)',
          }
        ]
      }

      this.chartDataLine = {
        labels,
        datasets: [
          { 
            label: 'Người đăng nhập',
            data: sign_in,
            fill: false,
            borderColor: 'rgb(6,122,203)',
            tension: 0.1
          }
        ]
      }

      this.loaderChart = true
    },

    onReload () {
      this.reload = this.reload + 1
    }
  },
}
</script>
<template lang="pug">
  div
    UFlex(wrap="wrap" class="mb-2" v-if="loaderChart")
      UCard(class="box-resize-50")
        Bar(:options="chartOptions" :data="chartDataBar")
      UCard(class="box-resize-50")
        LineChartGenerator(:options="chartOptions" :data="chartDataLine")

    UTableAdmin(
      :head="head"
      get-action="getStatisticalTableRevenue"
      :plus-get="date"
      :reload="reload"
      :data-list.sync="dataList"
      first-sort="date"
      :sum="['user_pay', 'pay_count', 'pay_success', 'pay_refuse', 'pay_wait', 'pay_all', 'pay_banking', 'pay_card', 'pay_momo']"
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
        'date': 'Ngày',
        'user_pay': 'Người nạp',
        'pay_count': 'Tổng giao dịch',
        'pay_success': 'Thành Công',
        'pay_refuse': 'Thất bại',
        'pay_wait': 'Chưa duyệt',
        'pay_all': 'Tổng doanh thu',
        'pay_banking': 'Ngân hàng',
        'pay_card': 'Thẻ cào',
        'pay_momo': 'Momo',
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
      const pay_all = []
      const pay_momo = []
      const pay_card = []
      const pay_bank = []

      list.forEach(item => {
        labels.push(item.date)
        pay_all.push(item.pay_all)
        pay_momo.push(item.pay_momo)
        pay_card.push(item.pay_card)
        pay_bank.push(item.pay_banking)
      })

      this.chartDataBar = {
        labels,
        datasets: [
          { 
            label: 'Tổng',
            data: pay_all,
            backgroundColor: 'rgb(59, 89, 153)',
          },
          { 
            label: 'Momo',
            data: pay_momo ,
            backgroundColor: 'rgb(175,32,112)',
          },
          { 
            label: 'Card',
            data: pay_card,
            backgroundColor: 'rgb(90,170,61)',
          },
          { 
            label: 'Bank',
            data: pay_bank,
            backgroundColor: 'rgb(243,141,26)',
          } 
        ]
      }

      this.chartDataLine = {
        labels,
        datasets: [
          { 
            label: 'Tổng',
            data: pay_all,
            fill: false,
            borderColor: 'rgb(59, 89, 153)',
            tension: 0.1
          },
          { 
            label: 'Momo',
            data: pay_momo ,
            fill: false,
            borderColor: 'rgb(175,32,112)',
            tension: 0.1
          },
          { 
            label: 'Card',
            data: pay_card,
            fill: false,
            borderColor: 'rgb(90,170,61)',
            tension: 0.1
          },
          { 
            label: 'Bank',
            data: pay_bank,
            fill: false,
            borderColor: 'rgb(243,141,26)',
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
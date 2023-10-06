import Vue from 'vue'

import UAlert from '@/components/uikit/UAlert'
import UBarge from '@/components/uikit/UBarge'
import UBox from '@/components/uikit/UBox'
import UButton from '@/components/uikit/UButton'
import UCard from '@/components/uikit/UCard'
import UChip from '@/components/uikit/UChip'
import UDialog from '@/components/uikit/UDialog'
import UFlex from '@/components/uikit/UFlex'
import UIcon from '@/components/uikit/UIcon'
import UInput from '@/components/uikit/UInput'
import UItem from '@/components/uikit/UItem'
import UScrollX from '@/components/uikit/UScrollX'
import USelect from '@/components/uikit/USelect'
import UText from '@/components/uikit/UText'
import UTab from '@/components/uikit/UTab'
import UTable from '@/components/uikit/UTable'
import UPagination from '@/components/uikit/UPagination'

import SelectServer from '@/components/Server'
import UserCurrency from '@/components/Currency'
import SelectServerAdmin from '@/components/admin/ServerAdmin'
import UGiftAdmin from '@/components/admin/UGiftAdmin'
import UTableAdmin from '@/components/admin/UTableAdmin'
Vue.component('SelectServer', SelectServer)
Vue.component('UserCurrency', UserCurrency)
Vue.component('SelectServerAdmin', SelectServerAdmin)
Vue.component('UGiftAdmin', UGiftAdmin)
Vue.component('UTableAdmin', UTableAdmin)

Vue.component('UAlert', UAlert)
Vue.component('UBarge', UBarge)
Vue.component('UBox', UBox)
Vue.component('UButton', UButton)
Vue.component('UCard', UCard)
Vue.component('UChip', UChip)
Vue.component('UDialog', UDialog)
Vue.component('UFlex', UFlex)
Vue.component('UIcon', UIcon)
Vue.component('UInput', UInput)
Vue.component('UItem', UItem)
Vue.component('UScrollX', UScrollX)
Vue.component('USelect', USelect)
Vue.component('UText', UText)
Vue.component('UTab', UTab)
Vue.component('UTable', UTable)
Vue.component('UPagination', UPagination)

Vue.mixin(Vue.extend({
  methods: {
    _color (name) {
      if(!name) return null
      if(name == 'coin_lock') return 'coin-lock'
      if(name == 'gate-1') return 'gate-banking'
      if(name == 'gate-2') return 'gate-card'
      if(name == 'gate-3') return 'gate-momo'
      return name
    },

    _icon (name) {
      if(!name) return null
      if(name == 'home') return 'bxs-home'
      if(name == 'setting') return 'bxs-cog'
      if(name == 'alert') return 'bxs-info-circle'
      if(name == 'error') return 'bx-error-circle'

      if(name == 'user') return 'bxs-user'
      if(name == 'password') return 'bxs-lock'
      if(name == 'phone') return 'bxs-phone'
      
      if(name == 'referraler') return 'bxs-user-plus'
      if(name == 'pay') return 'bx-credit-card'
      if(name == 'coin') return 'bxs-data'
      if(name == 'coin_lock') return 'bxs-sushi'
      if(name == 'diamond') return 'bx bxl-sketch'
      if(name == 'wheel') return 'bxs-color'
      if(name == 'dice') return 'bxs-dice-6'
      if(name == 'dice-1') return 'bx-dice-1'
      if(name == 'dice-2') return 'bx-dice-2'
      if(name == 'dice-3') return 'bx-dice-3'
      if(name == 'dice-4') return 'bx-dice-4'
      if(name == 'dice-5') return 'bx-dice-5'
      if(name == 'dice-6') return 'bx-dice-6'
      if(name == 'money') return 'bxs-dollar-circle'
      if(name == 'pcode') return 'bx-barcode'
      if(name == 'item') return 'bx bxs-gift'

      if(name == 'gate') return 'bxs-bank'
      if(name == 'news') return 'bx-news'
      if(name == 'shop') return 'bxs-store-alt'
      if(name == 'event') return 'bxs-calendar-event'
      if(name == 'mission') return 'bx-book-reader'
      if(name == 'notify') return 'bxs-bell-ring'
      if(name == 'game') return 'bxs-game'
      if(name == 'giftcode') return 'bx bxs-gift'
      if(name == 'rank') return 'bx bxs-bar-chart-alt-2'

      if(name == 'time') return 'bx-time'
      if(name == 'reload') return 'bx-revision'
      if(name == 'code') return 'bx-barcode-reader'
      if(name == 'text') return 'bx-text'
      if(name == 'unlucky') return 'bxs-smile'
      if(name == 'none') return 'bx-block'
      
      return name
    }
  }
}))

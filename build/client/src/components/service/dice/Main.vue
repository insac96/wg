<template lang="pug">
  div(class="DiceMain" v-if="jar")
    UCard(title="Xúc xắc may mắn")
      UCard(class="DiceView__Box mb-2")
        UFlex(class="DiceView__MoneyTotal mb-1" align="center" justify="center" v-if="isLogin")
          UChip(height="35px" icon="coin_lock" full color="coin_lock")
            UText(size="1rem") Hũ {{ $utils.getMoney(jar, false) }}
        UFlex(justify="center" align="center")
          div(class="DiceView__Box__Item")
            UIcon(:src="`dice-${diceResult[1]}`" size="6rem")
          div(class="DiceView__Box__Item")
            UIcon(:src="`dice-${diceResult[2]}`" size="6rem")
          div(class="DiceView__Box__Item")
            UIcon(:src="`dice-${diceResult[3]}`" size="6rem")
        UFlex(class="DiceView__MoneyTotal mb-1" align="center" justify="center" v-if="isLogin")
          UChip(height="35px" icon="coin")
            UText(size="1rem") - {{ $utils.getMoney(moneyTotal, false) }}
        
      div(class="DiceView__Pick mb-1" v-if="isLogin")
        UFlex(align="center" justify="space-between" v-for="(money, dice) in diceList" :key="dice")
          UFlex(align="center")
            UIcon(:src="`dice-${dice}`" size="3rem" class="mr-1")
            UText(size="1rem" weight="600") {{ dice }} điểm
          UFlex(align="center")
            UButton(avatar size="33px" color="dark" @click="minusDiceMoney(dice)") -
            UChip(class="mx-1") {{$utils.getMoney(money)}}
            UButton(avatar size="33px" @click="addDiceMoney(dice)") +

      UFlex(class="DiceView__MoneyPick mb-1" align="center" justify="center" wrap="wrap" v-if="isLogin")
        UChip(
          class="ma-1"
          v-for="i in moneyList" 
          :key="i" 
          :color="i == moneyPick ? 'primary' : null" 
          :full="i == moneyPick ? true : false"
          @click="setMoneyPick(i)"
        ) {{ $utils.getMoney(i) }}

      UFlex(class="DiceView__Shock" justify="center")
        UButton(@click="shockDice") Quay Ngay

    UDialog(v-model="dialog" @hide="reset" max="350px")
      UBox(title="Kết quả lượt quay" width="100%" @click="dialog = false")
        UFlex(justify="center" align="center" class="mb-1")
          div()
            UIcon(:src="`dice-${diceResult[1]}`" size="4rem")
          div()
            UIcon(:src="`dice-${diceResult[2]}`" size="4rem")
          div()
            UIcon(:src="`dice-${diceResult[3]}`" size="4rem")
        UFlex(justify="space-between" align="center" class="mb-2")
          UText(size="0.9rem") Cược
          UChip(icon="bx-coin" color="coin") - {{ $utils.getMoney(moneyResult.minus)}}
        UFlex(justify="space-between" align="center" class="mb-2")
          UText(size="0.9rem") Thắng
          UChip(icon="bx-coin" color="coin") + {{ $utils.getMoney(moneyResult.add)}}
        UFlex(justify="space-between" align="center" class="mb-2" v-if="moneyResult.jar > 0")
          UText(size="0.9rem") Hũ
          UChip(icon="bx-coin" color="coin") + {{ $utils.getMoney(moneyResult.jar)}}
        UFlex(justify="space-between" align="center")
          UText(size="0.9rem") Kết quả 
          UChip(icon="bx-coin" color="coin") {{ moneyResultType + $utils.getMoney(moneyResultTotal) }}
</template>

<script>
export default {
  props: {
    jar: { type: Number || String } 
  },

  data() {
    return {
      diceResult: {
        1: 6,
        2: 6,
        3: 6
      },
      diceList: {
        1: 0,
        2: 0,
        3: 0,
        4: 0,
        5: 0,
        6: 0
      },

      moneyList: [10000, 100000, 1000000, 10000000, 100000000],
      moneyPick: 10000,
      moneyResult: {
        minus: 0,
        add: 0,
        jar: 0
      },
      
      start: false,
      anim: null,
      dialog: false
    }
  },
  computed: {
    moneyTotal () {
      let total = 0
      for (const [key, value] of Object.entries(this.diceList)) {
        total = total + value
      }
      return total
    },
    moneyResultTotal () {
      const money = Number(this.moneyResult.add) - Number(this.moneyResult.minus) + Number(this.moneyResult.jar)
      return (money < 0) ? money * -1 : money;
    },
    moneyResultType () {
      const money = Number(this.moneyResult.add) - Number(this.moneyResult.minus) + Number(this.moneyResult.jar)
      return money >= 0 ? '+ ' : '- '
    }
  },
  methods: {
    setMoneyPick (money) {
      if(!this.isLogin) return this.notify('Vui lòng đăng nhập trước')
      if(!!this.start) return this.notify('Phiên đang quay, vui lòng đợi')
      this.moneyPick = money
    },

    minusDiceMoney (dice) {
      if(!this.isLogin) return this.notify('Vui lòng đăng nhập trước')
      if(!!this.start) return this.notify('Phiên đang quay, vui lòng đợi')
      this.diceList[dice] = this.diceList[dice] - this.moneyPick
      if(this.diceList[dice] <= 0){
        this.diceList[dice] = 0
      }
    },
    addDiceMoney (dice) {
      if(!this.isLogin) return this.notify('Vui lòng đăng nhập trước')
      if(!!this.start) return this.notify('Phiên đang quay, vui lòng đợi')
      this.diceList[dice] = this.diceList[dice] + this.moneyPick
    },

    startAnimShock () {
      if(!!this.anim) return
      this.anim = setInterval(() => {
        this.diceResult[1] = Math.floor(Math.random() * 6) + 1
        this.diceResult[2] = Math.floor(Math.random() * 6) + 1
        this.diceResult[3] = Math.floor(Math.random() * 6) + 1
      }, 100)
    },
    stopAnimShock () {
      if(!this.anim) return
      clearInterval(this.anim)
      this.anim = null
    },

    reset () {
      this.start = false
      this.diceList = {
        1: 0,
        2: 0,
        3: 0,
        4: 0,
        5: 0,
        6: 0
      }
      this.moneyResult = {
        minus: 0,
        add: 0
      }
      this.getUser()
      this.$emit('reload')
    },

    async shockDice () {
      if(!this.isLogin) return this.notify('Vui lòng đăng nhập trước')
      if(this.moneyTotal <= 0) return this.notify('Vui lòng đặt cược trước')
      if(!!this.start) return this.notify('Phiên đang quay, vui lòng đợi')
      
      this.start = true
      const result = await this.API('shockDice', {
        dice_list: this.diceList
      })
      if(!result) return this.start = false

      this.startAnimShock()
      setTimeout(() => {
        this.stopAnimShock()
        this.moneyResult.minus = result['money_minus']
        this.moneyResult.add = result['money_add']
        this.moneyResult.jar = result['money_jar']
        this.diceResult[1] = result['dices'][0]
        this.diceResult[2] = result['dices'][1]
        this.diceResult[3] = result['dices'][2]
        this.dialog = true

        const money = Number(this.moneyResult.add) - Number(this.moneyResult.minus) + Number(this.moneyResult.jar)
        if(money > 100000){
          this.sendSocketNotify(`${this.storeUser.account.toUpperCase()} thắng ${this.$utils.getMoney(money, true)} từ xúc xắc`)
        }
      }, 2000)
    },


  },
}
</script>
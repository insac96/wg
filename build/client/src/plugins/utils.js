import Vue from 'vue'
import dayjs from 'dayjs'
import relativeTime from 'dayjs/plugin/relativeTime'
import 'dayjs/locale/vi'
dayjs.extend(relativeTime)
dayjs.locale('vi')

const setCookie = (name, value) => {
  let d = new Date();
  d.setTime(d.getTime() + (7*24*60*60*1000));
  let expires = "expires="+ d.toUTCString();
  document.cookie = name + "=" + value + ";" + expires + ";path=/";
}

const getCookie = (cookieName) => {
  let name = cookieName + "=";
  let decodedCookie = decodeURIComponent(document.cookie);
  let ca = decodedCookie.split(';');
  for(let i = 0; i <ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

const deleteCookie = (cookieName) => {
  document.cookie = cookieName+ "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;"
}

const getTime = (time) => {
  const nDate = new Date(time * 1000)
  const d = dayjs(nDate)

  return {
    dateInput: d.format('YYYY-MM-DD'),
    timeInput: d.format('HH:mm'),
    date: d.format('DD/MM/YYYY'),
    time: d.format('HH:mm'),
    full: d.format('DD/MM/YYYY lúc HH:mm'),
    from: d.fromNow(),
    to: `Còn ${d.toNow(true)}`
  }
}

const getExpires = (time) => {
  if(time == 0) return { active: true,  text: 'Hoạt Động' }
  
  const expires_time = new Date(time * 1000)
  const now_time = new Date()

  if(now_time < expires_time) return { active: true, text: getTime(time).to }
  return { active: false, text: 'Kết thúc' }
}

const getMoney = (money, mini = true) => {
  let num = Number(money)

  function returnNum (num) {
    return Number(String(num))
  }
  
  if(!mini) return num.toLocaleString("vi-VN")
  if(num < 1000) return num.toLocaleString("vi-VN")
  if(num >= 1000 && num <= 999999) return returnNum((num / 1000).toFixed(1)) + 'k'
  if(num > 999999 && num <= 999999999) return returnNum((num / 1000000).toFixed(1)) + 'm'
  if(num > 999999999 && num <= 999999999999) return returnNum((num / 1000000000).toFixed(1)) + 'b'
  if(num > 999999999999 && num <= 999999999999999) return returnNum((num / 1000000000000).toFixed(1)) + 't'
  if(num > 999999999999999 && num <= 999999999999999999) return returnNum((num / 1000000000000000).toFixed(1)) + 'q'
  return 0
}

const getGifts = (gifts) => {
  return JSON.parse(gifts)
}

Vue.prototype.$utils = { 
  setCookie, getCookie, deleteCookie,
  getTime, getExpires, getMoney, getGifts
}

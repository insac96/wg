const chatModule = require('./chat') 
const notifyModule = require('./notify') 

const socketCore = (io) => {
  io.on('connection', (socket) => {
    chatModule(io, socket)
    notifyModule(io, socket)
  })  
}

module.exports = socketCore
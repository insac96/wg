let chats = []
let online = 0
let pin = null

const chatModule = (io, socket) => {
  // Update Online Data
  online++
  io.emit('online', online)

  // On Get Chat Data
  socket.on('get-chat-data', () => {
    socket.emit('online', online)
    socket.emit('pin', pin)
    socket.emit('chats', chats)
  })

  // On Update Pin
  socket.on('update-pin', (data) => {
    pin = data
    io.emit('pin', pin)
  })

  // Reset Pin
  socket.on('reset-pin', () => {
    pin = null
    io.emit('pin', pin)
  })

  // On Add Chat
  socket.on('add-chat', ({account, vip, block, type, message, reply}) => {
    if(!account || !vip || !message) return
    if(block == 1) return

    const data = {
      id: (new Date()).getTime(),
      account: account,
      type: type,
      vip: vip.number,
      message: message,
      reply: reply
    }

    chats.push(data)
    io.emit('chat', data)
    if(chats.length > 20) return chats.shift()
  })

  // Reset Chats
  socket.on('reset-chats', () => {
    chats = []
    io.emit('chats', chats)
  })

  // Disonnect
  socket.on('disconnect', () => {
    online--
    io.emit('online', online)
  })
}

module.exports = chatModule
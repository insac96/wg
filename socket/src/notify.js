const notifyModule = (io, socket) => {
  // Add Notify
  socket.on('add-notify', ({account, block, vip, effect, content}) => {
    if(!account || !vip || !effect || !content) return
    if(block == 1) return
    if(!vip.number) return

    io.emit('notify', {
      id: (new Date()).getTime(),
      effect: effect == 'vip' ? `vip-${vip.number}` : effect,
      content: content,
      dup: 2000
    })
  })
}

module.exports = notifyModule
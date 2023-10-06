const express = require('express')
const app = express()
const cors = require('cors')
const http = require('http')
const server = http.createServer(app)
const { Server } = require("socket.io")
const socketCore = require('./core') 

const io = new Server(server, {
  allowEIO3: true,
  cors: {
      origin: true,
      credentials: true
  },
})

app.use(cors())
app.get('/', (req, res) => res.send('Socket ON'))
socketCore(io)
server.listen(5000)
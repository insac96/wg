const { defineConfig } = require('@vue/cli-service')
const path = require('path')

module.exports = defineConfig({
  outputDir: path.resolve(__dirname, '../../client'),
  publicPath: process.env.NODE_ENV === 'production' ? '/client/' : '/',
  indexPath: 'no-seo.html',
  productionSourceMap: false,
  filenameHashing: true
})

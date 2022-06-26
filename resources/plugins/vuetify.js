// You still need to register Vuetify itself
// src/plugins/vuetify.js
// import colors from 'vuetify/lib/util/colors'
import '@mdi/font/css/materialdesignicons.css' // Ensure you are using css-loader
// import 'font-awesome/css/font-awesome.min.css' // Ensure you are using css-loader
import Vue from 'vue'
import Vuetify from 'vuetify/lib'


Vue.use(Vuetify,)

const opts = {}

export default new Vuetify(


  {
    icons: {
      iconfont: 'mdi'
    },
    theme: {
      // dark: true,
      themes: {
        light: {
          primary: '#1b5e20', //Comp_green
          secondary: '#424242',
          accent: '#82B1FF',
          error: '#FF5252',
          info: '#2196F3',
          success: '#4CAF50',
          warning: '#FFC107',

          // primary: colors.green.base,
          // secondary: colors.yellow.base,
          // accent: colors.teal.base,
          // error: colors.deep - orange.base,
          // warning: colors.amber.base,
          // info: colors.cyan.base,
          // success: colors.light - green.base

        },
        dark: {
          primary: ' #033616',
        },
      },
    },
  },

)
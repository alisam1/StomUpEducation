// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.

import Vue from 'vue';
import Vuex from 'vuex';
import App from './App';

import settings from '@/store_modules/settings_store.js';
import chat from '@/store_modules/chat_store.js';

Vue.config.productionTip = false;
Vue.use(Vuex);

const store = new Vuex.Store({
    modules: {
        settings: settings,
        chat: chat,
    }
});

/* eslint-disable no-new */
new Vue({
    store,
    render: h => h(App),
}).$mount('#trans');

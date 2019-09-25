require('./bootstrap');

window.Vue = require('vue');

/**
 * Imports
 */
import BootstrapVue from 'bootstrap-vue'



/**
 * uses
 */
Vue.use(BootstrapVue);

/**
 * Add components
 */
Vue.component('dashboard', require('./components/Dashboard').default);

/**
 * Init Vue App.
 */
let app = new Vue({
    el: '#app',
    data: {},
});

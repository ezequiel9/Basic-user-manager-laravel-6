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

// users
Vue.component('users', require('./components/users/Users').default);
Vue.component('users-form', require('./components/users/UsersForm').default);

Vue.component('companies', require('./components/companies/Companies').default);


/**
 * Init Vue App.
 */
let app = new Vue({
    el: '#app',
    data: {},
});

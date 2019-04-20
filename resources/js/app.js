/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'

Vue.use(Vuetify)


require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

Vue.component('welcome-ibk', require('./components/welcome.vue').default);

// Driver
Vue.component('component-dri', require('./components/drivers/component.vue').default);
Vue.component('profile-dri', require('./components/drivers/profile.vue').default);
Vue.component('emergency-dri', require('./components/drivers/emergency.vue').default);
Vue.component('notifications-dri', require('./components/drivers/notifications.vue').default);
Vue.component('message-dri', require('./components/drivers/message.vue').default);
Vue.component('studentsguardian-dri', require('./components/drivers/studentsguardian.vue').default);

// Guardian
Vue.component('component-gua', require('./components/guardians/component.vue').default);
Vue.component('profile-gua', require('./components/guardians/profile.vue').default);
Vue.component('driver-gua', require('./components/guardians/driver.vue').default);
Vue.component('emergency-gua', require('./components/guardians/emergency.vue').default);
Vue.component('mychild-gua', require('./components/guardians/mychild.vue').default);
Vue.component('notifications-gua', require('./components/guardians/notifications.vue').default);

// Student
Vue.component('component-stu', require('./components/students/component.vue').default);
Vue.component('profile-stu', require('./components/students/profile.vue').default);
Vue.component('notification-stu', require('./components/students/notifications.vue').default);
Vue.component('mydriver-stu', require('./components/students/my_driver.vue').default);
Vue.component('message-stu', require('./components/students/message.vue').default);

// Admin
Vue.component('component-admin', require('./components/admins/component.vue').default);
Vue.component('profile-admin', require('./components/admins/profile.vue').default);
Vue.component('stutable-admin', require('./components/admins/student-table.vue').default);
Vue.component('dritable-admin', require('./components/admins/driver-table.vue').default);
Vue.component('guatable-admin', require('./components/admins/guardian-table.vue').default);
Vue.component('bustable-admin', require('./components/admins/bus-table.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const app = new Vue({
    el: '#app'
});

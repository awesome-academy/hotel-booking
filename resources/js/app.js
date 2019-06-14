/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');
window.Vue = require('vue');
window._ = require('lodash');
window.$ = window.jQuery = require('jquery');

import contact from './components/ContactNotification.vue'
Vue.component('contact', contact);
const app = new Vue({
    el: '#app',
    data : {
        contacts: '',
    },
    created(){
        if (window.Laravel.userId) {
            axios.post('/admin/notification/contact/notification').then(response => {
                this.contacts = response.data;
            });
        }
        Echo.private('App.Models.User.' + window.Laravel.userId).listen('.Illuminate\\Notifications\\Events\\BroadcastNotificationCreated', (e) => { 
            this.contacts.push({"data":e});
        });
    }
});

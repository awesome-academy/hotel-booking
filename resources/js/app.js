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
import comment from './components/CommentVue.vue'
Vue.component('contact', contact);
Vue.component('comment', comment);
const app = new Vue({
    el: '#app',
    data : {
        contacts: '',
        name: '',
        comments: '',
        messages: '',
    },
    created(){
        if (window.Laravel.userId) {
            axios.post('/admin/contact/notification').then(response => {
                this.contacts = response.data;
            });
            Echo.private('App.Models.User.' + window.Laravel.userId).listen('.Illuminate\\Notifications\\Events\\BroadcastNotificationCreated', (e) => { 
                this.contacts.push({ "data" : e });
                $('#contact-table').DataTable().ajax.reload(null, false);
            });
        }
        this.name = $("#hiddenNameContact").val();
        axios.post('/blog/getComment/' + $('#hiddenPostID').val()).then(response => {
            this.comments = response.data;
        });
        var messages = {
            delete1: $('#hiddenPostID').attr('delete'),
            edit: $('#hiddenPostID').attr('edit'),
            body: $('#hiddenPostID').attr('body'),
            btn_submit: $('#hiddenPostID').attr('btn-submit'),
            image: $('#hiddenPostID').attr('image'),
            check: $('#hiddenPostID').attr('if-action-start'),
        }
        this.messages = messages;
        console.log(this.messages);
        Pusher.logToConsole = true;
        var pusher = new Pusher(process.env.MIX_PUSHER_APP_KEY, {
            cluster: process.env.MIX_PUSHER_APP_CLUSTER,
            encrypted: true,
        });
        var channel = pusher.subscribe('my-channel');
        channel.bind('form-submitted', (data) => {
            var check = $('#hiddenPostID').attr("if-action-start");
            if ($('#hiddencheck').val() == data.comment.cookie_name) {
                check = check + ',' + data.comment.id;
                $('#hiddenPostID').attr("if-action-start", check);
            }
            messages = {
                delete1: $('#hiddenPostID').attr('delete'),
                edit: $('#hiddenPostID').attr('edit'),
                body: $('#hiddenPostID').attr('body'),
                btn_submit: $('#hiddenPostID').attr('btn-submit'),
                image: $('#hiddenPostID').attr('image'),
                check: check,
            }
            this.messages = messages;
            this.comments.unshift(data.comment);
        })
    }
});

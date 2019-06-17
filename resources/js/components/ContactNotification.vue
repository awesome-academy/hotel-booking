<template>
    <li class="m-menu__item" aria-haspopup="true">
        <a class="m-menu__link m-menu__toggle" :href="href">
            <i class="m-menu__link-icon fa fa-copy"></i>
            <span class="m-menu__link-text">{{ name }}</span><span class="badge badge-danger" id="count-notification">{{ contacts.length}}</span><span class="caret"></span>
        </a>
    </li>
</template>
<script>
    export default {
        props: [
            'contacts',
            'name'
        ],
        data() {
            return {
                href: ''
            }
        },
        mounted() {
            this.href = '/admin/contact';
        }
    }
</script>

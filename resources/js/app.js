import Vue from 'vue';

require('./bootstrap');

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
import home from './components/Home.vue';
import dashboard from './components/Dashboard.vue';
import sidebar from './components/sidebar.vue';
import administration from './components/Administration.vue';

const app = new Vue({
    // el: '#app',
    components: {
        home,
        sidebar,
        dashboard,
        administration
    },
}).$mount('#app');

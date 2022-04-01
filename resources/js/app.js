require('./bootstrap');

window.Vue = require('vue').default;


// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('editor', require('./components/editor.vue').default);
Vue.component('slider', require('./components/slider.vue').default);

const app = new Vue({
    el: '#app',
});

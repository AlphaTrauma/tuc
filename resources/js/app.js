require('./bootstrap');

window.Vue = require('vue').default;
import UIkit from 'uikit';
import Icons from 'uikit/dist/js/uikit-icons';
UIkit.use(Icons);
window.UIkit = UIkit;
import store from './store';

Vue.component('editor', require('./components/Editor.vue').default);
Vue.component('slider', require('./components/Slider.vue').default);
Vue.component('courses', require('./components/courses.vue').default);
Vue.component('alerts', require('./components/Alerts.vue').default);
Vue.component('upload', require('./components/Upload.vue').default);

Vue.mixin({
    methods: {
        getIndex: function(node){
            let children = node.parentNode.childNodes, num = 0;
            for (let i=0; i<children.length; i++) {
                if (children[i] === node) return num;
                if (children[i].nodeType === 1) num++;
            }
            return -1;
        }
    },
})

const app = new Vue({
    el: '#app',
    data(){
        return {token: ''}
    },
    created(){
        this.token = document.head.querySelector('meta[name="csrf-token"]').getAttribute('content');
    },
    store
});


require('./bootstrap');

window.Vue = require('vue').default;
import UIkit from 'uikit';
import Icons from 'uikit/dist/js/uikit-icons';
UIkit.use(Icons);
window.UIkit = UIkit;
import store from './store';

Vue.component('editor', require('./components/Editor.vue').default);
Vue.component('slider', require('./components/Slider.vue').default);

Vue.component('alerts', require('./components/Alerts.vue').default);
Vue.component('upload', require('./components/Upload.vue').default);
Vue.component('courses-select', require('./components/CoursesSelect.vue').default);
Vue.component('delete-button', require('./components/DeleteButton').default);
Vue.component('test-container', require('./components/test/TestContainer.vue').default);
Vue.component('estimate_upload', require('./components/estimate_editor/EstimateUpload').default);

// Vue.component('vehicles', require('./components/Vehicles/Vehicles.vue').default);

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
});

Vue.directive('click-outside', {
    bind: function (el, binding, vnode) {
        el.clickOutsideEvent = function (event) {
            if (!(el == event.target || el.contains(event.target))) {
                vnode.context[binding.expression](event);
            }
        };
        document.body.addEventListener('click', el.clickOutsideEvent)
    },
    unbind: function (el) {
        document.body.removeEventListener('click', el.clickOutsideEvent)
    },
});

const app = new Vue({
    el: '#app',
    data(){
        return {token: ''}
    },
    created(){
        const {$,once,remove,transition,} = UIkit.util;
        window.onload = () => {
            const loader = $('#preloader');
            transition(loader, { opacity: 0 });
            once(loader, 'transitionend', () => remove(loader));
        };
        this.token = document.head.querySelector('meta[name="csrf-token"]').getAttribute('content');
    },
    store
});


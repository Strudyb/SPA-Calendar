
import Vue from 'vue'
import Vuesax from 'vuesax'
// Vue.use(Vuesax)

import './plugins/index.js'
import router from './router'



Vue.component('benim-ulkem', require('./components/BenimUlkem.vue').default);
Vue.component('benim-temsilcim', require('./components/BenimTemsilcim.vue').default);
Vue.component('benim-urunum', require('./components/BenimUrunum.vue').default);
Vue.component('ihracat-ulke-detayi', require('./components/IhracatUlkeDetayi.vue').default);
Vue.component('benim-urunum-ulke-detayi', require('./components/BenimUrunumUlkeDetayi.vue').default);
Vue.component('ihracat-ulke-tum-detaylari', require('./components/IhracatUlkeTumDetaylari.vue').default);
Vue.component('bilgi-bankasi-layout', require('./layouts/BilgiBankasiLayout.vue').default);


const app = new Vue({
    router,
    el: '#front-end',
});

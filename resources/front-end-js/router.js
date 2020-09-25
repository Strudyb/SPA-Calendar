

/*=========================================================================================
  File Name: router.js
  Description: Routes for vue-router. Lazy loading is enabled.
  Object Strucutre:
                    path => router path
                    name => router name
                    component(lazy loading) => component to load
                    meta : {
                      rule => which user can have access (ACL)
                      breadcrumb => Add breadcrumb to specific page
                      pageTitle => Display title besides breadcrumb
                    }
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: https:dijitalreklam.org
==========================================================================================*/


import Vue from 'vue'
import Router from 'vue-router'


Vue.use(Router)

const router = new Router({
  mode: 'history',
  base: process.env.BASE_URL,
  scrollBehavior () {
    return { x: 0, y: 0 }
  },
  routes: [

    {
        path: '',
        component: () => import('./layouts/BilgiBankasiLayout'),
        children: [

                {
                path: '/benim-ulkem',
                name: 'benim-ulkem',
                component: () => import('./components/BenimUlkem.vue'),
              },
                {
                path: '/benim-temsilcim',
                name: 'benim-temsilcim',
                component: () => import('./components/BenimTemsilcim.vue'),
              },
              {
                path: '/ihracat-ulke-detayi',
                name: 'ihracat-ulke-detayi',
                component: () => import('./components/IhracatUlkeDetayi.vue'),
                params:true,
              },
              {
                path: '/benim-urunum-ulke-detayi',
                name: 'benim-urunum-ulke-detayi',
                component: () => import('./components/BenimUrunumUlkeDetayi.vue'),
                params:true,
              },
              {
                path: '/ihracat-ulke-tum-detaylari',
                name: 'ihracat-ulke-tum-detaylari',
                component: () => import('./components/IhracatUlkeTumDetaylari.vue'),
                params:true
              },
              {
                path: '/ihracat-istatistik',
                name: 'ihracat-istatistik',
                component: () => import('./components/IhracatIstatistik.vue'),
                params:true
              },
              {
                path: '/benim-urunum',
                name: 'benim-urunum',
                component: () => import('./components/BenimUrunum.vue'),
              },
              {
                path: '/benim-temsilcim-detayi',
                name: 'benim-temsilcim-detayi',
                component: () => import('./components/BenimTemsilcimDetayi.vue'),
              },
        ]
    }
  ]
})

router.afterEach(() => {
  // Remove initial loading
  const appLoading = document.getElementById('loading-bg')
  if (appLoading) {
    appLoading.style.display = 'none'
  }
})


export default router

import axios from 'axios'
import Cookies from 'js-cookie'
import Vue from 'vue'


// Request interceptor


// Response interceptor
axios.interceptors.response.use(response => response, error => {
  const { status } = error.response
  const { config, response } = error
  const originalRequest = config

  //   if (status >= 500) {
  //     Swal.fire({
  //       type: 'error',
  //       title: i18n.t('error_alert_title'),
  //       text: i18n.t('error_alert_text'),
  //       reverseButtons: true,
  //       confirmButtonText: i18n.t('ok'),
  //       cancelButtonText: i18n.t('cancel')
  //     }).then(r => console.log('axios',r))
  //   }
  //console.log('rest', response)

  const instance = axios.create({
    withCredentials: false,
    headers: {
      'Access-Control-Allow-Origin' : '*',
      'Access-Control-Allow-Methods':'GET,PUT,POST,DELETE,PATCH,OPTIONS',
      }
  });

 // const userInfo = Cookies.get('user')
//   if (status && userInfo && status === 401 && response.config.url === '/api/user') {
//     axios.get('/api/refresh')
//       .then((response) => {
//         console.log('token', response.data)
//         originalRequest.headers.Authorization = `Bearer ${response.data}`
//         Cookies.remove('token')
//         Cookies.set('token', response.data)
//       })
//   }

//   if (!userInfo) {
//     Cookies.remove('user')
//     Cookies.remove('token')
//     router.push(router.currentRoute.query.to || '/panel/login')
//   }

  return Promise.reject(error)
})


export default axios

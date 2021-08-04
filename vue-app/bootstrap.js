/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import tokenservice from "./helpers/tokenservice";
import router from "./router";

import Vue from "vue";
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

window.axios.interceptors.request.use((config) => {
    // Do something before request is sent
     config.headers.authorization = tokenservice.gettoken(tokenservice.accesstoken);
     config.headers.Accept = "application/json";


    return config;
}, function (error) {
    // Do something with request error
    return Promise.reject(error);
});

window.axios.interceptors.response.use((response) => {
    // Do something with response data

    if (response.status === 401) {
        tokenservice.deletetoken(tokenservice.accesstoken);
        tokenservice.deletetoken(tokenservice.refreshtoken);
        router.push('/auth/login');

    }
    return response.data;
}, (error) => {
    if (error.response && error.response.status === 401) {
        //incases of 401 use refresh token to get a new access token


        tokenservice.deletetoken(tokenservice.accesstoken);
        tokenservice.deletetoken(tokenservice.refreshtoken);
        router.push('/auth/login');

    }
    if (error.response){
        return Promise.reject(error.response);
    }
    return Promise.reject(error);
});

Vue.prototype.$axios = window.axios;

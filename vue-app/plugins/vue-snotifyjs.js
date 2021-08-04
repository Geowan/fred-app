// Place the following into its own module file for easy import.
import Vue from 'vue'
import Snotify, { SnotifyPosition } from 'vue-snotify'

const options = {
    toast: {
        position: SnotifyPosition.rightBottom,
        timeout: 2000,
        showProgressBar:true
    },
};
Vue.use(Snotify, options);

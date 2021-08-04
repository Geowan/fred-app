import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);
import app from "./modules/app";
import inspectionform from "./modules/inspectionform/index"
import user from "./modules/user"

const store = new Vuex.Store({
    modules:{
        app,user,
        inspectionform
    }
});

export default store;

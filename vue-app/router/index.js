import Vue from 'vue'
import Router from 'vue-router'
import routes from './routes'
//helpers
import auth from '../helpers/authservice'
import tokenservice from '../helpers/tokenservice'

Vue.use(Router);

const router = new Router({
    routes:routes,
    mode:'hash',
    linkActiveClass: "active", // active class for non-exact links.
    linkExactActiveClass: "active", // active class for *exact* links.,
    duplicateNavigationPolicy: 'ignore'
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        auth.isLoggedin().then((res)=>{
            if(res){
                next()
            }else{
                tokenservice.settoken(tokenservice.redirrect_url,to.fullPath);
                next({
                    path: '/auth/login',
                    query: { redirect: to.fullPath }
                })
            }
        }, error=>{
            //set redirrect path
            tokenservice.settoken(tokenservice.redirrect_url,to.fullPath);
            next({
                path: '/auth/login',
            })
        });
        next();
    } else {
        next() // make sure to always call next()!
    }
});

//these requires a user to be a not loggedin
router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresGuest)) {
        auth.isLoggedin().then((res)=>{
            if(res.data){
                next({
                    path: '/',
                })
            }else{
                next()
            }
        }, error=>{
            next()
        });
        next();
    } else {
        next() // make sure to always call next()!
    }
});



export default router

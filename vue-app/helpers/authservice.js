/* eslint-disable space-before-function-paren */
import tokenservice from './tokenservice'
import store from "../store";

const authservice = {
    //logout and remove access and refresh tokens
    logout() {
        return new Promise((resolve, reject) => {
           //delete access token and refresh token
            tokenservice.deletetoken(tokenservice.accesstoken);
            tokenservice.deletetoken(tokenservice.refreshtoken);
            tokenservice.deletetoken(tokenservice.redirrect_url);
            resolve(true);
        });
    },

    isLoggedin() {
        return new Promise((resolve, reject) => {
            //check if access token is set
            if(!tokenservice.gettoken(tokenservice.accesstoken)){
                reject();
                return;
            }
            window.axios.get("/api/auth/active-user")
                .then(response =>{
                    store.commit("user/setData", response);
                    resolve(response)
                } , error=>reject(error))
                .catch(() => reject)
        });
    }


}

export default authservice

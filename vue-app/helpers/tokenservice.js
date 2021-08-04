/* eslint-disable space-before-function-paren */
const tokenservice = {
    accesstoken: 'sona_movie_access_token',
    refreshtoken: 'sona_movie_refresh_token',
    redirrect_url: 'sona_movie_redirrect_url',
    access_plant: 'access_plant',

    settoken(tokentype, token) {
        localStorage.setItem(tokentype, token);
    },

    gettoken(tokentype) {
        return localStorage.getItem(tokentype);
    },

    deletetoken(tokentype) {
        return localStorage.removeItem(tokentype);
    },

}

export default tokenservice

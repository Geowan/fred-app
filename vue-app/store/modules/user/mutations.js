export function setData(state,payLoad) {

    state.full_name = payLoad.full_name;
    state.email = payLoad.email;
}


export function setLoggedinStatus(state,payLoad){
    state.logged_in = payLoad;
}

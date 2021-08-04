export function setAppData(state,payLoad) {
    state.checklists = payLoad.checklists;
    state.checkist_category = payLoad.checkist_category;
    state.vehicles = payLoad.vehicles;
}


export function drawer_visibility(state, payload){
    state.show_drawer = payload;
}

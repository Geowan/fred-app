import Roles from "../roles/RolesLayout.vue";
import Users from "../users/Users";

const user_mgmt_routes = [
    {path:'', redirect:'roles'},
    {path:'roles', component:Roles},
    {path:'users', component:Users}

];
export default user_mgmt_routes;

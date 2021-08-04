import Login from "../login/Login";
import Register from "../register/Register";
const auth_routes = [
    {path: "", redirect: 'login'},
    {path: "login", component: Login},
    {path: "register", component: Register},
];

export default auth_routes;

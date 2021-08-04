import AdministativeLayout from "../administrative/AdministativeLayout";
import admin_routes from "../administrative/routes";

import UserManagementLayout from "../user-management/UserManagementLayout";

import user_mgmt_routes from "../user-management/routes";
import Inspections from "../inspections/Inspections";
import inspection_routes from "../inspections/routes";
import Dashboard from "@/components/app/dashboard/Dashboard";

const app_routes = [
    {path: '', redirect: 'user-management'},
    {path: 'dashboard', component: Dashboard},
    {path: 'inspections', component: Inspections, children: inspection_routes},
    {path: 'user-management', component: UserManagementLayout, children: user_mgmt_routes},
    {path: 'administrative', component: AdministativeLayout, children: admin_routes},
];

export default app_routes;

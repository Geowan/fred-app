import InspectionDashboard from "../dashboard/InspectionDashboard";
import NewInspection from "../new-inspection/NewInspection";
import InspectionCompletion from "../complete/InspectionCompletion";

const inspection_routes = [
    {path: '', redirect:'dashboard'},
    {path:'dashboard', component:InspectionDashboard},
    {path:'new', component:NewInspection},
    {path: 'complete', component: InspectionCompletion}
];
export default inspection_routes;
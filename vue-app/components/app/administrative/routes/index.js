import ChecklistCategoriesLayout from "../checklistcategories/ChecklistCategoriesLayout";
import Vehicles from "../vehicles/Vehicles";

const admin_routes = [
    {path:'', redirect:'checklist-category'},
    {path:'checklist-category', component:ChecklistCategoriesLayout},
    {path:'vehicles', component:Vehicles}

];

export default admin_routes;

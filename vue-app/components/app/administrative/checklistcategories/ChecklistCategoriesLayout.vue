<template>
    <v-row dense>
        <v-col md="4">
            <checklist-categories @deleted="category = {}" @onSelected="onSelected($event)"></checklist-categories>
        </v-col>
        <v-col md="8">
            <no-data-selection label="Select checklist category" v-if="Object.keys(category).length === 0"></no-data-selection>
            <div v-else>
                <checklist-items class="fill-width" :category="category"></checklist-items>
            </div>
        </v-col>
    </v-row>
</template>
<script>
    import ChecklistCategories from "./categories/ChecklistCategories";
    import ChecklistItems from "./items/ChecklistItems";

    export default {
        data:()=>({
           category:{}
        }),
        components:{
            ChecklistCategories,ChecklistItems
        },
        methods:{
            onSelected(category){
                console.log("category is ", category);
                this.category = category;
            }
        }

    }
</script>

<template>
<v-row>
    <v-col md="4">
        <roles v-model="role"></roles>
    </v-col>
    <v-col md="8">
        <v-alert v-if="Object.keys(role).length === 0" type="info">Select role to update permission/s</v-alert>
        <permissions v-else :role="role" ></permissions>
    </v-col>
</v-row>
</template>
<script>
import Roles from "./roles/Roles";
import Permissions from "./permissions/Permissions";
export default {
    data:()=>({
        role:{}
    }),
    components:{
        Roles,
        Permissions
    }

}
</script>

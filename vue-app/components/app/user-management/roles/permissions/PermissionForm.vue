<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
    <v-card>
        <v-toolbar
            dense
            color="primary"
            dark
        >
            <v-toolbar-title class="subtitle-1">{{itsUpdate > 0?"Update "+selected.name:"New permission"}}
            </v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn icon @click="$emit('closeForm')">
                <v-icon>mdi-close</v-icon>
            </v-btn>

        </v-toolbar>
        <validation-observer ref="user_form">
            <v-form>
                <v-card-text class="fill-width">
                    <v-select-validated item-text="name" item-value="id"  rules="required"
                                        label="Permission" :items="permissions" v-model="form.permission_id"/>
                </v-card-text>

            </v-form>
        </validation-observer>
        <v-divider></v-divider>
        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn @click="validateForm" :loading="processing" color="primary" text dark>
                {{itsUpdate > 0?"Update":"Save"}}
            </v-btn>
        </v-card-actions>
    </v-card>

</template>
<script>
export default {
    props: {
        selected: {
            type: Object,
            required: true
        },
        role: {
            type: Object,
            required: true
        }
    },
    data: () => ({
        form: {
            permission_id: '',
            role_id:'',
            id:''
        },
        processing:false,
        permissions:[]
    }),
    computed: {

        itsUpdate() {
            return Object.keys(this.selected).length > 0
        },
    },
    methods: {
        getPermissions(){
            //
            this.$axios.get("/api/user-management/all-permissions")
            .then((res)=>{
                this.permissions = res;
            },(err)=>{

            })
        },
        async validateForm() {
            if (await this.$refs.user_form.validate()){
                this.processing = true;
                this.$axios({
                    method:this.itsUpdate?'PUT':'POST',
                    url:'/api/user-management/role-permissions',
                    data:this.form
                }).then((res) => {
                    this.processing = false;
                    this.$emit('closeForm');
                }, (err) => {
                    this.processing = false;
                });
            }
        },
        setDetails() {
            this.form.role_id = this.role.id;
            if (this.itsUpdate) {
                this.form.permission_id = this.selected.permission_id;
                this.form.id = this.selected.id;
            }
        },

    },
    mounted() {
        this.setDetails();
        this.getPermissions();
    }

}
</script>

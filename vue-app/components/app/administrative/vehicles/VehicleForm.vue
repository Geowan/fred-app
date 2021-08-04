<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
    <v-card>
        <v-toolbar
                dense
                color="primary"
                dark
        >
            <v-toolbar-title class="subtitle-1">{{itsUpdate > 0?"Update "+selected.name:"New vehicle"}}
            </v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn icon @click="$emit('closeForm')">
                <v-icon>mdi-close</v-icon>
            </v-btn>

        </v-toolbar>
        <validation-observer ref="form">
            <v-form>
                <v-card-text>
                    <v-text-field-validated
                        v-model="form.reg_no"
                        label="Reg no"
                        rules="required"
                    ></v-text-field-validated>

                    <v-select-validated
                        :items="users"
                        item-text="full_name"
                        item-value="id"
                        v-model="form.user_id"
                        label="Allocate user"
                        rules="required"
                    ></v-select-validated>
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
            }
        },
        data: () => ({
            form: {
                reg_no: '',
                user_id:''
            },
            users:[],
            processing:false
        }),
        computed: {

            itsUpdate() {
                return Object.keys(this.selected).length > 0
            },
        },
        methods: {
            getFormData(){
                this.$axios.get("api/administrative/vehicles/form")
                .then((res)=>{
                    this.users = res.users
                },(err)=>{

                })

            },
            async validateForm() {
                if (await this.$refs.form.validate()){
                    this.processing = true;
                    this.$axios({
                        method:this.itsUpdate?'PUT':'POST',
                        url:'/api/administrative/vehicles',
                        data:this.form
                    }).then(() => {
                            this.processing = false;
                            this.$emit('closeForm');
                        }, () => {
                            this.processing = false;
                        });
                }
            },
            setDetails() {
                if (this.itsUpdate) {
                    this.form.name = this.selected.name;
                    this.form.id = this.selected.id;
                    this.form.duration = this.selected.duration;
                }
            },

        },
        mounted() {
            this.setDetails();
            this.getFormData();
        }

    }
</script>

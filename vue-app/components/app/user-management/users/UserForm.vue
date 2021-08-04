<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
    <v-card>
        <v-toolbar
            dense
            color="primary"
            dark
        >
            <v-toolbar-title class="subtitle-1">{{itsUpdate > 0?"Update "+selected.name:"New user"}}
            </v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn icon @click="$emit('closeForm')">
                <v-icon>mdi-close</v-icon>
            </v-btn>

        </v-toolbar>
        <validation-observer ref="user_form">
            <v-form>
                <v-card-text>
                    <v-text-field-validated
                        v-model="form.full_name"
                        label="Name"
                        rules="required"
                    ></v-text-field-validated>
                    <v-text-field-validated
                        v-model="form.email"
                        label="Email"
                        rules="required|email"
                    ></v-text-field-validated>
                    <v-text-field-validated
                        v-if="!itsUpdate"
                        v-model="form.password"
                        label="Password"
                        rules="required"
                        type="password"
                    ></v-text-field-validated>


                    <v-text-field-validated
                        v-model="form.phone"
                        label="Phone no"
                        rules="required"
                    ></v-text-field-validated>

                    <v-select-validated :items="roles" label="Role"
                                        v-model="form.role"
                                        item-text="name"
                                        item-value="id"/>
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
            full_name: '',
            email: '',
            phone: '',
            password: '',
            picture:''
        },
        roles:[],
        processing:false
    }),
    computed: {

        itsUpdate() {
            return Object.keys(this.selected).length > 0
        },
    },
    methods: {
        async validateForm() {
            if (await this.$refs.user_form.validate()){
                this.processing = true;
                this.$axios({
                    method:this.itsUpdate?'PUT':'POST',
                    url:'/api/user-management/users',
                    data:this.form
                }).then((res) => {
                    this.processing = false;
                    this.$emit('closeForm');
                }, (err) => {
                    this.processing = false;
                });
            }
        },
        getFormDetails(){
            this.$axios({
                method:'GET',
                url:'/api/user-management/user/form-data',
                data:this.form
            }).then((res) => {
                this.processing = false;
                this.roles = res.roles;
                console.log("Res is ", res);
            }, (err) => {
                this.processing = false;
            });
        },
        setDetails() {
            if (this.itsUpdate) {
                this.form.full_name = this.selected.full_name;
                this.form.id = this.selected.id;
                this.form.email = this.selected.email;
                this.form.phone = this.selected.phone;
            }
        },

    },
    mounted() {
        this.setDetails();
        this.getFormDetails();
    }

}
</script>

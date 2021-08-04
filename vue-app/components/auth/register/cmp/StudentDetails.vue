<template>
    <v-card flat>
        <v-card-text>
            <validation-observer ref="item_form">
                <v-row>
                    <v-col md="6">
                        <v-text-field-validated label="Name" rules="required" v-model="form.name"/>
                        <v-text-field-validated label="Email" rules="required|email" v-model="form.email"/>
                        <v-text-field-validated label="Qualification" v-model="form.qualification"/>

                    </v-col>
                    <v-col md="6">
                        <v-text-field-validated label="Mobile phone no" rules="required" v-model="form.mobile"/>
                        <v-text-field-validated type="password" label="Password" rules="required" v-model="form.password"/>

                    </v-col>
                </v-row>

            </validation-observer>
        </v-card-text>
        <v-card-actions>
            <v-btn text small to="/auth/login" color="primary" class="text-none body-2 text-decoration-underline">
                Already have an account
            </v-btn>
            <v-spacer></v-spacer>
            <v-btn :loading="form_submitted" @click="verifyForm" small class="text-none font-weight-bold"
                   color="primary" outlined>Register
            </v-btn>
        </v-card-actions>
    </v-card>
</template>
<script>
import tokenservice from "../../../../helpers/tokenservice";

export default {
    data:()=>({
        form:{
            name:'',
            mobile:'',
            email:'',
            password:'',
            qualification:''
        },
        form_submitted:false
    }),
    methods:{
        async verifyForm() {
            if (await this.$refs.item_form.validate()) {

                this.$axios.post("/api/auth/register", this.form).then((res) => {
                    this.form_submitted = false;
                    tokenservice.settoken(tokenservice.accesstoken, res.token);
                    this.$router.push("/");
                }, (err) => {
                    this.form_submitted = false;
                    this.$swal({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Unable to process your request, refresh the page and try again'
                    });
                });


            }
        },


    }
}
</script>



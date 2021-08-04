<template>

    <v-row class="fill-height"  justify="center" align="center">
        <v-col xs="12" sm="12" md="6" lg="3"  class="ma-3" >

            <v-card light>
                <v-card-text class="pt-10 text-center">
                    <h5 class="title font-weight-bold">Login to your account</h5>
                </v-card-text>
                <v-card-text>
                    <validation-observer ref="form">
                        <v-text-field-validated class="fill-width" v-model="form.email" rules="required|email" dense outlined
                                                label="Email"></v-text-field-validated>
                        <v-text-field-validated class="fill-width" type="password" v-model="form.password" rules="required"
                                                dense outlined
                                                label="Password"></v-text-field-validated>

                    </validation-observer>

                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-btn to="/" text
                           :ripple="false"
                           class="text-none font-weight-bold"
                           color="primary" outlined>Forgot password
                    </v-btn>
                    <v-spacer></v-spacer>
                    <v-btn  :loading="processing" @click="attemptLogin"
                            class="text-none font-weight-bold"
                            color="primary" outlined>Login
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-col>
    </v-row>
</template>
<script>
import tokenservice from "../../../helpers/tokenservice";

export default {
    data: () => ({
        form: {
            email: '',
            password: ''
        },
        processing: false
    }),
    methods: {
        async attemptLogin() {
            if (await this.$refs.form.validate()) {
                this.processing = true;
                this.$axios.post("/api/auth/login", this.form).then((res) => {
                    this.processing = false;
                    tokenservice.settoken(tokenservice.accesstoken, res.token);
                    this.$router.push("/app/inspections/dashboard");
                }, (err) => {
                    this.processing = false;
                    this.$swal({
                        icon: 'error',
                        title: 'Oops...',
                        text: err.data.message
                    });
                });
            }
        }
    },
}
</script>

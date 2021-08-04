<template>

    <v-row class="fill-height"  justify="center" align="center">
        <v-col xs="12" sm="12" md="6" lg="6"  class="ma-3" >
            <v-card light class="fill-height">
                <v-toolbar light dense color="transparent">
                    <v-toolbar-title class="subtitle-1 font-weight-bold">Register</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-btn to="/auth/login" color="primary" outlined small class="text-none">Login</v-btn>
                </v-toolbar>
                <v-card-text>

                    <validation-observer ref="form">
                        <v-select-validated item-text="label" item-value="value" v-model="form.option" :items="options" label="Register as" rules="required" />

                        <template v-if="form.option ===1">
                            <institute-details ref="form_details"></institute-details>
                        </template>

                        <template v-if="form.option ===2">
                            <student-details ref="form_details"></student-details>
                        </template>

                    </validation-observer>

                </v-card-text>
            </v-card>
        </v-col>
    </v-row>
</template>
<script>
    import tokenservice from "../../../helpers/tokenservice";
    import {ValidationProvider} from "vee-validate";

    import {extend} from "vee-validate";
    import SorDatePicker from "../../common/forms/SorDatePicker";
    import InstituteDetails from "./cmp/InstituteDetails";
    import StudentDetails from "./cmp/StudentDetails";

    export default {
        components: {SorDatePicker, ValidationProvider,InstituteDetails,StudentDetails},
        data: () => ({
            form: {
                option: '',
            },
            accept: 0,
            form_submitted: false,
            verifying_age: false,
            verifying_email: false,
            options:[{label:'Institute/trainer', value:1},{label:'Student', value:2}]
        }),
        methods: {

        }
    }
</script>

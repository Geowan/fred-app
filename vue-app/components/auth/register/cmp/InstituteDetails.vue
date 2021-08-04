<template>
    <validation-observer ref="item_form">
        <v-stepper v-model="step">
            <v-stepper-header>
                <v-stepper-step
                    :complete="step > 1"
                    step="1"
                >
                    Details
                </v-stepper-step>

                <v-divider></v-divider>

                <v-stepper-step
                    :complete="step > 2"
                    step="2"
                >
                    Trainer/s
                </v-stepper-step>

                <v-divider></v-divider>

                <v-stepper-step step="3">
                    Courses
                </v-stepper-step>
            </v-stepper-header>

            <v-stepper-items>
                <v-stepper-content step="1">
                    <v-card>
                        <validation-observer ref="details">
                            <v-row>
                                <v-col md="6" cols="12">
                                    <v-text-field-validated label="Institute name" rules="required" v-model="form.name"/>
                                    <v-file-input label="Institute Logo/pic" v-model="form.logo"/>
                                    <v-text-field-validated label="Address" rules="required" v-model="form.address"/>
                                    <v-text-field-validated label="About institute" rules="required" v-model="form.about"/>
                                </v-col>
                                <v-col md="6" cols="12">
                                    <v-text-field-validated label="Mobile phone no" rules="required" v-model="form.mobile_no"/>
                                    <v-text-field-validated label="Password" rules="required" v-model="form.password"/>
                                    <v-text-field-validated label="Bank details" rules="required" v-model="form.bank_details"/>
                                    <v-text-field-validated label="Social profile url" rules="required" v-model="form.social"/>
                                </v-col>
                            </v-row>

                        </validation-observer>

                        <v-divider></v-divider>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn small
                                color="primary"
                                @click="toTrainers()"
                            >
                                Next
                            </v-btn>
                        </v-card-actions>
                    </v-card>


                </v-stepper-content>

                <v-stepper-content step="2">
                    <v-card>
                        <v-card-text>
                            <validation-observer ref="trainer_form">
                                <template v-for="(trainer,key) in form.trainers">
                                    <v-row>
                                        <v-col md="5">
                                            <v-text-field-validated rules="required" label="Name" v-model="trainer.name"/>
                                        </v-col>
                                        <v-col md="5">
                                            <v-file-input v-model="trainer.pic" label="Pic"/>
                                        </v-col>
                                        <v-col md="2">
                                            <v-btn rounded color="primary" icon @click="form.trainers.push( {name:'', pic:''})"><v-icon>mdi-plus</v-icon>
                                            </v-btn>
                                            <v-btn v-if="form.trainers.length > 1" icon @click="form.trainers.splice(key, 1)"><v-icon>mdi-close</v-icon></v-btn>
                                        </v-col>
                                    </v-row>
                                </template>
                            </validation-observer>

                        </v-card-text>
                        <v-divider></v-divider>
                        <v-card-actions>

                            <v-spacer></v-spacer>
                            <v-btn
                                color="primary"
                                @click="toCourses()"
                            >
                                Continue
                            </v-btn>
                        </v-card-actions>

                    </v-card>
                </v-stepper-content>
                <v-stepper-content step="3">
                    <v-card>
                        <v-card-text>
                            <validation-observer ref="course_form">
                                <template v-for="(course,key) in form.courses_offered">
                                    <v-row>
                                        <v-col md="10">
                                            <v-text-field-validated rules="required" label="Course name" v-model="course.name"/>
                                        </v-col>
                                        <v-col md="2">
                                            <v-btn rounded color="primary" icon @click="form.trainers.push( {name:'', pic:''})"><v-icon>mdi-plus</v-icon>
                                            </v-btn>
                                            <v-btn v-if="form.trainers.length > 1" icon @click="form.trainers.splice(key, 1)"><v-icon>mdi-close</v-icon></v-btn>
                                        </v-col>
                                    </v-row>
                                </template>
                            </validation-observer>

                        </v-card-text>
                        <v-divider></v-divider>
                        <v-card-actions>

                            <v-spacer></v-spacer>
                            <v-btn
                                color="primary"
                                @click="submitData()"
                            >
                               Submit
                            </v-btn>
                        </v-card-actions>

                    </v-card>
                </v-stepper-content>
            </v-stepper-items>
        </v-stepper>
    </validation-observer>
</template>
<script>
import tokenservice from "../../../../helpers/tokenservice";

export default {
    data:()=>({
        form:{
            name:'',
            logo:null,
            address:'',
            mobile_no:'',
            password:'',
            courses_offered:[
                {name:''}
            ],
            about:'',
            trainers:[
                {name:'', pic:''}
            ],
            bank_details:'',
            social:''
        },
        form_submitted:false,
        step:1
    }),
    methods:{
        async toTrainers(){
            if (await this.$refs.details.validate()){
                this.step = 2;
            }

        },
        async toCourses(){
            if (await this.$refs.trainer_form.validate()){
                this.step = 3;
            }

        },
        async submitData(){
            if (await this.$refs.course_form.validate()){

            }
        },
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

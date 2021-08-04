<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
    <v-card>
        <v-toolbar
            dense
            color="primary"
            dark
        >
            <v-toolbar-title class="subtitle-1">{{itsUpdate > 0?"Update user "+selected.email:"New User"}}
            </v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn icon @click="$emit('closeForm')">
                <v-icon>mdi-close</v-icon>
            </v-btn>

        </v-toolbar>
        <validation-observer ref="user_form">
            <v-form >
                <v-card-text>

                    <v-text-field-validated
                        v-model="form.email"
                        label="Email"
                        rules="required|email"
                    />

                  <v-select-validated
                      v-if="!itsUpdate"
                      item-text="name"
                      item-value="id"
                      label="Notification plants"
                      v-model="form.notification_plants"
                      :items="plants"
                      rules="required"
                      multiple
                      deletable-chips
                      small-chips
                      chips
                  />

                </v-card-text>

            </v-form>
        </validation-observer>
        <v-divider></v-divider>
        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn @click="validateForm" :loading="processing" color="primary" text dark>
                {{itsUpdate > 0?"Update":"Save "}}
            </v-btn>
        </v-card-actions>
    </v-card>

</template>
<script>
    import {extend} from 'vee-validate';
    import {mapState} from "vuex";


    export default {
        props: {
            selected: {
                type: Object,
                required: true
            }
        },
        data: () => ({
            form: {
                email: '',
              notification_plants: [],
            },

            processing: false,
        }),
        computed: {
            ...mapState({
                plants: state => state.app.plants,
           }),
            countries() {
                return this.$store.state.app.countries.map(country => {
                    return {name: country.name + " (" + country.code + ")", code: country.code}
                })
            },
            itsUpdate() {
                return Object.keys(this.selected).length > 0
            },
            plants() {
                return this.$store.state.app.plants;
            }
        },
        methods: {
             async validateForm() {
                if (await this.$refs.user_form.validate()) {
                    this.saveDetails();
                }
            },

            async saveDetails() {
                this.processing = true;
                this.$axios({
                    method:'POST',
                    url:'/api/email-notifications',
                    data:this.form
                }).then((res) => {
                    this.processing = false;
                    this.$emit('closeForm');
                }, (err) => {
                    this.processing = false;
                });
            },
            setAccountDetails() {
                if (this.itsUpdate) {
                    let selected = this.selected;
                    this.form.id = selected.id;
                    this.form.email = selected.email;
                  this.data_set = true;
                }
            }
        },
        mounted() {
            this.setAccountDetails();
        }

    }
</script>

<template>
    <ValidationProvider :name="$attrs.label" :rules="rules">
        <v-select
                slot-scope="{ errors, valid }"
                v-model="innerValue"
                :error-messages="errors"
                v-bind="$attrs"
                v-on="$listeners"
        >
            <template v-if="includeAdd" slot="append-outer">
                <v-menu
                    v-model="show_add_form"
                    :close-on-content-click="false"
                    :nudge-width="300"
                    offset-x
                >
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn   v-bind="attrs"
                                 v-on="on" fab rounded color="primary" x-small>
                            <v-icon>mdi-plus</v-icon>
                        </v-btn>
                    </template>

                    <v-card>
                        <v-toolbar dense> {{add_menu_title}} <v-spacer></v-spacer>
                           <v-btn @click="show_add_form = false" icon small> <v-icon>mdi-close</v-icon></v-btn>
                        </v-toolbar>
                        <v-card-text class="ma-0 pa-0 pl-2 pr-2">
                            <validation-observer ref="add_form_select">
                                <v-text-field-validated v-model="add_form.name" rules="required" label="Name"/>
                            </validation-observer>
                        </v-card-text>
                        <v-divider></v-divider>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn :loading="processing_add" @click="validateAddForm()" text class="text-none" color="primary">Save</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-menu>
            </template>
        </v-select>


    </ValidationProvider>
</template>

<script>
    import { ValidationProvider } from "vee-validate";

    export default {
        components: {
            ValidationProvider
        },
        props: {
            rules: {
                type: [Object, String],
                default: ''
            },
            value: {
                type: null
            },
            includeAdd:{
                type:Boolean,
                default:false
            },
            add_url:{
                type:String,
                default:''
            },
            add_menu_title:{
                type:String,
                default:''
            }
        },
        data: () => ({
            innerValue: '',
            show_add_form:false,
            processing_add:false,
            add_form:{
                name:''
            }
        }),
        watch: {
            // Handles internal model changes.
            innerValue (newVal) {
                this.$emit('input', newVal);
            },
            // Handles external model changes.
            value (newVal) {
                this.innerValue = newVal;
            }
        },
        methods:{
            async validateAddForm() {
                if (await this.$refs.add_form_select.validate()) {
                    this.processing_add = true;
                    this.$axios({
                        method: this.itsUpdate ? 'PUT' : 'POST',
                        url: this.add_url,
                        data: this.add_form
                    }).then((res) => {
                        this.processing_add = false;
                        this.$emit("added");
                        this.add_form.name = "";
                        this.show_add_form = false;
                    }, (err) => {
                        this.processing_add = false;
                        this.show_add_form = false;
                    });
                }
            },
        },
        created () {
            if (this.value) {
                this.innerValue = this.value;
            }
        }
    };
</script>

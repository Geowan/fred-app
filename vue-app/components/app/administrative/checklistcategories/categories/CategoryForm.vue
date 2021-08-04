<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
    <v-card>
        <v-toolbar
                dense
                color="primary"
                dark
        >
            <v-toolbar-title class="subtitle-1">{{itsUpdate > 0?"Update "+selected.name:"New category"}}
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
                        v-model="form.name"
                        label="Name"
                        rules="required"
                    ></v-text-field-validated>

                    <v-text-field-validated
                        v-model="form.duration"
                        label="Re-inspection duration"
                        rules="required"
                        prefix="Days"
                    ></v-text-field-validated>
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
                name: '',
                duration:''
            },
            processing:false
        }),
        computed: {

            itsUpdate() {
                return Object.keys(this.selected).length > 0
            },
        },
        methods: {
            async validateForm() {
                if (await this.$refs.form.validate()){
                    this.processing = true;
                    this.$axios({
                        method:this.itsUpdate?'PUT':'POST',
                        url:'/api/administrative/checklist-categories',
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
        }

    }
</script>

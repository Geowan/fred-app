<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
    <v-card>
        <v-toolbar
                dense
                color="primary"
                dark
        >
            <v-toolbar-title class="subtitle-1">{{itsUpdate > 0?"Update "+selected.name:"New checklist item"}}
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

                    <v-select-validated
                        item-text="label"
                        @change="form.fails_marked = ''"
                        item-value="value"
                        :items="mandatories"
                        v-model="form.mandatory"
                        label="Mandatory"
                        rules="required"
                    />

                    <v-select-validated
                        item-text="label"
                        v-if="form.mandatory === 'yes'"
                        item-value="value"
                        :items="mandatories"
                        v-model="form.fails_marked"
                        label="Fails when marked"
                        rules="required"
                    />
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
            category: {
                type: Object,
                required: true
            },
        },
        data: () => ({
            form: {
                name: '',
                mandatory:'',
                category_id:'',
                fails_marked:'',
                id:''
            },
            mandatories:[{label:"Yes",value:'yes'},{label:"No",value:'no'}],
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
                        url:'/api/administrative/checklist-items',
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
                this.form.category_id = this.category.id;
                if (this.itsUpdate) {
                    this.form.name = this.selected.name;
                    this.form.mandatory = this.selected.mandatory;
                    this.form.id = this.selected.id;
                    this.form.fails_marked = this.selected.fails_marked;
                }
            },

        },
        mounted() {
            this.setDetails();
        }

    }
</script>

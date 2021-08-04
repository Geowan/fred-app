<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
    <v-card>
        <v-toolbar
            dense
            color="primary"
            dark
        >
            <v-toolbar-title class="subtitle-1">{{itsUpdate > 0?"Update "+selected.name:"New role"}}
            </v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn icon @click="$emit('closeForm')">
                <v-icon>mdi-close</v-icon>
            </v-btn>

        </v-toolbar>
        <validation-observer ref="user_form">
            <v-form>
                <v-card-text class="fill-width">
                    <v-text-field-validated
                        v-model="form.name"
                        label="Name"
                        rules="required"
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
            if (await this.$refs.user_form.validate()){
                this.processing = true;
                this.$axios({
                    method:this.itsUpdate?'PUT':'POST',
                    url:'/api/user-management/roles',
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
            if (this.itsUpdate) {
                this.form.name = this.selected.name;
                this.form.id = this.selected.id;
            }
        },

    },
    mounted() {
        this.setDetails();
    }

}
</script>

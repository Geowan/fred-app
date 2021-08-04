<template>
    <v-menu
        ref="menu"
        @update:return-value="onUpdateReturnVal"
        v-model="menu"
        :close-on-content-click="false"
        :return-value.sync="date"
        transition="scale-transition"
        offset-y
        min-width="290px"
    >

        <template v-slot:activator="{ on, attrs }">
            <v-text-field-validated
                 v-model="date"
                :label="title"
                prepend-icon="mdi-calendar-range"
                readonly
                :rules="rules"
                v-on="on"
                outlined
                dense
                cancellable
            ></v-text-field-validated>
        </template>
        <v-date-picker v-model="date" no-title scrollable>
            <v-spacer></v-spacer>
            <v-btn text color="primary" @click="menu = false">Cancel</v-btn>
            <v-btn text color="primary" @click="$refs.menu.save(date)">OK</v-btn>
        </v-date-picker>
    </v-menu>
</template>
<script>
    import {extend} from "vee-validate";

    export default {
        props:{
            title:{
                type:String,
                default:'Select date'
            },
            rules: {
                type: [Object, String],
                default: ''
            }

        },
        data:()=>({
            date: null,
            menu:false
        }),
        mounted() {
            this.$emit("input",this.date);
        },
        methods:{
            onUpdateReturnVal(event){
                console.log("res is ", event);
                this.$emit("input",event)
            }
        }

    }

</script>

<template>
    <v-card flat class="" :height="$vuetify.breakpoint.height * 0.7">
        <v-row  class="fill-height"  justify="center" align="center">
            <v-col xs="12" sm="12" md="6" lg="4"  class="ma-3" >
                <h1 class="title">{{label}}</h1>
            </v-col>
        </v-row>
    </v-card>

</template>
<script>
    export default {
        props:{
            label:{
                type:String,
                default:'Select items'
            }
        }

    }
</script>

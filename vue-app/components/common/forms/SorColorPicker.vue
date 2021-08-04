<template>
    <v-menu :close-on-content-click="false" offset-x z-index="10000">
        <template v-slot:activator="{ on }">
            <v-btn
                block
                :color="color"
                dark
                v-on="on"
            >
                {{title}}
            </v-btn>
        </template>
        <v-card>
            <v-card-text>
                <v-color-picker
                    canvas-height="300"
                    elevation="1"
                    value="#7417BE"
                    v-model="color"
                    class="mx-auto"
                ></v-color-picker>
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn @click="$emit('onColorSet',color)" small color="primary" outlined>Set</v-btn>
            </v-card-actions>

        </v-card>

    </v-menu>
</template>
<script>
    export default {
        props:{
            title:{
                type:String,
                default:'Select color'
            }
        },
        data:()=>({
            color:'#00000'
        })

    }

</script>

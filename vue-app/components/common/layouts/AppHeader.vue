<template>
    <v-app-bar dense app>
        <v-toolbar-items>
            <v-btn flat v-for="(menu,key) in left_menu" class="text-none font-weight-bold body-1" text :key="key">
                {{menu.name}}
            </v-btn>
        </v-toolbar-items>

        <v-spacer></v-spacer>
        <app-logo class="text-center"></app-logo>
        <v-spacer></v-spacer>
        <v-btn text class="text-none">
            <v-icon left>mdi-search</v-icon>
            Search
        </v-btn>
        <v-btn text>Profile</v-btn>

    </v-app-bar>
</template>
<script>
    export default {
        data: () => ({
            left_menu: [
                {name: 'Home', to: ''},
                {name: 'Series', to: ''},
                {name: 'Movies', to: ''},
                {name: 'My List', to: ''},
            ]
        })

    }
</script>

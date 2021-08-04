<template>
    <div>
        <v-app-bar dense clipped-left app>
            DEMO 2- V2
        </v-app-bar>
        <v-navigation-drawer v-if="user.logged_in" class="mt-1" app clipped v-model="app.show_drawer">
            <v-card flat color="transparent">
                <v-card-text class="text-center mt-0 mb-0 pb-0">
                    <v-list-item>
                        <v-list-item-content>
                            <v-list-item-title class="body-2">{{user.full_name}}</v-list-item-title>
                            <v-list-item-title class="body-2">{{user.email}}</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-divider></v-divider>
                </v-card-text>
            </v-card>


            <v-list dense>
                <div v-for="item in items">
                    <v-list-group
                        :value="item.key && $route.matched.filter(key_item=>key_item.path === item.key).length > 0"
                        v-if="item.children"
                        :prepend-icon="item.icon"
                        no-action
                    >
                        <template v-slot:activator>
                            <v-list-item-title>{{ item.title }}</v-list-item-title>
                        </template>
                        <v-list-item
                            v-if="(!(child.permission && permissions && permissions.length > 0 && !permissions.includes(child.permission)))"
                            :to="child.to"
                            v-for="(child,child_key) in item.children"
                            :key="child_key"
                            link
                        >
                            <v-list-item-title class="text-wrap"
                                               v-text="child.title"></v-list-item-title>

                            <v-list-item-icon>
                                <v-icon small>mdi-chevron-right</v-icon>
                            </v-list-item-icon>
                        </v-list-item>
                    </v-list-group>
                    <v-list-item class="mt-1 mb-1" v-else :to="item.to">
                        <v-list-item-icon>
                            <v-icon size="20">{{item.icon}}</v-icon>
                        </v-list-item-icon>
                        <v-list-item-title>{{ item.title }}</v-list-item-title>
                    </v-list-item>

                </div>

                <v-list-item @click="logoutUser">
                    <v-list-item-icon>
                        <v-icon size="20">mdi-logout</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title> Logout </v-list-item-title>
                </v-list-item>
            </v-list>

        </v-navigation-drawer>
        <v-main class="fill-height" >
            <v-container fluid>
                <router-view></router-view>
            </v-container>
        </v-main>
    </div>
</template>
<script>
import tokenservice from "@/helpers/tokenservice";
import {mapState} from "vuex"
export default {

    data: () => ({
        show_page: true,
        items: [
            {title: 'Dashboard', icon: 'mdi-home-city',to:'/app/dashboard'},
            {title: 'Inspections', icon: 'mdi-home-city',to:'/app/inspections'},

            {title: 'User manager', icon: 'mdi-home-city',to:'/app/users',
                key:'/app/user-management',
                children:[
                    {title: 'Users', icon: 'mdi-home-city',to:'/app/user-management/users'},
                    {title: 'Roles', icon: 'mdi-home-city',to:'/app/user-management/roles'},
                ]
            },
            {title: 'Administrative', icon: 'mdi-home-city',to:'/app/email-notification',
                key: "/app/administrative",
                children:[
                    {title: 'Checklist category', icon: 'mdi-cog',to:'/app/administrative/checklist-category'},
                        {title: 'Vehicles', icon: 'mdi-cog',to:'/app/administrative/vehicles'},
                ]
            },
        ],
    }),
    computed: {
        ...mapState({
            app: state => state.app,
            user: state => state.user
        })
    },
    methods:{
        logoutUser(){
            tokenservice.deletetoken(tokenservice.accesstoken);
            tokenservice.deletetoken(tokenservice.redirrect_url);
            this.$store.commit("user/setLoggedinStatus", false);
            this.$router.push("/auth")
        },
        showMenu(permission){
            return (!(permission && this.permissions && this.permissions.length > 0 && !this.permissions.includes(permission)));
        }
    },
    mounted() {
        this.show_page = false;
        this.$store.dispatch("user/getActiveUser");

    }


}
</script>

<style type="text/css">
.v-application--wrap{
    min-height: unset!important;
}

.v-btn--text{
    border: none!important;
}
</style>

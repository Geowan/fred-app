<template>
    <v-app class="fill-height">
        <router-view></router-view>
        <vue-snotify></vue-snotify>
    </v-app>
</template>
<script>
export default {


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

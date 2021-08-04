/*
import Vue from 'vue';
import Vuetify from 'vuetify/lib';
Vue.use(Vuetify);

export default new Vuetify({
    theme: {
        light:true,
        primary: colors.red,
        secondary: colors.green.darken1,
        accent: colors.shades.black,
        error: colors.red.accent3,
    },
})
*/
import Vue from 'vue';
import Vuetify from 'vuetify/lib/framework';
import colors from 'vuetify/lib/util/colors';
Vue.use(Vuetify);

export default new Vuetify({
    theme: {
        options: {
            customProperties: true,
        },
        themes: {
            light: {
                primary: colors.green.darken1,
                secondary: colors.green.darken1,
                accent: colors.shades.black,
                error: colors.red.accent3,
                info: '#2196F3',
                success: '#4CAF50',
                warning: '#FFC107'
            },
        },
    },
});

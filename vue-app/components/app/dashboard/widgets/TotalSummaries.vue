<template>
    <v-card>
        <v-progress-circular indeterminate v-if="loading"></v-progress-circular>
        <v-card-text>
            <v-row dense>
                <v-col :md="item.md" v-for="(item,key) in summaries" :key="key">
                    <v-card @click="openSummary(item.key)" dark hover :color="item.color" class="darken-3 fill-height">
                        <v-card-text class="text-center">
                            <h3 class="display-1"> {{ item.value }}</h3>
                            <h1 class="body-2 font-weight-bold">
                                {{ $vuetify.breakpoint.mdAndUp ? item.name : item.btn_label }}</h1>
                        </v-card-text>
                        <v-divider></v-divider>
                        <v-card-actions v-if="false">
                            <v-spacer></v-spacer>
                            <v-btn :to="item.to" outlined v-if="selected !== item.key" small class="text-none">Open
                                {{ item.btn_label }}
                            </v-btn>
                            <v-spacer></v-spacer>
                        </v-card-actions>
                    </v-card>
                </v-col>
            </v-row>
        </v-card-text>
    </v-card>
</template>
<script>
export default {
    props: {
        filter: {
            type: Object,
            required: true

        }
    },
    watch: {
        filter: {
            handler: function () {
                this.getSummaries();
            },
            deep: true
        },
    },
    data: () => ({
        loading: false,
        summaries: [],
        selected: 'total'
    }),
    methods: {
        openSummary(item) {
            this.selected = item;
            this.$emit('input', item);
        },
        getSummaries() {
            this.loading = true;
            this.$axios.post('reports/default/summaries', this.filter).then((res) => {
                console.log("res is ", res);
                this.loading = false;
                this.summaries = [];
                this.summaries.push({
                    name: 'Total inspections',
                    btn_label: 'Totals',
                    md: 4,
                    value: res.totals,
                    color: 'primary',
                    key: 'total'
                });
                this.summaries.push({
                    name: 'Passed inspections',
                    btn_label: 'Passed',
                    md: 4,
                    value: res.passed,
                    color: 'green',
                    key: 'passed'
                });
                this.summaries.push({
                    name: 'Failed inspections',
                    btn_label: 'Failed',
                    md: 4,
                    value: res.failed,
                    color: 'error',
                    key: 'failed'
                });

                // this.summaries.push({name:'Waivered inspections',btn_label:'Waivered',md:3, value:res.data.waivered, color:'secondary',key:'waivered'});
                //this.summaries.push({name:'Rejected inspections',btn_label:'Rejected',md:3, value:res.data.rejected, color:'error',key:'rejected'});
            }, (err) => {
                this.loading = false;
                this.summaries = [];
            })

        }
    },
    mounted() {
        this.openSummary('total');
    }
}
</script>

<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
    <v-card>
        <v-dialog width="80%" v-model="show_form" v-if="show_form">
            <insp-details @close="show_form = false" :selected="selected"></insp-details>
        </v-dialog>
        <v-toolbar dense>
            Inspections

            <v-text-field v-model="globalFilter" clearable class="ml-3" append-icon="mdi-magnify"
                          label="Search by reg no"
                          solo dense hide-details></v-text-field>
            <v-spacer></v-spacer>
            <v-btn to="/app/inspections/new" fab x-small dark color="primary" rounded>
                <v-icon>mdi-plus</v-icon>
            </v-btn>



            <download-excel :data="items">
                <v-btn class="ml-2 text-none" dark color="primary">
                    Export report
                </v-btn>
            </download-excel>
        </v-toolbar>
        <v-card-text>
            <v-data-table
                :loading="data_loading"
                :headers="fields"
                :items="items"
                :mobile-breakpoint="0"
                loading-text="loading ....."
                no-data-text="No data found"
                no-results-text="No results found"
                :options.sync="pagination"
                :items-per-page="5"
                @update:options="getData"
                :server-items-length="totalRecords"
                :footer-props="{
                      showFirstLastPage: true,
                      'items-per-page-options': [5,10,15,20],
                   }"
            >
                <template slot="item" slot-scope="props">
                    <tr @click="selected = props.item;$emit('selected', props.item)" class="cursor-pointer"
                        :class="{'active':selected.id === props.item.id}">

                        <td class="text-xs-left caption">
                            {{ props.item.no + 1 }}
                        </td>
                        <td class="text-xs-left caption">{{ props.item.category }}</td>
                        <td class="text-xs-left caption">{{ props.item.reg_no }}</td>
                        <td class="text-xs-left caption">{{ props.item.driver }}</td>
                        <td class="text-xs-left caption">{{ props.item.created_at }}</td>
                        <td class="text-xs-center">
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on }">
                                    <v-btn v-on="on" @click="selected = props.item;show_form = true;" icon>
                                        <v-icon small>mdi-eye</v-icon>
                                    </v-btn>
                                </template>
                                <span class="caption">More details</span>
                            </v-tooltip>
                        </td>
                    </tr>
                </template>
            </v-data-table>
        </v-card-text>
    </v-card>
</template>
<script>
import table_mixin from "../../../common/mixins/table_mixin";
import InspDetails from "@/components/app/inspections/dashboard/Details";

export default {
    data: () => ({
        globalFilter: ''
    }),
    mixins: [table_mixin],
    watch: {
        globalFilter(val) {
            this.getData();
        }
    },
    components: {
        InspDetails
    },
    methods: {
        /**
         * Fetches a list of permission categories with pagination results
         */
        getData() {
            this.data_loading = true;
            this.$axios.get(
                '/api/app/inspection/index?page='
                + (this.pagination.page - 1) + '&perPage=' + this.pagination.itemsPerPage + '&globalFilter=' + this.globalFilter
            ).then((res) => {
                this.data_loading = false;
                this.totalRecords = res.data.totalRecords;
                this.items = res.data;
                this.items.map((item, key) => {
                    item.no = key + ((this.pagination.page - 1) * this.pagination.itemsPerPage);//this.pagination.page;
                });
            }, (err) => {
                this.data_loading = false;
            })
        },
        getFields() {
            this.fields = [
                {text: "#", align: "left", value: "no", sortable: false, width: "1%"},
                {text: "Inspection", sortable: true, value: "name"},
                {text: "Reg no", sortable: true, value: "name"},
                {text: "Driver name", sortable: true, value: "name"},
                {text: "Date", sortable: false},
                {text: "Actions", sortable: false}
            ];
        }
    }

}
</script>

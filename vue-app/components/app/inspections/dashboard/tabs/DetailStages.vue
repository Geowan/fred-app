<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
  <v-card>

    <v-toolbar dense>
      {{ inspection.inspection_item }} stages
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

            <td class="text-xs-left caption"> {{ props.item.no + 1 }} </td>
            <td class="text-xs-left caption"> {{ props.item.status_name }} </td>
            <td class="text-xs-left caption"> {{ props.item.date }} </td>
            <td class="text-xs-left caption"> {{ props.item.created_by }} </td>

          </tr>
        </template>
      </v-data-table>
    </v-card-text>
  </v-card>
</template>
<script>
import table_mixin from "../../../../common/mixins/table_mixin";

export default {
  data: () => ({
    globalFilter: ''
  }),
  props:{
    inspection:{
      type:Object,
      required:true
    }
  },
  mixins: [table_mixin],
  watch: {
    globalFilter(val) {
      this.getData();
    }
  },

  methods: {
    /**
     * Fetches a list of permission categories with pagination results
     */
    getData() {
      this.data_loading = true;
      this.$axios.post('app/inspection/history', {
        page: this.pagination.page - 1, perPage: this.pagination.itemsPerPage,
        inspection_id:this.inspection.id
      }).then((res) => {
        this.data_loading = false;
        this.totalRecords = res.data.totalRecords;
        this.items = res.data.data;
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
        {text: "Status", sortable: true, value: "name"},
        {text: "Date", sortable: true, value: "name"},
        {text: "Done by", sortable: true, value: "name"},
      ];
    }
  }

}
</script>

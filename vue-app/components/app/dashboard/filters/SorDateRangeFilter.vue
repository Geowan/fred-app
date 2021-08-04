<template>
  <v-menu :close-on-content-click="false" offset-y v-model="show_menu">
    <template v-slot:activator="{ on, attrs }">
      <v-btn outlined
             dark x-small
             v-bind="attrs"
             v-on="on"
             class="text-none ml-2" color="primary" small>
            {{btn_label}} <v-icon right>mdi-cellphone-arrow-down</v-icon>
      </v-btn>
    </template>
    <v-list dense>
      <v-list-item exact class="body-2" @click="thisWeek()">This week</v-list-item>
      <v-divider></v-divider>
      <v-list-item exact class="body-2" @click="thisMonth()">This month</v-list-item>

      <v-divider></v-divider>
      <v-list-item class="body-2" @click="lastOneMonth()">Last month</v-list-item>
      <v-divider></v-divider>
      <v-list-item class="body-2" @click="lastOneWeek()">Last week</v-list-item>
      <v-divider></v-divider>
      <v-list-item class="body-2" @click="today()">Today</v-list-item>
      <v-divider></v-divider>
      <v-menu :close-on-content-click="false" offset-x v-model="show_custom_date">
        <template v-slot:activator="{ on, attrs }">
          <v-list-item class="body-2" v-bind="attrs"
                       v-on="on" @click="customRange()">Custom date
          </v-list-item>
        </template>
        <v-card>
          <v-toolbar dense> Custom date range</v-toolbar>
          <v-card-text>
            <v-datetime-picker dense label="From" v-model="custom_form.from"> </v-datetime-picker>
            <v-datetime-picker dense label="To" v-model="custom_form.to"> </v-datetime-picker>
          </v-card-text>
          <v-divider></v-divider>
          <v-card-actions>
            <v-btn @click="show_custom_date = false" small outlined class="text-none">Cancel</v-btn>
            <v-spacer></v-spacer>
            <v-btn @click="customRange()" small outlined class="text-none" color="primary">Save</v-btn>
          </v-card-actions>
        </v-card>
      </v-menu>
    </v-list>
  </v-menu>
</template>
<script>
import moment from "moment";

export default {
  data: () => ({
    show_menu: false,
    show_custom_date: false,
    filter:{
      label:'',
      value:{
        from:'',
        to:'',
        days:false,
        hours:false
      }
    },
    custom_form:{from:'', to:''},
    btn_label:'',
    format:''
  }),
  methods: {
    thisWeek() {
      let month_start = moment().clone().utcOffset('+0300').subtract(6, 'days').startOf('day');
      let current_date = moment().clone().utcOffset('+0300');
      this.filter.value.from = month_start.format('YYYY-MM-DD HH:mm');
      this.filter.value.to = current_date.format('YYYY-MM-DD HH:mm');
      this.btn_label = "Date: "+ month_start.format("DD-MMMM")+ " to "+current_date.format("DD-MMMM");
      this.$emit("input", this.filter.value);
      this.setFilterDayMonths(true, false);

      this.show_menu = false;
    },
    setFilterDayMonths(days,hours){
      this.filter.value.days = days;
      this.filter.value.hours = hours;
    },
    thisMonth() {
      this.setFilterDayMonths(true, false);
      let month_start = moment().clone().utcOffset('+0300').startOf('month');
      let current_date = moment().clone().utcOffset('+0300');
      this.filter.value.from = month_start.format('YYYY-MM-DD HH:mm');
      this.filter.value.to = current_date.format('YYYY-MM-DD HH:mm');
      this.btn_label = "Date: "+ month_start.format("DD-MMMM")+ " to "+current_date.format("DD-MMMM");
      this.$emit("input", this.filter.value);
      this.show_menu = false;
    },
    lastOneMonth() {
      let first_item = new moment().subtract(1, 'months').startOf('month');
      let last_item = new moment().subtract(1, 'months').endOf('month');
      this.setFilterDayMonths(true, false);

      this.filter.value.from = first_item.format('YYYY-MM-DD HH:mm');
      this.filter.value.to = last_item.format('YYYY-MM-DD HH:mm');
      this.btn_label = "Date: "+ first_item.format("DD-MMMM")+ " to "+last_item.format("DD-MMMM");
      this.$emit("input", this.filter.value);
      this.show_menu = false;

    },
    lastOneWeek() {
      this.setFilterDayMonths(true, false);

      let first_item = new moment().subtract(1, 'weeks').startOf('day');
      let last_item = moment().clone().utcOffset('+0300');

      this.filter.value.from = first_item.format('YYYY-MM-DD HH:mm');
      this.filter.value.to = last_item.format('YYYY-MM-DD HH:mm');
      this.btn_label = "Date: "+  first_item.format("DD-MMMM")+ " to "+last_item.format("DD-MMMM");
      this.$emit("input", this.filter.value);
      this.show_menu = false;
    },
    today() {
      this.setFilterDayMonths(false, true);

      let first_item = new moment().startOf('day').utcOffset('+0300');
      let last_item = new moment().utcOffset('+0300');

      this.filter.value.from = first_item.format('YYYY-MM-DD HH:mm');
      this.filter.value.to = last_item.format('YYYY-MM-DD HH:mm');
      this.btn_label ="Time: "+ first_item.format("HH:mm")+ " to "+last_item.format("HH:mm");
      this.$emit("input", this.filter.value);
      this.show_menu = false;
    },
    customRange() {
      this.setFilterDayMonths(true, false);
      if (this.custom_form.from && this.custom_form.to){
        let first_item = new moment(this.custom_form.from).utcOffset('+0300');
        let last_item = new moment(this.custom_form.to).utcOffset('+0300');
        this.$emit("input", {
          from:first_item.format('YYYY-MM-DD HH:mm'),
          to:last_item.format('YYYY-MM-DD HH:mm')
        });
        this.btn_label = "Date: "+  first_item.format("DD-MMMM")+ " to "+last_item.format("DD-MMMM");
        this.show_custom_date = false;
        this.show_menu = false;
      }
    }
  },
  mounted() {
    this.thisWeek();
    //this.today();
  }
}
</script>
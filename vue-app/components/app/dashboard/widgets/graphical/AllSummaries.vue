<template>
  <v-card>
    <v-card-text>
      <highcharts ref="high_chart" :options="chartOptions"></highcharts>
    </v-card-text>
  </v-card>
</template>
<script>
import common_mixin from "@/components/common/mixins/common_mixin";

export default {
  mixins:[common_mixin],
  props: ["inspection_data","date_filter"],
  watch: {
    inspection_data: {
      handler: function (val) {
        this.setChartData();
      },
      deep: true
    }
  },
  data: () => ({
    chartOptions: {
      chart: {
        type: 'column',
        scrollablePlotArea: {
          minWidth: 700,
          scrollPositionX: 1
        }
      },
      plotOptions: {
        column: {
          pointPadding: 0.2,
          borderWidth: 0,
        },
      },
      credits: {
        enabled: false
      },
      exporting: {
        enabled: true
      },
      title: {
        text: 'All summaries'
      },
      subtitle: {
        text: ''
      },
      xAxis: {
        categories: ["Passed",'Failed'],
        crosshair: true,
        scrollbar: {
          enabled: true
        },
        tickLength: 0
      },
      scrollbar: {
        enabled: true
      },
      yAxis: {
        min: 0,
        title: {
          text: 'Totals'
        }
      },
      tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
      },

      series: [
          {
              name: "Passed",
              data: [
                  {
                      name: "Passed",
                      y: 2,
                  },
              ]
          },
          {
              name: "Failed",
             data: [
                  {
                      name: "Failed",
                      y: 0,
                  },
              ]
          },
          {
              name: "Total",
              data: [
                  {
                      name: "Failed",
                      y: 2,
                  },
              ]
          }
      ]
    }
  }),
  methods: {
    setChartData() {
        return;
      this.$refs.high_chart.chart.showLoading("Loading ...");
      this.chartOptions.series = [];
      //this.chartOptions.xAxis.categories = [];

     /* date_ranges.forEach(item=>{
        this.chartOptions.xAxis.categories.push(item.label);
        let format = "MM/DD/YYYY HH:mm:ss";
        let passed_items = this.inspection_data.filter(inspection_item=>{
          let data_date = moment(inspection_item.date, format);
          let start_date = moment(item.start).format(format)
          let end_date = moment(item.end).format(format)
          let history_items = inspection_item.history.map(history=>history.status);
          return history_items.includes(2) && data_date.isBetween(start_date, end_date);
        })

        let failed_items = this.inspection_data.filter(inspection_item=>{
          let data_date = moment(inspection_item.date, format);
          let start_date = moment(item.start).format(format)
          let end_date = moment(item.end).format(format)
          let history_items = inspection_item.history.map(history=>history.status);
          return history_items.includes(3) && data_date.isBetween(start_date, end_date);
        })
        passed.push(passed_items.length);
        failed.push(failed_items.length);
      });*/

      this.chartOptions.series.push(
          {name: 'Passed inspection', data: this.inspection_data.passed},
          {name: 'Failed inspection', data: this.inspection_data.failed},
      )
      this.$refs.high_chart.chart.hideLoading();
    }
  },
  mounted() {
    this.setChartData();
  }

}
</script>


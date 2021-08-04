<template>
    <v-card>
        <v-toolbar dense>
            Dashboard
            <v-spacer></v-spacer>
            <sor-date-range-filter v-model="filter"></sor-date-range-filter>
        </v-toolbar>
        <v-card-text>
            <total-summaries :filter="filter" @input="onSwitch($event)"></total-summaries>
        </v-card-text>
        <v-card-text>
            <v-progress-circular indeterminate v-if="loading"></v-progress-circular>
            <component v-else :date_filter="filter" :inspection_data="summary_inspections" :is="activeCmp"/>
        </v-card-text>
    </v-card>
</template>
<script>
import SorDateRangeFilter from "@/components/app/dashboard/filters/SorDateRangeFilter";
import TotalSummaries from "@/components/app/dashboard/widgets/TotalSummaries";
import AllSummaries from "@/components/app/dashboard/widgets/graphical/AllSummaries";
import FailedInspections from "@/components/app/dashboard/widgets/graphical/FailedInspections";
import WaiveredInspections from "@/components/app/dashboard/widgets/graphical/WaiveredInspections";
import PassedInspections from "@/components/app/dashboard/widgets/graphical/PassedInspections";
export default {
    data:()=>({
        filter:{},
        activeCmp:AllSummaries,
        summary_inspections:[],
        loading:false
    }),
    watch:{
        filter:{
          handler:function (){
              this.getData();
          },
           deep:true
       }
    },
    methods:{
        getData(){
            this.loading = true;
            this.summary_inspections = [];
            this.$axios.post('reports/default/summaries', this.filters).then((res)=>{
                this.loading = false;
                this.summary_inspections = res;
                console.log("deata passed from api is ", res)
            },(err)=>{
                this.loading = false;
            })
        },

        onSwitch(key){
            switch (key){
                case "total":{
                    this.activeCmp = AllSummaries
                    break;
                }

                /*case "passed":{
                  this.activeCmp = PassedInspections
                  break;
                }

                case "waivered":{
                  this.activeCmp = WaiveredInspections
                  break;
                }

                case "failed":{
                  this.activeCmp = FailedInspections
                  break;
                }

                case "rejected":{
                  this.activeCmp = RejectedInspections
                  break;
                }*/
            }

        }
    },
    components:{
        SorDateRangeFilter,TotalSummaries,
        AllSummaries,
        FailedInspections,WaiveredInspections,PassedInspections
    },


}
</script>

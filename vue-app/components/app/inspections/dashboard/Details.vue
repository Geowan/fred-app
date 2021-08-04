<template>
  <v-card>
    <v-toolbar>Details
      <v-spacer></v-spacer>
      <v-btn icon @click="$emit('close')"> <v-icon>mdi-close</v-icon> </v-btn>
    </v-toolbar>
    <v-tabs
        v-model="tab"
        background-color="transparent"
        color="basil"
        grow
    >
      <v-tab>
        Process
      </v-tab>
    </v-tabs>

    <v-tabs-items v-model="tab">
      <v-tab-item>
        <detail-stages :inspection="selected"></detail-stages>
      </v-tab-item>
    </v-tabs-items>

  </v-card>
</template>
<script>
import DetailStages from "@/components/app/inspections/dashboard/tabs/DetailStages";
export default {
  props:{
    selected:{
      type:Object,
      required:true
    }
  },
  components:{
    DetailStages
  },
  data:()=>({
    tab:0
  })

}
</script>
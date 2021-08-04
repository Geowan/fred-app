<template>
  <v-card dark color="primary">
    <v-toolbar color="primary" class="body-1" dense> Confirm inspection details</v-toolbar>
    <v-card-text>
      <v-row>
        <v-col cols="6" md="3"><h2 class="body-1 font-weight-bold">Checklist</h2> <span>{{selectedItem}}</span>
        </v-col>
        <v-col cols="6" md="3"><h2 class="body-1 font-weight-bold">Reg no</h2> <span>{{details.reg_no}}</span>
        </v-col>
      </v-row>
    </v-card-text>
  </v-card>
</template>
<script>
import {mapState} from "vuex";

export default {
  computed: {
    selectedItem(){
      let item = this.checkist_category.find(item=>item.id === this.details.checklist_category);
      return item?item.name:''
    },
    ...mapState({
      details: state => state.inspectionform.details,
        checkist_category:state=>state.app.checkist_category
    })

  }

}
</script>

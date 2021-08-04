<template>
  <v-row align="center" justify="center">
    <v-col md="4" cols="12">
      <v-card>
        <v-card-text>
          <v-toolbar dense>
            <v-toolbar-title class="title">Inspection completed</v-toolbar-title>
          </v-toolbar>
          <v-card-text align="center" v-if="Object.keys(response).length > 0">
            <v-icon color="success" size="100">mdi-check}}</v-icon>
            <v-alert type="success" outlined prominent class="body-2">

              <p>
                Inspection completed. Close to start a new inspection
              </p>

            </v-alert>
          </v-card-text>
          <v-card-text v-else>
            <v-alert type="success" outlined prominent>
              Inspection completed. Close and start a new inspection
            </v-alert>
          </v-card-text>
          <v-card-actions>
            <v-btn block to="/app/inspections/dashboard" outlined color="primary" class="text-none">Close</v-btn>
          </v-card-actions>
        </v-card-text>
      </v-card>
    </v-col>
  </v-row>
</template>
<script>
import {mapState} from "vuex";
export default {
  computed:{
    ...mapState({
      response:state => state.inspectionform.inspection_response
    }),
    passed_inspection(){
      return this.response && this.response.passed_inspection
    }
  }

}
</script>

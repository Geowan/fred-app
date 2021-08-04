<template>
  <v-card flat :loading="loading">
    <v-card>
      <v-card-text v-if="loading" class="flex flex-column" align="center">
        <v-progress-circular indeterminate></v-progress-circular>
      </v-card-text>



      <v-stepper v-else v-model="step">
        <v-stepper-header>
          <v-stepper-step
              :complete="step > 1"
              step="1"
          >
            Details
          </v-stepper-step>

          <v-divider></v-divider>

          <v-stepper-step
              :complete="step > 2"
              step="2"
          >
            Checklists
          </v-stepper-step>
        </v-stepper-header>

        <v-stepper-items>
          <v-stepper-content step="1">
            <v-card
                flat
            >
              <v-card-text>
                <new-inspection-details ref="detail_form"></new-inspection-details>
              </v-card-text>
              <v-divider></v-divider>
              <v-card-actions>
                <v-btn to="/inspection/dashboard" class="text-none" fab small color="primary" dark text>
                  <v-icon>mdi-close</v-icon>
                </v-btn>
                <v-spacer></v-spacer>
                <v-btn
                    outlined
                    class="text-none"
                    color="primary"
                    @click="toChecklists()"
                >
                  Proceed to checklists
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-stepper-content>

          <v-stepper-content step="2">
            <v-card
            >
              <v-card-text>
                <checklists ref="checklist_form"></checklists>
              </v-card-text>
              <v-divider></v-divider>
              <v-card-actions>
                <v-btn text
                       class="text-none"
                       @click="step = 1"
                       v-if="!submitting"
                >
                  Back
                </v-btn>
                <v-spacer></v-spacer>

                <v-btn :loading="submitting" @click="submitDetails()" outlined class="text-none" color="primary">
                  Submit checklist
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-stepper-content>
        </v-stepper-items>
      </v-stepper>
    </v-card>

  </v-card>
</template>
<script>
import NewInspectionDetails from "./forms/NewInspectionDetails";
import Checklists from "./forms/Checklists";
import {mapState} from "vuex";

export default {
  data: () => ({
    step: 1,
    loading: false,
    submitting:false,
    time:'',
    time_processing:false
  }),
  computed: {
    ...mapState({
      details: state => state.inspectionform.details,
      checklist: state => state.inspectionform.checklists,
    })
  },
  components: {
    NewInspectionDetails, Checklists
  },
  methods: {
    toChecklists() {
      this.$refs.detail_form.validateForm().then((res) => {
        this.step = 2;
      })
    },
    getAppData() {
      this.loading = true;
      this.$store.dispatch('app/getAppData')
          .then((res) => {
            this.loading = false;
          }, (err) => {
            this.loading = false;
          })
    },
    submitDetails() {
      this.$refs.checklist_form.validateForm().then((res) => {
        console.log("res is ", res);
        if (res){
          this.$swal.fire({
            title: 'Confirmation',
            text: 'Are you sure the details and checklists are okay?!',
            showCancelButton: true,
            confirmButtonText: `Yes`,
          }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
              this.submitting = true;
              this.$axios.post("api/app/inspection/save", {
                details:this.details,
                checklist:this.checklist.map(item=>{
                  return {
                    checklist_id:item.checklist_id,
                    marked:item.marked,
                    comment:item.comment,
                  }
                }),
                time:this.time
              }).then((res)=>{
                this.submitting = false;
                this.$router.push("/app/inspections/complete")

              },(err)=>{
                this.submitting = false;
              })
            }
          })
        }

      }, (err) => {
        console.log("its not");

      })
    }
  },
  mounted() {
    this.getAppData();
  }
}
</script>

<template>
  <v-card flat>
    <form-details class="ma-1"></form-details>
    <validation-observer ref="checks_form">
      <v-row dense>
        <v-col cols="12" v-for="(item,key) in form" :key="key">
          <v-card :style="{'border':item.error?'2px solid red':''}">
            <v-card-text>
              <h2 class="font-weight-bold subtitle-1"> {{ key += 1 }} {{ item.checklist_name }}</h2>
              <v-radio-group
                  @change="onChecked(item)"
                  v-model="item.marked"
                  row
              >
                <v-radio
                    label="Yes"
                    value="yes"
                ></v-radio>
                <v-radio
                    label="No"
                    value="no"
                ></v-radio>
              </v-radio-group>
              <v-text-field-validated @input="onValueInput(item)" label="Enter comment" rules="required" v-model="item.comment"
                                      v-if="item.marked==='no'"/>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </validation-observer>
    <form-details class="ma-1"></form-details>
  </v-card>
</template>
<script>
import {mapState} from "vuex";
import FormDetails from "./FormDetails";

export default {
  data: () => ({
    form: []
  }),
  computed: {
    ...mapState({
      details: state => state.inspectionform.details,
      checklists: state => state.app.checklists,
      checklist_assignment: state => state.app.checklist_assignment,
    })
  },
  watch: {
    details: {
      handler: function () {
        this.setChecklistData();
      },
      deep: true
    }
  },
  mounted() {
    this.setChecklistData();
  },
  components:{
    FormDetails
  },
  methods: {
    onValueInput(val){
      let selected =  this.form.find(item=>item.checklist_id === val.checklist_id)
      if (selected){
       selected.error = !selected.comment;
      }
    },
    setChecklistData() {
      this.form = [];
      this.checklists.filter(item => item.category_id === this.details.checklist_category)
          .forEach(checklist_item => {
            this.form.push({
              error:false,
              marked: '',
              comment: '',
              checklist_id: checklist_item.id,
              checklist_name: checklist_item.name
            });
          })
    },
    onChecked(val){
     let selected =  this.form.find(item=>item.checklist_id === val.checklist_id)
      if (selected){
        selected.comment = "";
        selected.error =(val.marked === "no" && !val.comment);
      }
    },
    validateForm(){
      return new Promise(async(resolve, reject)=>{
        let passed = true;
        this.form.forEach(item=>{
          item.error =!item.marked || (item.marked === "no" && !item.comment);
          if (item.error){
            passed = false;
          }
        })
        if (await this.$refs.checks_form.validate()) {
          this.$store.commit("inspectionform/setChecklists", this.form);
          if (!passed){
            this.$swal.fire({  icon: 'error', title: 'Oops...',text: 'Review checklist items marked in red!'})
          }
          return passed?resolve(true):reject(false);
        }else {
          reject(false);
          this.$swal.fire({  icon: 'error', title: 'Oops...',text: 'Review checklist items marked in red!'})
          return  false;
        }
      })
    }
  }
}
</script>

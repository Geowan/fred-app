<template>
  <validation-observer ref="form">
    <v-row>
      <v-col md="6" cols="12">
        <v-select-validated v-model="form.checklist_category" rules="required"
                            chips deletable-chips small-chips :items="checkist_category"
                            label="Checklist category" item-text="name" item-value="id"/>

      </v-col>
      <v-col md="6" cols="12">
          <v-select-validated v-model="form.reg_no" rules="required"
                              chips deletable-chips small-chips :items="vehicles"
                              label="Reg no" item-text="reg_no" item-value="reg_no"/>
      </v-col>
    </v-row>
  </validation-observer>

</template>
<script>
import {mapState} from "vuex";
export default {
  data:()=>({
    form:{
      checklist_category:'',
      reg_no:''
    }
  }),
  computed:{
    ...mapState({
        checkist_category:state=>state.app.checkist_category,
        vehicles:state=>state.app.vehicles,
    })
  },
  methods:{
     validateForm(){
      return new Promise(async(resolve, reject)=>{
        if (await this.$refs.form.validate()) {
          this.$store.commit("inspectionform/setDetails", this.form);
        return resolve(true);
        }else {
          this.$swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'All fields are required!',
          })
         return reject(false)
        }
      })
    }
  }

}
</script>

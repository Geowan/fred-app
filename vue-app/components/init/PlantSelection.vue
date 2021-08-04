<template>
  <v-row style="background-image: url('https://colorlib.com/etc/lf/Login_v4/images/bg-01.jpg');background-size: cover" class="fill-height mt-lg-n12"  justify="center" align="center">
    <v-col xs="12" sm="12" md="6" lg="3"  class="ma-3" >
      <v-card flat>
        <v-toolbar dark color="primary" height="40">
          <v-toolbar-title>Select your access plant</v-toolbar-title>
        </v-toolbar>
        <v-card-text>

          <v-row row wrap class="mt-2">
            <v-col v-for="(plant,key) in plants" :key="key" md12 cols="12">
              <v-card dark @click="setPlant(plant.plant_id)"
                      color="primary"
                     class="text-center"
                      style="cursor: pointer">

                <v-card-title primary-title color="accent" class="text-center">
                  <div  style="width: 100%">
                    <div class="subheading font-weight-bold"> {{key + 1}} {{plant.plant_name}}</div>
                    <span  class="text-center body-1" style="font-size: 12px!important;">
                                           Click to access {{plant.plant_name}}
                                        </span>
                  </div>
                </v-card-title>
              </v-card>
            </v-col>
          </v-row>
        </v-card-text>
      </v-card>

    </v-col>

  </v-row>



</template>
<script>
import {mapState} from "vuex";
import tokenservice from "@/helpers/tokenservice";

export default {
  computed:{
    ...mapState({
      plants:state => state.user.plants
    })
  },
  methods:{
    setPlant(id){
      tokenservice.settoken(tokenservice.access_plant, id);
      let redirrect = tokenservice.gettoken(tokenservice.redirrect_url);
      this.$router.push(redirrect?redirrect:'/app');
    }
  },
  mounted() {
    this.$store.dispatch("user/getActiveUser");
  }
}
</script>

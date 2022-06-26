<template>

  <v-container class="bg">
      
       <v-row>
      <v-col cols="12" sm="12">
    <div class="d-flex justify-center mt-5">
      <span class="headline ">Ticket Statistics</span>
    </div>
    <clients-dashboard />
    </v-col>
    <v-col cols="12" sm="12">
    <div class="d-flex justify-center">
      <span class="headline"> Marketing</span>
    </div>
    <marketing-dashboard />
    </v-col>
    </v-row>
   
  </v-container>

</template>

<script>
import clientsDashboard from "./clientsDashboard.vue";
import MarketingDashboard from "./marketingDashboard.vue";

export default {
  components: {
    clientsDashboard,
    MarketingDashboard,
  },
};
</script>

<style scoped>
.bg{
    background:  url('https://computerclinicmw.com/wp-content/uploads/2022/06/login.jpg') no-repeat center center fixed !important;
  background-size: cover;
}
</style>
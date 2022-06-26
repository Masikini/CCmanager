<template>
  <v-app>
    <!--  -->

    <span class="headline my-5">Campaign Form</span>

    <v-divider></v-divider>

    <v-form ref="form" @submit.prevent="submit">
      <v-container class="py-15 px-2">
        <span class="headline">New Campaign</span>
        <v-row>
          <v-col cols="12" sm="12">
            <v-text-field label="Title" hint="Verifiable by ID" persistent-hint required v-model="campaign.title"
              :rules="titleRules" counter="20"></v-text-field>
          </v-col>
          <v-col cols="12" sm="12">
            <v-textarea filled auto-grow label="Description" rows="2" row-height="20" v-model="campaign.description">
            </v-textarea>
          </v-col>
          <v-col cols="12" sm="4">
            <v-text-field label="Facilitator" v-model="campaign.facilitator">
            </v-text-field>
          </v-col>
          <v-col cols="12" sm="4">
            <v-text-field label="Target*" type="number" v-model="campaign.target" counter="12" required
              :rules="targetRules"></v-text-field>
          </v-col>
          <v-col cols="12" sm="4">
            <v-text-field label="End" type="date" v-model="campaign.end" required :rules="targetRules"></v-text-field>
          </v-col>
          <v-col cols="12" sm="4">
            <v-select :items="['Training', 'ComputerCare', 'ManagedIT']" label="Category" v-model="campaign.category">
            </v-select>
          </v-col>
        </v-row>
      </v-container>

      <v-container class="px-5">
        <v-btn color="primary" @click="register" :loading="addCampaignLoading"> Add Campaign </v-btn>

        <v-btn text @click="cancelForm"> Cancel </v-btn>
      </v-container>
    </v-form>

    <!--  -->
  </v-app>
</template>

<script>
export default {
  data() {
    return {
      //   menu1: false,
      // date: new Date(Date.now() - new Date().getTimezoneOffset() * 60000)
      //   .toISOString()
      //   .substr(0, 10),
      // dateFormatted: formatDate(
      //   new Date(Date.now() - new Date().getTimezoneOffset() * 60000)
      //     .toISOString()
      //     .substr(0, 10)
      // ),
      addCampaignLoading: false,
      campaign: {
        title: "",
        facilitator: "",
        description: "",
        target: "",
        category:"",
        end: null,
      },

      titleRules: [(v) => !!v || "Title is required"],

      descriptionRules: [(v) => !!v || "A Description is required"],
      // emailRules: [(v) => /.+@.+/.test(v) || "E-mail must be valid"],
      targetRules: [(v) => !!v || "Target number is required"],
    };
  },
  methods: {
    // formatDate(date) {
    //   if (!date) return null;

    //   const [year, month, day] = date.split("-");
    //   return `${month}/${day}/${year}`;
    // },
    // parseDate(date) {
    //   if (!date) return null;

    //   const [month, day, year] = date.split("/");
    //   return `${year}-${month.padStart(2, "0")}-${day.padStart(2, "0")}`;
    // },

    cancelForm() {
      this.campaign.title = "";
      this.campaign.facilitator = "";
      this.campaign.description = "";
      this.campaign.target = "";
      this.campaign.end = null;
      this.$refs.form.resetValidation();

      this.$emit("cancelFormCampaign");
    },
    register() {
      if (this.$refs.form.validate()) {
        this.addCampaignLoading = true;
        axios
          .post("api/campaigns/store", { campaign: this.campaign })

          .then((response) => {
            if (response.status == 201) {
              console.log("campaign added!");
              this.addCampaignLoading = false;
              this.cancelForm();
            }
          })
          .catch((error) => {
            console.log(error.response.data);
            this.addCampaignLoading = false;
          });
      }
    },
  },
  computed: {
    // computedDateFormatted() {
    //   return this.formatDate(this.date);
    // },
  },
};
</script>

<style>
</style>
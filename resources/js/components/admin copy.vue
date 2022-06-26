<template>
  <div class="text-center mt-10">
    <v-row justify="center">
      <v-col sm="12">
        <v-btn class="ma-2" outlined color="primary" @click="notices">
          Notices</v-btn
        >
        <v-btn class="ma-2" outlined color="primary" @click="campaigns">
          Campaigns</v-btn
        >
        <v-btn class="ma-2" outlined color="primary" @click="users">
          Users</v-btn
        >
        <v-btn class="ma-2" outlined color="primary" @click="services">
          Services</v-btn
        >
        <v-btn class="ma-2" outlined color="primary" @click="planner">
          Planner</v-btn
        >
      </v-col>
      <v-col sm="12">
        <v-card class="mx-auto" elevation="1" max-width="850">
          <v-card-title class="justify-center">
            <span>{{ selectedPanel }}</span>
          </v-card-title>
          <v-card-text>
            <v-sheet>
              <v-slide-group
                class="pa-4"
                show-arrows
                v-if="selectedPanel == 'Campaigns'"
              >
                <v-slide-item
                  v-for="(item, index) in $store.state.adminPanel.Campaigns"
                  :key="item.id"
                >
                  <v-card
                    :color="active ? 'primary' : 'grey lighten-1'"
                    class="ma-4"
                    height="180"
                    width="180"
                    v-if="duration(item.end) < 0"
                  >
                    <v-card-title>
                      <span>{{ item.title }}</span>
                    </v-card-title>
                    <v-card-text>
                      <span>{{ descTrim(item.description) }}</span>
                      <br />
                      <v-row class="mt-3">
                        <v-col sm="12">
                          <v-layout row justify-space-around>
                            <v-chip
                              class="mt-2"
                              color="teal"
                              text-color="white"
                            >
                              <v-avatar left>
                                <v-icon>mdi-timer-sand</v-icon>
                              </v-avatar>
                              {{ duration(item.end) * -1 }} Days
                            </v-chip>
                            <v-btn
                              icon
                              color="pink"
                              @click="checkCamp(item.id)"
                              class="mt-1"
                            >
                              <v-icon>mdi-check-bold</v-icon>
                            </v-btn>
                          </v-layout>
                        </v-col>
                      </v-row>

                      <!-- <span class="mt-2"
                        >{{ duration(item.end) * -1 }} Days togo!</span
                      > -->
                    </v-card-text>
                  </v-card>
                </v-slide-item>
              </v-slide-group>

              <v-slide-group
                class="pa-4"
                show-arrows
                v-if="selectedPanel == 'Notices'"
              >
                <v-slide-item
                  v-for="(item, index) in $store.state.adminPanel.Notices"
                  :key="item.id"
                >
                  <v-card
                    :color="active ? 'primary' : 'grey lighten-1'"
                    class="ma-4"
                    height="180"
                    width="180"
                    v-if="duration(item.end) < 0"
                  >
                    <v-card-title>
                      <span>{{ noticeDuration(item.created_at) }}</span>
                    </v-card-title>
                    <v-card-text>
                      <span>{{ descTrim(item.description) }}</span>
                      <br />
                      <v-row class="mt-3">
                        <v-col sm="12">
                          <v-layout row justify-space-around>
                            <v-chip
                              class="mt-2"
                              color="teal"
                              text-color="white"
                            >
                              <v-avatar left>
                                <v-icon>mdi-timer-sand</v-icon>
                              </v-avatar>
                              {{ duration(item.end) * -1 }} Days
                            </v-chip>
                            <v-btn
                              icon
                              color="pink"
                              @click="checkCamp(item.id)"
                              class="mt-1"
                            >
                              <v-icon>mdi-check-bold</v-icon>
                            </v-btn>
                          </v-layout>
                        </v-col>
                      </v-row>

                      <!-- <span class="mt-2"
                        >{{ duration(item.end) * -1 }} Days togo!</span
                      > -->
                    </v-card-text>
                  </v-card>
                </v-slide-item>
              </v-slide-group>

              <!-- <v-expand-transition>
                <v-sheet v-if="toggle == active" height="200" tile>
                  <v-row class="fill-height" align="center" justify="center">
                    <h3 class="text-h6">Selected {{ selectedPanel }}</h3>
                  </v-row>
                </v-sheet>
              </v-expand-transition> -->
            </v-sheet>
          </v-card-text>
          <v-card-actions class="justify-end">
            <v-btn color="primary" @click="opendialog"> Add </v-btn>
          </v-card-actions>
        </v-card>
        <v-dialog
          v-model="dialogNotices"
          max-width="600px"
          persistent
          transition="dialog-bottom-transition"
        >
          <v-card tile>
            <v-card-text>
              <AdminNotice @cancelFormNotice="dialogNotices = !dialogNotices" />
            </v-card-text>
          </v-card>
        </v-dialog>

        <v-dialog
          v-model="dialogCampaigns"
          max-width="600px"
          max-height="500px"
          persistent
          transition="dialog-bottom-transition"
        >
          <v-card tile>
            <v-card-text>
              <!-- <managed-it @cancelFormCampaign="dialogCampaigns = !dialogCampaigns" /> -->

              <AdminCampaign
                @cancelFormCampaign="dialogCampaigns = !dialogCampaigns"
              />
            </v-card-text>
          </v-card>
        </v-dialog>
          <v-dialog
          v-model="dialogRegisterUser"
          max-width="600px"
          max-height="500px"
          persistent
          transition="dialog-bottom-transition"
        >
          <v-card tile>
            <v-card-text>
              <!-- <managed-it @cancelFormCampaign="dialogCampaigns = !dialogCampaigns" /> -->

              <RegisterUser
                @cancelFormRegisterUser="dialogRegisterUser = !dialogRegisterUser"
              />

            </v-card-text>
          </v-card>
        </v-dialog>
      </v-col>
    </v-row>
  </div>
</template>

<script>
import AdminCampaign from "./forms/adminCampaign.vue";
import AdminNotice from "./forms/adminNotice.vue";
import RegisterUser from "./Register.vue";
import moment from "moment";
export default {
  components: { AdminCampaign, AdminNotice, RegisterUser, },
  data: () => ({
    availableCampaigns: null,
    selectedPanel: "",
    dialogRegisterUser: false,
    dialogServices: false,
    dialogNotices: false,
    dialogCampaigns: false,
    dialogPlanner: false,
  }),

  methods: {
    descTrim(desc) {
      var newdesc = "";

      if (desc.length > 12) {
        return desc.split("").slice(0, 70).join("") + "...";
      } else {
        for (let i = desc.length; i < 29; i++) {
          newdesc += " ";
        }

        // desc = desc + newdesc;
        // desc = desc.replace("xx", " ");
        return desc + newdesc;
      }
    },

    checkCamp(id) {
      axios
        .put("api/campaign/" + id)
        .then((response) => {
          if (response.status == 200) {
            console.log("camp closed!");
          } else {
            console.log("unable to close camp!");
          }
        })
        .catch((error) => {
          console.log(error.response.data);
        });
    },
    users() {
      this.selectedPanel = "Users";

    },

    notices() {
      this.selectedPanel = "Notices";
    },

    campaigns() {
      this.selectedPanel = "Campaigns";
      console.log(moment().format("MMMM Do YYYY, h:mm:ss a"));
    },
    services() {
      this.selectedPanel = "Services";
    },
    planner() {
      this.selectedPanel = "Planner";
    },
    opendialog() {
      if (this.selectedPanel == "Campaigns") {
        this.dialogCampaigns = true;
      } else if (this.selectedPanel == "Notices") {
        this.dialogNotices = true;
      }else if (this.selectedPanel == "Users"){
        this.dialogRegisterUser = true;
      }
    },
    duration(end) {
      console.log(end);
      var enddate = moment(end, "YYYY-MM-DD");

      var today = moment();
      return today.diff(enddate, "days");
      // var enddate= moment(end);
      // return moment.duration(today.diff(end)).asDays();

      // return moment().endOf('day').fromNow(dateoftoday);
    },

    noticeDuration(end) {
      console.log(end);
      var enddate = moment(end, "YYYY-MM-DD");

      var today = moment();
      var date_to_display = enddate.diff(today, "days");
      if (date_to_display < 0) {
        date_to_display = date_to_display * -1 + " Days ago";
        return date_to_display;
      } else if (date_to_display == 0) {
        return "Today";
      }else{
        return "Expired!"
      }

      // var enddate= moment(end);
      // return moment.duration(today.diff(end)).asDays();

      // return moment().endOf('day').fromNow(dateoftoday);
    },
  },

  computed: {
    // duration(end) {
    //   var today= moment();
    //   var enddate= moment(end);
    //   return moment.duration(today.diff(enddate)).asDays();
    // },
  },
  mounted() {
    this.selectedPanel = "Notices";

    axios.get("api/campaign/").then((res) => {
      if (res.status == 200) {
        this.availableCampaigns = res.data;
        this.$store.commit("AddCampaigns", this.availableCampaigns);
      }
    });

    axios.get("api/notices/").then((res) => {
      if (res.status == 200) {
        this.$store.commit("AddNotices", res.data);
      }
    });
  },
};
</script>

<style>
</style>
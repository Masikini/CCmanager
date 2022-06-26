<template>
  <v-app>
    <!--  -->

    <span class="headline my-5">IT Training Form</span>

    <v-stepper v-model="e1" class="elevation-0">
      <v-stepper-header>
        <v-stepper-step :complete="e1 > 1" step="1"> Client </v-stepper-step>

        <v-divider></v-divider>

        <v-stepper-step :complete="e1 > 2" step="2"> Course </v-stepper-step>

        <v-divider></v-divider>

        <v-stepper-step step="3"> Open Ticket </v-stepper-step>
      </v-stepper-header>

      <v-stepper-items>
        <v-stepper-content step="1">
          <RegisterClient @registered="goStep2" />
        </v-stepper-content>


        <v-stepper-content step="2">
          <v-form v-model="valid2" ref="form2" @submit.prevent="submit">
            <v-layout row justify-center align-content-center align-center class="ma-10">
              <p class="font-weight-bold">Total:</p>
              <v-chip label class="mb-5"> MWK{{ ticket.totalCost }} </v-chip>
            </v-layout>
            <v-container class="py-15 px-2">
              <span class="headline mb-15">Client</span>
              <v-row>
                <v-col cols="12" sm="12">
                  <v-autocomplete v-model="select" :loading="loading" :items="items" :search-input.sync="search"
                    :rules="nameRules" clearable flat hide-no-data hide-details placeholder="Type name or phone number"
                    rounded filled></v-autocomplete>

                  <v-divider></v-divider>
                </v-col>
                <v-col sm="12" cols="12">
                  <v-autocomplete :items="courses" label="Course" :rules="courseRules"
                    @change="(event) => updateTotal(event)" multiple v-model="ticket.list"></v-autocomplete>
                </v-col>

                <v-col sm="12" cols="12">
                  <v-autocomplete :items="costs" label="Associated Costs" :rules="courseRules" multiple
                    v-model="ticket.associatedCosts" @change="(event) => updateAssociatedCosts(event)"></v-autocomplete>
                </v-col>
                <v-col sm="12" cols="12">
                  <v-layout row align-content-space-between>
                    <v-checkbox v-model="ticket.schedule" label="Weekdays" value="Weekdays"></v-checkbox>
                    <v-checkbox v-model="ticket.schedule" label="Weekends" value="Weekends"></v-checkbox>
                    <v-checkbox v-model="ticket.schedule" label="Evenings" value="Evenings"></v-checkbox>
                  </v-layout>
                </v-col>
                <v-col cols="12" sm="12">
                  <v-textarea filled auto-grow label="Extra Info" v-model="ticket.description" rows="2" row-height="30"
                    shaped></v-textarea>
                </v-col>
                <v-col cols="12" sm="12">
                  <v-autocomplete :items="campaigns" label="Campaigns" v-model="ticket.campaign_title"></v-autocomplete>

                </v-col>

              </v-row>
            </v-container>
            <v-container class="px-5">
              <v-btn color="primary" @click="goStep3"> Continue</v-btn>

              <v-btn text @click="cancelForm()"> Cancel </v-btn>
            </v-container>
          </v-form>
        </v-stepper-content>

        <v-stepper-content step="3">
          <v-card class="mx-auto" max-width="450" flat>
            <v-card-title>
              <span class="headline">Ticket Summary</span>
            </v-card-title>
            <!-- <v-card-subtitle>
              <v-layout row>
                <span> Opening a ticket attracts a fee of </span>
                <span class="font-weight-bold ml-2">{{ 2500 }}</span>
              </v-layout>
            </v-card-subtitle> -->
            <v-card :loading="loadingConfirm" class="mx-auto mt-12" max-width="374">
              <template slot="progress">
                <v-progress-linear color="primary" height="5" indeterminate></v-progress-linear>
              </template>

              <v-card-text class="pb-10">
                <v-layout column>
                  <v-layout row class="mx-10 mt-10">
                    <span class="font-weight-bold mr-3"> Total Cost</span>
                    <span class="font-weight-bold ml-2">{{
                        ticket.totalCost
                    }}</span>
                  </v-layout>

                  <v-layout row class="mx-10 mt-10">
                    <span class="font-weight-bold mr-3"> Client</span>
                    <span>{{ select }}</span>
                  </v-layout>

                  <v-layout row class="mx-10 mt-5">
                    <span class="font-weight-bold mr-3"> Course(s)</span>
                    <span>{{ ticket.list }}</span>
                  </v-layout>

                  <v-layout row class="mx-10 mt-5">
                    <span class="font-weight-bold mr-3">Extra Info</span>
                    <span>{{ ticket.description }}</span>
                  </v-layout>
                </v-layout>
              </v-card-text>
            </v-card>
            <v-card-text class="mt-2 text-center">
              <v-chip v-if="confirmDone" close-icon="mdi-close-outline" :color="ticketStatus ? 'green' : 'red'">{{
                  displayText
              }}</v-chip>
            </v-card-text>
            <v-card-actions class="mt-10">
              <v-btn color="primary" @click="confirm" v-if="ticketStatusButton" :disabled="loadingConfirm">
                <span v-if="!ticketOpened"> Confirm </span>

                <!-- <v-scroll-x-transition>
                  <v-row v-if="ticketOpened">
                    <v-icon color="success"> mdi-check </v-icon>
                    <span class="ma-1">Opened!</span>
                  </v-row>

                  <v-row v-if="!ticketOpened && confirmDone">
                    <v-icon color="success"> mdi-check </v-icon>
                    <span class="ma-1">Error!</span>
                  </v-row>
                </v-scroll-x-transition> -->
              </v-btn>
              <v-btn text v-if="ticketOpened" @click="downloadOffer">
                <span color="success"> Download Offer </span>
              </v-btn>

              <v-btn text @click="backStep2">
                <span v-if="!ticketOpened"> Back</span>
                <span v-if="ticketOpened" style="color: red"> Close</span>
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-stepper-content>
      </v-stepper-items>
    </v-stepper>
    <!--  -->
  </v-app>
</template>

<script>
import RegisterClient from './registerClient.vue';

export default {
  components: {

    RegisterClient
  },
  data() {
    return {
      loading: false,
      entries: [],
      items: [],
      search: null,
      select: null,
      loadingConfirm: false,
      confirmDone: false,
      displayText: "",
      ticketStatus: false,
      ticketStatusButton: true,
      coursesData: [], // all courses data from DB, for calculating total cost etc.
      courses: [], //keeping the course code and name to display on the selection
      costsData: [], //all costs data
      costs: [], //the selected associated costs
      selectedCourses: [], //variable for the selcted courses to be sent to the invoice
      selectedAssociatedCosts: [], //variable for keeping selected associated costs to be sent to the Invoice Generator
      //sample data for the prices of courses and associated costs

      e1: 1,
      valid: false,
      valid2: false,
      ticketOpened: false,


      ticket: {
        client_name: "",
        issuer: "",
        service: "IT Training",
        main_service: "IT Training",
        list: null,
        description: null,
        associatedCosts: null,
        totalCost: 0,
        discounts: 0,
        schedule: [],
        costs_metadata: [],
        SN: null,
        campaign_title: "",
      },

      campaigns: [],

      nameRules: [(v) => !!v || "Name is required"],

      courseRules: [(v) => !!v || "A course is required"],
      // emailRules: [(v) => /.+@.+/.test(v) || "E-mail must be valid"],
      phoneRules: [(v) => !!v || "Phone number is required"],
    };
  },
  methods: {
    cancelForm() {
      this.entries = [];
      this.items = [];
      this.ticket.list = "";

      this.ticket.description = "";
      this.ticket.associatedCosts = "";
      this.ticket.client_name = "";
      this.select = "";
      this.ticketOpened = false;
      this.loadingConfirm = false;
      this.confirmDone = false;
      this.displayText = "";
      this.ticketStatus = false;
      this.ticketStatusButton = true;
          this.ticket.totalCost = 0;
      this.campaign_title = "";

      this.e1 = 1;
      this.$refs.form2.resetValidation();




      this.$emit("cancelFormTraining");
    },

    goStep3() {
      if (this.$refs.form2.validate()) {
        this.ticket.client_name = this.select;
        this.ticket.list = this.ticket.list.toString().replace(/"|]/, "");
        this.ticket.issuer = this.$store.state.user.name;

        this.confirmDone = false;
        this.displayText = "";
        this.ticketStatus = false;
        this.loadingConfirm = false;
        this.ticketOpened = false;
        

        this.e1 = 3;
      }
    },
    backStep2() {
      if (this.ticketOpened) {
        this.cancelForm();
      } else {
        this.e1 = this.e1 - 1;
      }
    },
    goStep2() {
      this.reloadCosts();
      this.reloadCoursesCosts();
      this.loadCampaigns();
      this.e1 = 2;
    },
    confirm() {
      this.loadingConfirm = true;

      axios
        .post("api/ticket/store", { ticket: this.ticket })

        .then((response) => {
          console.log("main ticket opened!");
          this.ticket.SN = response.data;

          axios
            .post("api/ticket/it_train/store", { ticket: this.ticket })

            .then((response) => {

              this.loadingConfirm = false;
              this.confirmDone = true;
              this.displayText = "Ticket opened!";
              this.ticketStatus = true;
              this.ticketOpened = true;
              this.ticketStatusButton = false;

            })
            .catch((error) => {
              this.confirmDone = true;
              this.displayText = "Unable to open Ticket";
              this.ticketStatus = false;
              this.loadingConfirm = true;
              this.ticketOpened = false;
              console.log(error.response.data);
            });
        })
        .catch((error) => {
          console.log("Unable to open  main ticket", error.response.data);
        });

      // setTimeout(
      //   () => ((this.loadingConfirm = false), (this.ticketOpened = true)),
      //   2000
      // );
    },

    updateAssociatedCosts(value) {
      this.ticket.totalCost = 0; //reset the total costs
      this.selectedCourses = [];
      this.selectedAssociatedCosts = [];
      this.ticket.costs_metadata = [];
      //add up the assocated costs
      value.forEach((element, index) => {
        // this.ticket.totalCost =
        //   this.ticket.totalCost + this.costsData[index].fee; //add the assocuated ticket cost
        // this.selectedAssociatedCosts.push(this.costsData[index]);

        for (let i = 0; i < this.costsData.length; i++) {
          if (this.costsData[i].name == element) {
            this.ticket.totalCost =
              this.ticket.totalCost + this.costsData[i].fee;
            this.selectedAssociatedCosts.push(this.costsData[i]);
          }
        }

      });

      //update the costs metadata
      this.ticket.costs_metadata = this.selectedAssociatedCosts;

      //add on the courses costs
      this.ticket.list.forEach((element, index) => {
        // this.ticket.totalCost =
        //   this.ticket.totalCost + this.coursesData[index].fee; //add the assocuated ticket cost

        for (let i = 0; i < this.coursesData.length; i++) {
          if (this.coursesData[i].name == element) {
            this.ticket.totalCost =
              this.ticket.totalCost + this.coursesData[i].fee;
            this.selectedCourses.push(this.coursesData[i]);
            this.ticket.costs_metadata.push(this.coursesData[i]);
          }
        }

        // this.selectedCourses.push(this.coursesData[index]);
        // this.ticket.costs_metadata.push(this.coursesData[index]);
      });
      console.log("Metadata as follows");
      console.log(this.ticket.costs_metadata);
    },

    updateTotal(value) {
      //print the prices of the selectedd courses
      this.ticket.totalCost = 0;
      this.selectedCourses = [];
      this.ticket.costs_metadata = [];
      // this.selectedAssociatedCosts = [];

      value.forEach((element, index) => {
        // this.ticket.totalCost =
        //   this.ticket.totalCost + this.coursesData[index].fee;

        //add to array that will be sent to the Invoice controller
        this.selectedCourses.push(this.coursesData[index]);

        for (let i = 0; i < this.coursesData.length; i++) {
          if (this.coursesData[i].name == element) {
            this.ticket.totalCost =
              this.ticket.totalCost + this.coursesData[i].fee;
            this.selectedCourses.push(this.coursesData[i]);
          }
        }
      });

      //document costs_metadata
      this.ticket.costs_metadata = this.selectedCourses;

      //add the associated costs to the totalcosts
      this.ticket.associatedCosts.forEach((element, index) => {
        // this.ticket.totalCost = this.ticket.totalCost + this.costsData[index].fee; //add the assocuated ticket cost


        // this.selectedAssociatedCosts.push(this.costsData[index]);
        // this.ticket.costs_metadata.push(this.costsData[index]); //document the costs metadata

        for (let i = 0; i < this.ticket.associatedCosts.length; i++) {
          if (this.costsData[i].name == element) {
            this.ticket.totalCost = this.ticket.totalCost + this.costsData[i].fee;
            this.selectedAssociatedCosts.push(this.costsData[i]);
            this.ticket.costs_metadata.push(this.costsData[i]);
          }
        }

      });
      console.log("Metadata as follows");
      console.log(this.ticket.costs_metadata);
    },

    downloadOffer() {
      // axios .get("api/invoices/offer").then((response) => {
      //     // this.entries = response.data
      //     console.log("done downloading");

      //    console.log(response.data);
      //   })
      //   .catch((error) => {
      //     console.log(error);
      //   });
      const offername = this.select.split(",")[0] + "Offer.pdf";

      let arrOfObj = {
        ticket: this.ticket,
        serialNumber: this.ticket.SN,
        courses: this.selectedCourses,
        // costs: this.associatedCosts,
        costs: this.ticket.costs_metadata,
      };

      // console.log("For Inspection::");
      // console.log(arrOfObj);
      axios
        .post(
          "api/invoices/offer",
          { invoiceData: JSON.stringify(arrOfObj) },
          { responseType: "arraybuffer" }
        )
        .then(function (response) {
          let blob = new Blob([response.data], { type: "application/pdf" });
          let link = document.createElement("a");
          link.href = window.URL.createObjectURL(blob);
          // link.download = "Report.pdf";

          link.download = offername;
          link.click();
        });
    },
    loadData() {
      axios
        .get("api/clients")
        .then((response) => {
          // this.entries = response.data

          this.entries = response.data.map((res) => {
            const clientList = res.name + " , " + res.phone;
            return res.name + " , " + res.phone;
            // this.entries = Object.assign(clientList);
          });

          //
        })
        .catch((error) => {
          console.log(error);
        });
    },

    querySelections(v) {
      this.loading = true;
      this.loadData();
      // Simulated ajax query
      setTimeout(() => {
        this.items = this.entries.filter(
          (e) =>
            (e || "")
              .toString()
              .toLowerCase()
              .indexOf((v || "").toString().toLowerCase()) > -1
        );

        this.loading = false;
      }, 500);
    },

    reloadCosts() {
      axios
        .get("api/costs/" + "Training")
        .then((response) => {
          // this.entries = response.data
          this.costsData = response.data;
          this.costs = response.data.map((res) => {
            // const clientList = res.name + " , " + res.phone;
            return res.name;
            // this.entries = Object.assign(clientList);
          });

          console.log(this.costsData);

          //load the courses and associated costs with IT Training.
        })
        .catch((error) => {
          console.log(error);
        });
    },
    loadCampaigns() {
      axios
        .get("api/campaigns/" + "Training")
        .then((response) => {

          this.campaigns = response.data.map((res) => {
            // const clientList = res.name + " , " + res.phone;
            return res.title;
            // this.entries = Object.assign(clientList);
          });


          //load the courses and associated costs with IT Training.
        })
        .catch((error) => {
          console.log(error);
        });
    },
    reloadCoursesCosts() {
      axios
        .get("api/courses")
        .then((response) => {
          // this.entries = response.data
          this.coursesData = response.data;
          this.courses = response.data.map((res) => {
            // const clientList = res.name + " , " + res.phone;
            return res.name;
            // this.entries = Object.assign(clientList);
          });

          console.log(this.coursesData);

          //load the associated costs

          //load the courses and associated costs with IT Training.
        })
        .catch((error) => {
          console.log(error);
        });
    }
  },

  created() {
    //load the courses and associated costs with IT Training.
    // this.reloadCosts();
    // this.reloadCoursesCosts();
    //completed oading courses
  },
  computed: {
    // items() {
    //   this.loadData;
    //   return this.entries.map((entry) => {
    //     const clientList = entry.name + " , " + entry.phone;
    //     return Object.assign(clientList.toString());
    //   });
    // },
  },
  watch: {
    search(val) {
      val && val !== this.select && this.querySelections(val);
    },

    // search(val) {
    //   // Items have already been loaded
    //   if (this.items.length > 0) return;
    //   // Items have already been requested
    //   if (this.isLoading) return;
    //   this.isLoading = true;
    //   // Lazily load input items
    //   fetch("api/clients")
    //     .then((res) => res.json())
    //     .then((res) => {
    //       // const { count, entries } = res;
    //       // this.count = count;
    //       this.entries = res;
    //     })
    //     .catch((err) => {
    //       console.log(err);
    //     })
    //     .finally(() => (this.isLoading = false));
    // },
  },
};
</script>

<style>
</style>
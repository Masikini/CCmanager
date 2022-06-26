<template>
  <v-app>
    <!--  -->

    <span class="headline my-5">Computer Care Form</span>

    <v-stepper v-model="e1" class="elevation-0">
      <v-stepper-header>
        <v-stepper-step :complete="e1 > 1" step="1"> Client </v-stepper-step>

        <v-divider></v-divider>

        <v-stepper-step :complete="e1 > 2" step="2"> Service </v-stepper-step>

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

            <v-container class="px-2 py-15">
              <span class="headline mb-15">Client</span>
              <v-row>
                <v-col cols="12" sm="12">
                  <v-autocomplete v-model="select" :loading="loading" :items="items" :search-input.sync="search"
                    :rules="nameRules" clearable class="mx-4" flat hide-no-data hide-details
                    placeholder="Type name or phone number" rounded filled></v-autocomplete>

                  <v-divider></v-divider>
                </v-col>
                <v-col cols="12" sm="4">
                  <v-autocomplete :items="[
                    'Dell',
                    'HP',
                    'ASUS',
                    'Samsung',
                    'Lenovo',
                    'Mac',
                    'Acer',
                    'Other',
                  ]" label="Brand" v-model="ticket.item_brand"></v-autocomplete>
                </v-col>
                <v-col cols="12" sm="4">
                  <v-text-field label="Model*" v-model="ticket.item_model" required></v-text-field>
                </v-col>
                <v-col cols="12" sm="4">
                  <v-text-field label="SN No*" v-model="ticket.item_sn" :rules="SNRules" required></v-text-field>
                </v-col>

                <v-col cols="12" sm="12">
                  <v-autocomplete :items="costs" :rules="serviceRules" label="Service"
                    @change="(event) => updateTotal(event)" multiple v-model="ticket.list"></v-autocomplete>
                </v-col>
                <v-col cols="12">
                  <v-autocomplete :items="[
                    'Hardware change',
                    'Software change',
                    'Impacts',
                    'Not sure',
                  ]" label="Recent Incidents" v-model="ticket.incidents" multiple></v-autocomplete>
                </v-col>
                <v-col cols="12" sm="12">
                  <v-textarea filled auto-grow label="Description" v-model="ticket.description" rows="2" row-height="30"
                    shaped></v-textarea>
                </v-col>
                <v-col cols="12" sm="12">
                  <v-autocomplete :items="campaigns" label="Campaigns" v-model="ticket.campaign_title"></v-autocomplete>

                </v-col>
              </v-row>
            </v-container>
            <v-container class="px-15">
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
            <v-card-subtitle>
              <!-- <v-layout row>
                <span> Opening a ticket attracts a fee of </span>
                <span class="font-weight-bold ml-2">{{ 2500 }}</span>
              </v-layout> -->
            </v-card-subtitle>
            <v-card :loading="loadingConfirm" class="mx-auto mt-12" max-width="374">
              <template slot="progress">
                <v-progress-linear color="primary" height="5" indeterminate></v-progress-linear>
              </template>

              <v-card-text class="pb-10">
                <v-layout column>
                  <v-layout row class="mx-10 mt-10">
                    <span class="font-weight-bold mr-3"> Client</span>
                    <span>{{ select }}</span>
                  </v-layout>
                  <v-layout row class="mx-10 mt-5">
                    <span class="font-weight-bold mr-3"> Service</span>
                    <span>{{ ticket.list }}</span>
                  </v-layout>
                  <v-layout row class="mx-10 mt-5">
                    <span class="font-weight-bold mr-3"> Brand</span>
                    <span>{{ ticket.item_brand }}</span>
                  </v-layout>
                  <v-layout row class="mx-10 mt-5">
                    <span class="font-weight-bold mr-3"> Model</span>
                    <span>{{ ticket.item_model }}</span>
                  </v-layout>
                  <v-layout row class="mx-10 mt-5">
                    <span class="font-weight-bold mr-3"> SN</span>
                    <span>{{ ticket.item_sn }}</span>
                  </v-layout>
                  <v-layout row class="mx-10 mt-5">
                    <span class="font-weight-bold mr-3">Description</span>
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
      costs: [],
      costsData: [],


      // descriptionLimit: 60,
      // entries: [],
      // isLoading: false,
      // model: null,
      // search: null,

      e1: 1,
      valid: false,
      valid2: false,
      ticketOpened: false,
      ticket: {
        client_name: "",
        issuer: "",
        totalCost: 0,
        item_brand: null,
        service: null,
        main_service: "Comp Care",
        incidents: null,
        description: null,
        item_model: null,
        item_sn: null,
        SN: null,
        costs_metadata: [],
        campaign_title: "",
      },

      campaigns: [],


      // client: {
      //   name: "",
      //   id_type: "",
      //   id_no: "",
      //   email: "",
      //   phone: "",
      //   residence: "",
      //   institution: "",
      //   age: "",
      //   gender: "",
      // },
      nameRules: [(v) => !!v || "Name is required"],
      SNRules: [(v) => !!v || "SN is required"],
      serviceRules: [(v) => !!v || "Service is required"],
      // emailRules: [(v) => /.+@.+/.test(v) || "E-mail must be valid"],
      phoneRules: [(v) => !!v || "Phone number is required"],
    };
  },
  methods: {
    updateTotal(value) {
      this.ticket.totalCost = 0;
      this.ticket.costs_metadata = [];

      value.forEach((element, index) => {
        // this.ticket.totalCost =
        //   this.ticket.totalCost + this.costsData[index].fee;

        // //add to array that will be sent to the Invoice controller
        // this.ticket.costs_metadata.push(this.costsData[index]);

        for (let i = 0; i < this.costsData.length; i++) {
          if (this.costsData[i].name == element) {
            this.ticket.totalCost =
              this.ticket.totalCost + this.costsData[i].fee;
            this.ticket.costs_metadata.push(this.costsData[i]);
          }
        }
      });
      console.log(this.ticket.costs_metadata);


    },
    cancelForm() {
      this.entries = [];
      this.items = [];
      this.ticket.item_brand = "";
      this.ticket.list = "";
      this.ticket.incidents = "";
      this.ticket.description = "";
      this.ticket.item_model = "";
      this.ticket.item_sn = "";
      this.ticket.client_name = "";
      this.ticket.totalCost = 0,
        this.costs = [],
        this.costsData = [],
        this.ticket.costs_metadata = [],
        this.select = "";
      this.ticketOpened = false;
      this.loadingConfirm = false;
      this.confirmDone = false;
      this.displayText = "";
      this.ticketStatus = false;
      this.ticketStatusButton = true;
      this.ticket.campaign_title= "";
      this.e1 = 1;
      this.$refs.form2.resetValidation();
      this.$emit("cancelForm");
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
        // courses: this.selectedCourses,
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
    // register() {
    //   if (this.$refs.form.validate()) {
    //     axios
    //       .post("api/client/store", { client: this.client })

    //       .then((response) => {
    //         if (response.status == 201) {
    //           if (this.client.name) {
    //             this.select = this.client.name + " , " + this.client.phone;
    //             // this.e1 = 2;
    //             this.goStep2;
    //             this.querySelections(this.select);
    //             console.log(this.select);
    //           }
    //         }
    //       })
    //       .catch((error) => {
    //         console.log(error.response.data);
    //       });
    //   }
    // },
    goStep3() {
      if (this.$refs.form2.validate()) {
        this.ticket.client_name = this.select;
        // this.ticket.list= 'working';
        // this.ticket.incidents='incide';
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
    goStep2() {
      this.loadCosts();
      this.loadCampaigns();

      this.e1 = 2;
    },
    backStep2() {
      if (this.ticketOpened) {
        this.cancelForm();
      } else {
        this.e1 = this.e1 - 1;
      }
    },

    loadCampaigns() {
      axios
        .get("api/campaigns/" + "ComputerCare")
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
    reloadCosts() {
      axios
        .get("api/costs/" + "ComputerCare")
        .then((response) => {
          // this.entries = response.data
          // this.costsData = response.data;
          this.campaigns = response.data.map((res) => {
            // const clientList = res.name + " , " + res.phone;
            return res.title;
            // this.entries = Object.assign(clientList);
          });

          // console.log(this.costsData);

          //load the courses and associated costs with IT Training.
        })
        .catch((error) => {
          console.log(error);
        });
    },
    confirm() {
      this.loadingConfirm = true;

      axios
        .post("api/ticket/store", { ticket: this.ticket })

        .then((response) => {
          this.ticket.SN = response.data;
          console.log("main ticket opened!");
          axios
            .post("api/ticket/comp_care/store", { ticket: this.ticket })

            .then((response) => {
              if (response.status == 201) {
                this.loadingConfirm = false;
                this.confirmDone = true;
                this.displayText = "Ticket opened!";
                this.ticketStatus = true;
                this.ticketOpened = true;
                this.ticketStatusButton = false;
              }
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

    loadCosts() {
      axios
        .get("api/costs/" + "ComputerCare")
        .then((response) => {
          // this.entries = response.data
          this.costsData = response.data;
          this.costs = response.data.map((res) => {
            // const clientList = res.name + " , " + res.phone;
            return res.name;
            // this.entries = Object.assign(clientList);
          });

          // console.log(this.costsData);

          //load the courses and associated costs with IT Training.
        })
        .catch((error) => {
          console.log(error);
        });

      //load the courses and associated costs with IT Training.
    },
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
  created() {
    // this.loadCosts();
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
@-moz-keyframes loader {
  from {
    transform: rotate(0);
  }

  to {
    transform: rotate(360deg);
  }
}

@-webkit-keyframes loader {
  from {
    transform: rotate(0);
  }

  to {
    transform: rotate(360deg);
  }
}

@-o-keyframes loader {
  from {
    transform: rotate(0);
  }

  to {
    transform: rotate(360deg);
  }
}

@keyframes loader {
  from {
    transform: rotate(0);
  }

  to {
    transform: rotate(360deg);
  }
}
</style>
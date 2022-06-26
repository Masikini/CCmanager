<template>
  <v-app>
    <!--  -->

    <span class="headline my-5">IT Consultancy Form</span>

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
          <v-form v-model="valid" ref="form" @submit.prevent="submit">
            <v-container class="pa-15">
              <span class="headline">New Client</span>
              <v-row>
                <v-col cols="12">
                  <v-text-field
                    label="Full Name*"
                    hint="Verifiable by ID"
                    persistent-hint
                    required
                    v-model="client.name"
                    :rules="nameRules"
                    counter="30"
                  ></v-text-field>
                </v-col>
                <v-col cols="6">
                  <v-select
                    :items="['NID', 'Passport']"
                    label="ID Type"
                    v-model="client.id_type"
                  ></v-select>
                </v-col>
                <v-col cols="6">
                  <v-text-field
                    label="ID No"
                    hint="Verifiable by ID"
                    persistent-hint
                    v-model="client.id_no"
                  >
                  </v-text-field>
                </v-col>
                <v-col sm="6">
                  <v-text-field
                    label="Email"
                    v-model="client.email"
                  ></v-text-field>
                </v-col>
                <v-col sm="6">
                  <v-text-field
                    label="Phone Number*"
                    type="number"
                    v-model="client.phone"
                    counter="12"
                    required
                    :rules="phoneRules"
                  ></v-text-field>
                </v-col>
                <v-col sm="6">
                  <v-text-field
                    label="Address"
                    v-model="client.residence"
                  ></v-text-field>
                </v-col>
                <v-col sm="6">
                  <v-text-field
                    label="Institution/Company"
                    v-model="client.institution"
                  ></v-text-field>
                </v-col>
                <v-col sm="6">
                  <v-select
                    :items="['7-17', '18-29', '30+']"
                    label="Age"
                    v-model="client.age"
                  ></v-select>
                </v-col>
                <v-col sm="6">
                  <v-select
                    :items="['M', 'F']"
                    label="Gender"
                    v-model="client.gender"
                  ></v-select>
                </v-col>
              </v-row>
            </v-container>

            <v-container class="px-15">
              <v-btn color="primary" @click="register"> Register </v-btn>

              <v-btn text @click="existingClient"> Already a Client </v-btn>
            </v-container>
          </v-form>
        </v-stepper-content>

        <v-stepper-content step="2">
          <v-form v-model="valid2" ref="form2" @submit.prevent="submit">
            <v-container class="pa-15">
              <span class="headline mb-15">Client</span>
              <v-row>
                <v-col cols="12">
                  <v-chip v-if="newClient" class="mx-4" color="secondary">
                    {{ registeredClient }}</v-chip
                  >

                  <v-autocomplete
                    v-if="!newClient"
                    v-model="select"
                    :loading="loading"
                    :items="items"
                    :search-input.sync="search"
                    :rules="nameRules"
                    clearable
                    item-text="clientList"
                    item-value="clientList"
                    class="mx-4"
                    flat
                    hide-no-data
                    hide-details
                    placeholder="Type name or phone number"
                    rounded
                    filled
                    return-object
                  ></v-autocomplete>
                </v-col>
                <v-col sm="12">
                  <v-text-field
                    label="Designation"
                    v-model="ticket.rep_designation"
                  ></v-text-field>
                </v-col>
                <v-col sm="12">
                  <v-autocomplete
                    :items="[
                      'IT Procurement',
                      'IT Assessment',
                      'Project Delivery',
                      'Other',
                    ]"
                    label="Service"
                    multiple
                    :rules="serviceRules"
                    v-model="ticket.service"
                  ></v-autocomplete>
                </v-col>

                <v-col cols="12">
                  <v-textarea
                    filled
                    auto-grow
                    label="Extra Info"
                    v-model="ticket.description"
                    rows="2"
                    row-height="30"
                    shaped
                  ></v-textarea>
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
              <v-layout row>
                <span> Opening a ticket attracts a fee of </span>
                <span class="font-weight-bold ml-2">{{ 2500 }}</span>
              </v-layout>
            </v-card-subtitle>
            <v-card
              :loading="loadingConfirm"
              class="mx-auto mt-12"
              max-width="374"
            >
              <template slot="progress">
                <v-progress-linear
                  color="orange darken-1"
                  height="5"
                  indeterminate
                ></v-progress-linear>
              </template>

              <v-card-text class="pb-10">
                <v-layout column>
                  <v-layout row class="mx-10 mt-10">
                    <span class="font-weight-bold mr-3"> Client</span>
                    <span v-if="!newClient">{{ alreadyClientName }}</span>
                    <span v-if="newClient">{{ registeredClient }}</span>
                  </v-layout>

                  <v-layout
                    v-if="ticket.rep_designation"
                    row
                    class="mx-10 mt-10"
                  >
                    <span class="font-weight-bold mr-3"> Designation</span>
                    <span>{{ ticket.rep_designation }}</span></v-layout
                  >
                  <v-layout row class="mx-10 mt-5">
                    <span class="font-weight-bold mr-3"> Service</span>
                    <span>{{ serviceShow }}</span></v-layout
                  >

                  <v-layout row class="mx-10 mt-5">
                    <span class="font-weight-bold mr-3">Extra Info</span>
                    <span>{{ ticket.description }}</span></v-layout
                  >
                </v-layout>
              </v-card-text>
            </v-card>
            <v-card-text class="mt-2 text-center">
              <v-chip
                v-if="confirmDone"
                close-icon="mdi-close-outline"
                :color="ticketStatus ? 'green' : 'red'"
                >{{ displayText }}</v-chip
              >
            </v-card-text>
            <v-card-actions class="mt-10">
              <v-btn
                color="primary"
                @click="confirm"
                v-if="ticketStatusButton"
                :disabled="loadingConfirm"
              >
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
export default {
  data() {
    return {
      newClient: false,
      registeredClient: "",
      alreadyClientName: "",
      loading: false,
      entries: [],
      search: null,
      select: null,
      loadingConfirm: false,
      confirmDone: false,
      displayText: "",
      ticketStatus: false,
      ticketStatusButton: true,
      serviceShow: "",
      alreadyClient: false,

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
        institution: "",
        service: "",
          main_service:"IT Consultancy",
        rep_designation: "",
        rep_mail: "",
        address: "",
        description: null,
        rep_phone: "",
      },
      client: {
        name: "",
        id_type: "",
        id_no: "",
        email: "",
        phone: "",
        residence: "",
        institution: "",
        age: "",
        gender: "",
      },
      nameRules: [(v) => !!v || "Name is required"],

      serviceRules: [(v) => !!v || "A service is required"],
      // emailRules: [(v) => /.+@.+/.test(v) || "E-mail must be valid"],
      phoneRules: [(v) => !!v || "Phone number is required"],
    };
  },
  methods: {
    cancelForm() {
      this.e1 = 1;
      // this.alreadyClient = false;
      this.entries = [];
      this.items = [];
      this.newClient = false;
      this.registeredClient = "";
      this.alreadyClientName = "";
      this.serviceShow = "";
      this.select = "";
      this.ticketOpened = false;
      this.loadingConfirm = false;
      this.confirmDone = false;
      this.displayText = "";
      this.ticketStatus = false;
      this.ticketStatusButton = true;

      this.ticket.service = "";
      this.ticket.address = "";
      this.ticket.description = "";
      this.ticket.institution = "";
      this.ticket.client_name = "";
      this.ticket.rep_designation = "";
      this.ticket.issuer = "";
      this.ticket.rep_mail = "";
      this.ticket.rep_phone = "";

      this.$refs.form2.resetValidation();

      this.client.name = "";
      this.client.id_type = "";
      this.client.id_no = "";
      this.client.email = "";
      this.client.phone = "";
      this.client.residence = "";
      this.client.institution = "";
      this.client.age = "";
      this.client.gender = "";
      this.$refs.form.resetValidation();

      this.$emit("cancelFormConsultancy");
    },
    register() {
      if (this.$refs.form.validate()) {
        axios
          .post("api/client/store", { client: this.client })

          .then((response) => {
            if (response.status == 201) {
              if (this.client.name) {
                this.newClient = true;
                this.registeredClient =
                  this.client.name + " , " + this.client.phone;

                this.e1 = 2;
                console.log(this.registeredClient);
              }
            }
          })
          .catch((error) => {
            console.log(error.response.data);
          });
      }
    },

    goStep3() {
      if (this.$refs.form2.validate()) {
        this.ticket.client_name = this.select;

        this.serviceShow = this.ticket.service.toString().replace(/"|]|\[/, "");
        this.ticket.issuer = this.client.name;
        this.ticket.client_name = this.client.name;
        this.ticket.address = this.client.address;
        this.ticket.institution = this.client.institution;
        this.ticket.rep_mail = this.client.email;
        this.ticket.address = this.client.residence;
        this.ticket.rep_phone = this.client.phone;

        console.log(this.ticket);
        this.confirmDone = false;
        this.displayText = "";
        this.ticketStatus = false;
        this.loadingConfirm = false;
        this.ticketOpened = false;

        // console.log(this.select);

        // this.ticket.institution = this.select.institution;
        if (this.select && this.alreadyClient) {
          this.alreadyClientName = this.select.name + "," + this.select.phone;
          this.ticket.rep_phone = this.select.phone;
          this.ticket.rep_mail = this.select.email;
          this.ticket.address = this.select.residence;
          this.ticket.issuer = this.select.name;
          this.ticket.client_name = this.select.name;
          console.log(this.ticket);
        }

        if (!this.newClient) {
          this.select = this.select.clientList;
        }

        this.e1 = 3;
      }
    },
    backStep2() {
      if (this.newClient) {
        this.newClient = false;
      }
      if (this.ticketOpened) {
        this.cancelForm();
      } else {
        this.e1 = this.e1 - 1;
      }
    },
    confirm() {
      this.loadingConfirm = true;

      axios
        .post("api/ticket/store", { ticket: this.ticket })

        .then((response) => {
          if (response.status == 201) {
            console.log("main ticket opened!");
            axios
              .post("api/ticket/it_consult/store", { ticket: this.ticket })

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
                this.displayText = "Unable to open consultancy ticket";
                this.ticketStatus = false;
                this.loadingConfirm = true;
                this.ticketOpened = false;
                console.log(error.response.data);
              });
          } else{
            console.log("Response was not 201", response.status);
          }
        })
        .catch((error) => {
          console.log("Unable to open  main ticket", error.response.data);
        });
    },

    existingClient() {
      this.alreadyClient = true;
      this.e1 = 2;
    },
  },
  computed: {
    fields() {
      if (!this.select) return [];

      return Object.keys(this.select).map((key) => {
        return {
          key,
          value: this.select[key] || "n/a",
        };
      });
    },

    items() {
      return this.entries.map((res) => {
        const clientList = res.name + " , " + res.phone;

        // console.log(res);
        return Object.assign({}, res, { clientList });
      });
    },
  },

  watch: {
    search(val) {
      // Items have already been loaded
      if (this.items.length > 0) return;

      // Lazily load input items
      axios
        .get("api/clients")
        .then((response) => {
          this.entries = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>

<style>
</style>
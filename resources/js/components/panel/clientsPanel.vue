<template>
  <v-container class="justify-center mt-15">
    <v-row>
      <v-col sm="12" cols="12" class="justify-center my-2">
        <div>
          <!-- Side panel -->
          <!-- <component :is="loadTicket" v-bind="clientProperties" />
          
           -->

          <v-container class="d-flex justify-center">
            <v-row>
              <v-col sm="12"  cols="12" class="justify-center my-2">
                <v-scroll-y-transition mode="out-in">
                  <div v-if="clientProperties">
                    <v-row justify="center">
                      <v-icon class="hidden-xs-only"
                        v-if="this.client.gender == 'F'"
                        size="100"
                        color="blue darken-2"
                      >
                        mdi-face-woman
                      </v-icon>
                      <v-icon class="hidden-xs-only"
                        v-if="this.client.gender == 'M'"
                        size="100"
                        color="blue darken-2"
                      >
                        mdi-account-circle
                      </v-icon>
                        <v-icon class="hidden-sm-and-up"
                        v-if="this.client.gender == 'F'"
                        size="90"
                        color="blue darken-2"
                      >
                        mdi-face-woman
                      </v-icon>
                      <v-icon class="hidden-sm-and-up"
                        v-if="this.client.gender == 'M'"
                        size="90"
                        color="blue darken-2"
                      >
                        mdi-account-circle
                      </v-icon>
                      <v-col sm="12" cols="12" class="justify-center">
                        <v-layout row justify-center align-center>
                          <span class="justify-center headline">
                            {{ this.client.name }}
                          </span>
                        </v-layout>
                      </v-col>
                      <v-col sm="12" cols="12" class="justify-center">
                        <v-layout row justify-center align-center>
                          <span class="justify-center headline"
                            >{{ this.client.phone }}
                          </span>
                        </v-layout>
                      </v-col>

                      <v-col sm="12" cols="12" class="justify-center mx-2 mt-1">
                        <v-layout column align-left>
                          <v-list>
                            <v-list-group
                              :value="false"
                              prepend-icon="mdi-details"
                            >
                              <template v-slot:activator>
                                <v-list-item-title>Details</v-list-item-title>
                              </template>
                              <v-list-item-content>
                                <v-sheet
                                  class="mr-1 pa-5"
                                  color="grey lighten-3"
                                >
                                  <v-layout column align-start>
                                    <v-layout row align-start>
                                      <span
                                        class="
                                          sub-headline
                                          mr-3
                                          font-weight-bold
                                        "
                                      >
                                        Email:
                                      </span>
                                      {{ this.client.email }}
                                    </v-layout>
                                    <v-layout row align-start>
                                      <span
                                        class="
                                          sub-headline
                                          mr-3
                                          font-weight-bold
                                        "
                                      >
                                        Residence:
                                      </span>
                                      {{ this.client.residence }}
                                    </v-layout>
                                    <v-layout row align-start>
                                      <span
                                        class="
                                          sub-headline
                                          mr-3
                                          font-weight-bold
                                        "
                                      >
                                        ID:
                                      </span>
                                      {{ this.client.id_type }} ,
                                      {{ this.client.id_no }}
                                    </v-layout>
                                  </v-layout>
                                </v-sheet>
                                <v-list-item-title class="mt-5"
                                  >Services</v-list-item-title
                                >
                                <v-sheet
                                  class="mr-1 pa-5"
                                  color="grey lighten-3"
                                >
                                  List of top 5 services will be listed here
                                </v-sheet>
                              </v-list-item-content>
                            </v-list-group>
                          </v-list>
                        </v-layout>
                      </v-col>

                      <v-col sm="12" cols="12" class="justify-center">
                        <v-card flat>
                          <v-card-title> Subscriptions</v-card-title>

                          <v-card-text class="justify-center">
                            <!-- <v-container
                              v-for="(proc, index) in $store.state.ticket
                                .tickProcedures"
                              :key="proc.id"
                            >
                              <v-sheet class="mr-1 pa-5" color="grey lighten-3">
                                {{ proc.summary }}
                              </v-sheet>
                            </v-container> -->
                            <v-layout
                              row
                              justify-space-around
                              align-content-space-around
                              class="mt-5"
                            >
                              <v-btn fab dark color="indigo">
                                <v-icon dark> mdi-plus </v-icon>
                              </v-btn>

                              <v-btn fab dark color="#25D366" @click="gotoLink">
                                <v-icon dark> mdi-whatsapp </v-icon>
                              </v-btn>
                            </v-layout>
                          </v-card-text>
                        </v-card>
                      </v-col>
                    </v-row>
                  </div>

                  <span v-if="!clientProperties"> Select a Client </span>
                </v-scroll-y-transition>
              </v-col>
            </v-row>
          </v-container>
        </div>
      </v-col>
    </v-row>
  </v-container>
</template> 

<script>
import computerCare from "./tickets/computerCare";

export default {
  components: { computerCare },
  data() {
    return {
      entries: [],

      client: null,

      handlingTicket: false,
    };
  },
  components: {
    computerCare,
  },
  methods: {
    gotoLink() {
      let link = "www.wa.me/" + this.client.phone;
        return {
              is: 'a',
            href: url,
            target: '_blank',
            rel: 'noopener'
          };
    },

    addHandler() {
      this.handlingTicket = true;
      this.client.handler = "me";
      // console.log(
      //   "Number of procedures: ",
      //   this.$store.getters.availableProcedures
      // );
      if (this.$store.getters.availableProcedures < 0) {
        this.numberOfProcedures = true;
      } else {
        this.numberOfProcedures = false;
      }
    },

    reloadProcedures() {
      axios
        .get("api/procedure/" + this.client.id)

        .then((response) => {
          if (response.status == 200) {
            // console.log(response.data);
            this.ticketProcedures = response.data;
            this.$store.commit(
              "selectedTicketProcedures",
              this.ticketProcedures
            );
          } else {
            console.log("unable to Reload procedures!");
          }
        })
        .catch((error) => {
          console.log(error.response.data);
        });
    },
  },

  computed: {
    
    clientProperties() {
      this.handlingTicket = false;
      this.client = this.$store.state.client.selected;

      if (this.$store.state.client.selected == null) {
        return false;
      } else {
        return true;
      }
    },
    handleTicket() {
      if (this.client.status == "open" && this.client.handler == null) {
        return true;
      } else {
        // this.loadingProceduresDisplay = true;
        // setTimeout(() => (this.loadingProceduresDisplay = false), 3000)

        return false;
      }
    },
    isTicketOpened() {
      if (this.$store.state.client.selected.status == "open") {
        return false;
      } else {
        return true;
      }
    },

    isTicketHandled() {
      this.ticketInviteMenu = false;
      this.ticketAssignMenu = false;
      if (this.$store.state.client.selected.handler) {
        return true;
      } else {
        return false;
      }
    },
  },

  watch: {},
};
</script>

<style scoped>
.v-card--reveal {
  bottom: 0;
  opacity: 1 !important;
  position: absolute;
  width: 100%;
}
</style>
<template>
  <v-container class="justify-center mt-15">
    <v-row>
      <v-col cols="12" sm="12" class="justify-center my-2">
        <div>
          <!-- Side panel -->
          <!-- <component :is="loadTicket" v-bind="ticketProperties" />
          
           -->

          <v-container class="d-flex justify-center">
            <v-row>
              <v-col cols="12" sm="12" class="justify-center my-2">
                <v-scroll-y-transition mode="out-in">
                  <div v-if="ticketProperties">
                    <v-row justify="center">
                      <v-col cols="12" sm="12" class="justify-center">
                        <v-layout row justify-center align-center>
                          <span class="justify-center headline text-center">
                            Ticket # {{ ticket.id_no }}
                          </span>
                        </v-layout>
                      </v-col>
                      <v-col cols="12" sm="12" class="justify-center">
                        <v-layout row justify-center align-center>
                          <span class="justify-center headline">{{ ticket.service }}
                          </span>
                        </v-layout>
                      </v-col>


                      <!-- <v-col sm="4" class="mt-5 ">
                        Total
                      </v-col>
                      <v-col sm="4" class="justify-center mt-5">
                        Paid
                      </v-col>
                      <v-col sm="4" class="justify-center mt-5">
                        Bal
                      </v-col> -->



                      <v-col cols="12" sm="4" class="justify-center ">
                        <v-layout column class="align-center">
                          Total
                          <v-chip class="ma-2" color="deep-purple accent-4" outlined label>
                            MK{{ ticket.cost }}
                          </v-chip>
                        </v-layout>
                      </v-col>
                      <v-col cols="12" sm="4" class="justify-center ">
                        <v-layout column class="align-center">
                          Paid
                          <v-chip class="ma-2" color="deep-purple accent-4" outlined label>
                            MK{{ ticket.paid }}
                          </v-chip>
                        </v-layout>
                      </v-col>
                      <v-col cols="12" sm="4" class="justify-center ">
                        <v-layout column class="align-center">
                          Bal
                          <v-chip class="ma-2" color="deep-purple accent-4" outlined label>
                            MK{{ $store.getters.ticketBal }}
                          </v-chip>
                        </v-layout>
                      </v-col>

                      <v-col cols="12" sm="4" class="justify-center">
                        <v-layout column justify-center align-center>
                          <span class="font-weight-bold"> Client</span>
                          {{ ticket.client_id }}
                        </v-layout>
                      </v-col>
                      <v-col cols="12" sm="4" class="justify-center">
                        <v-layout column justify-center align-center>
                          <span class="font-weight-bold"> Issued</span>

                          {{ $store.getters.ticketCreatedAt }}
                        </v-layout>
                      </v-col>
                      <v-col cols="12" sm="4" class="justify-center">
                        <v-layout column justify-center align-center>
                          <span class="font-weight-bold"> Status</span>
                          {{ ticket.status }}
                        </v-layout>
                      </v-col>
                      <v-col cols="12" sm="12">

                        <v-layout row align-content-space-between class="hidden-xs-only">
                          <div>
                            <TicketNotes />
                          </div>
                          <div>
                            <TicketInvoice />
                          </div>
                          <div>
                            <TicketCheckout />
                          </div>
                        </v-layout>
                        <v-layout column align-content-space-between class="hidden-sm-and-up">
                          <div>
                            <TicketNotes />
                          </div>
                          <div style="margin-top:5px;">
                            <TicketInvoice />
                          </div>
                          <div>
                            <TicketCheckout />
                          </div>
                        </v-layout>
                      </v-col>
                      <v-col cols="12" sm="12" class="justify-center mx-2 mt-1">
                        <v-layout column align-left>
                          <v-list>
                            <v-list-group :value="false" prepend-icon="mdi-details">
                              <template v-slot:activator>
                                <v-list-item-title>Details</v-list-item-title>
                              </template>
                              <v-list-item-content>
                                <v-sheet v-if="
                                  $store.getters.ticketService ==
                                  'IT Training'
                                " class="mr-1 pa-5" color="grey lighten-3">
                                  <v-layout column align-start>
                                    <v-layout row align-start>
                                      <span class="
                                          sub-headline
                                          mr-3
                                          font-weight-bold
                                        ">
                                        Course(s):
                                      </span>
                                      {{ $store.state.ticket.selected.list }}
                                    </v-layout>
                                    <v-layout row align-start>
                                      <span class="
                                          sub-headline
                                          mr-3
                                          font-weight-bold
                                        ">
                                        Schedule:
                                      </span>
                                      {{ ticket.item_model }}
                                    </v-layout>
                                    <v-layout row align-start>
                                      <span class="
                                          sub-headline
                                          mr-3
                                          font-weight-bold
                                        ">
                                        Joined:
                                      </span>
                                      {{ ticket.item_model }}
                                    </v-layout>
                                    <v-layout row align-start>
                                      <span class="
                                          sub-headline
                                          mr-3
                                          font-weight-bold
                                        ">
                                        Ending:
                                      </span>
                                      {{ ticket.item_sn }}
                                    </v-layout>
                                  </v-layout>
                                </v-sheet>
                                <v-list-item-title>Description</v-list-item-title>
                                <v-sheet class="mr-1 pa-5" color="grey lighten-3">
                                  {{ ticket.description }}
                                </v-sheet>
                              </v-list-item-content>
                            </v-list-group>
                          </v-list>
                        </v-layout>
                      </v-col>

                    </v-row>
                  </div>

                  <span v-if="!ticketProperties"> Select a Ticket </span>
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
import TicketNotes from "../dialogs/ticketNotes.vue";
import TicketInvoice from "../dialogs/ticketInvoice.vue";
import TicketCheckout from "../dialogs/ticketCheckout.vue";

export default {
  components: {
    computerCare,
    TicketNotes,
    TicketInvoice,
    TicketCheckout,
  },
  data() {
    return {
      formRules: [(v) => !!v || "Required"],
      entries: [],

      ticketCloseDialog: false,
      ticketSendQuoteDialog: false,

      ticketNotesDialog: false,
      // checkboxChange: [],
      // procExtraInfo: "",
      // inviteeMsg: "",
      // assigneeMsg: "",

      ticket: null,
      // addedTicketMethods: [],
      revealSummary: false,
      // handlingTicket: false,

      itemsList: [], //list of selected services



      formRules: [(v) => !!v || "This is required"],
    };
  },

  methods: {


    notesDialog() {
      //open up the dialog box
      this.ticketNotesDialog = true;
    },


    cancelSendQuote() {
      this.ticketSendQuoteDialog = false;
    },


  },

  computed: {
    items() {
      return this.entries.map((res) => {
        const clientList = res.name;

        // console.log(res);
        return Object.assign({}, res, { clientList });
      });
    },

    ticketProperties() {
      // this.handlingTicket = false;
      this.ticket = this.$store.state.ticket.selected;

      if (this.$store.state.ticket.selected == null) {
        return false;
      } else {
        return true;
      }
    },
    handleTicket() {
      if (this.ticket.status == "open" && this.ticket.handler == null) {
        return true;
      } else {
        // this.loadingProceduresDisplay = true;
        // setTimeout(() => (this.loadingProceduresDisplay = false), 3000)

        return false;
      }
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

<style scoped>
.v-card--reveal {
  bottom: 0;
  opacity: 1 !important;
  position: absolute;
  width: 100%;
}
</style>
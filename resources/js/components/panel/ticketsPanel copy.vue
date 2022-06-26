<template>
  <v-container class="justify-center mt-15">
    <v-row>
      <v-col sm="12" class="justify-center my-2">
        <div>
          <!-- Side panel -->
          <!-- <component :is="loadTicket" v-bind="ticketProperties" />
          
           -->

          <v-container class="d-flex justify-center">
            <v-row>
              <v-col sm="12" class="justify-center my-2">
                <v-scroll-y-transition mode="out-in">
                  <div v-if="ticketProperties">
                    <v-row justify="center">
                      <v-col sm="12" class="justify-center">
                        <v-layout row justify-center align-center>
                          <span class="justify-center headline">
                            Ticket # {{ this.ticket.id_no }}
                          </span>
                        </v-layout>
                      </v-col>
                      <v-col sm="12" class="justify-center">
                        <v-layout row justify-center align-center>
                          <span class="justify-center headline"
                            >{{ this.ticket.service }}
                          </span>
                        </v-layout>
                      </v-col>
                      <v-col sm="4" class="justify-center mt-5">
                        <v-layout column justify-center align-center>
                          <span class="font-weight-bold"> Client</span>
                          {{ this.ticket.client_name }}
                        </v-layout>
                      </v-col>
                      <v-col sm="4" class="justify-center mt-5">
                        <v-layout column justify-center align-center>
                          <span class="font-weight-bold"> Issued</span>

                          {{ this.$store.getters.createdAt }}
                        </v-layout>
                      </v-col>
                      <v-col sm="4" class="justify-center mt-5">
                        <v-layout column justify-center align-center>
                          <span class="font-weight-bold"> Status</span>
                          {{ this.ticket.status }}
                        </v-layout>
                      </v-col>
                      <v-col sm="12" class="justify-center mx-2 mt-1">
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
                                        Gadget:
                                      </span>
                                      {{ this.ticket.item_brand }}
                                    </v-layout>
                                    <v-layout row align-start>
                                      <span
                                        class="
                                          sub-headline
                                          mr-3
                                          font-weight-bold
                                        "
                                      >
                                        Model:
                                      </span>
                                      {{ this.ticket.item_model }}
                                    </v-layout>
                                    <v-layout row align-start>
                                      <span
                                        class="
                                          sub-headline
                                          mr-3
                                          font-weight-bold
                                        "
                                      >
                                        SN:
                                      </span>
                                      {{ this.ticket.item_sn }}
                                    </v-layout>
                                  </v-layout>
                                </v-sheet>
                                <v-list-item-title
                                  >Description</v-list-item-title
                                >
                                <v-sheet
                                  class="mr-1 pa-5"
                                  color="grey lighten-3"
                                >
                                  {{ this.ticket.description }}
                                </v-sheet>

                                <v-container
                                  v-if="isTicketOpened ? true : false"
                                >
                                  <v-list-item-title
                                    >Procedures</v-list-item-title
                                  >
                                  <v-container
                                    v-for="(proc, index) in $store.state.ticket
                                      .tickProcedures"
                                    :key="proc.id"
                                  >
                                    <v-sheet
                                      class="mr-1 pa-5"
                                      color="grey lighten-3"
                                    >
                                      {{ proc.summary }}
                                    </v-sheet>
                                  </v-container>
                                </v-container>
                              </v-list-item-content>
                            </v-list-group>
                          </v-list>
                        </v-layout>
                      </v-col>

                      <v-col
                        sm="12"
                        class="justify-center mx-2 mt-1"
                        v-if="handlingTicket"
                      >
                        <v-divider></v-divider>
                        <span class="headline"> Procedures</span>

                        <v-layout
                          v-if="!handleTicket"
                          class="my-2"
                          row
                          justify-space-around
                        >
                         
                          <v-menu
                            v-model="procedureAddMenu"
                            :close-on-content-click="false"
                            :nudge-width="200"
                            offset-y
                          >
                            <template v-slot:activator="{ on, attrs }">
                              <v-btn
                                fab
                                dark
                                color="indigo"
                                v-bind="attrs"
                                v-on="on"
                              >
                                <v-icon dark> mdi-plus </v-icon>
                              </v-btn>
                            </template>
                            <v-form
                              v-model="procAdd"
                              ref="procAddRef"
                              @submit.prevent="submit"
                            >
                              <v-card max-width="450" min-width="300">
                                <v-list>
                                  <v-list-item>
                                    <v-list-item-content>
                                      <v-list-item-title
                                        >Adding Procedure</v-list-item-title
                                      >
                                      <v-list-item-subtitle
                                        >Select changes, add a
                                        description</v-list-item-subtitle
                                      >
                                    </v-list-item-content>
                                  </v-list-item>
                                </v-list>
                                <v-layout row justify-space-around class="mx-3">
                                  <v-checkbox
                                    v-model="checkboxChange"
                                    label="Soft"
                                    value="Software Change"
                                  ></v-checkbox>
                                  <v-checkbox
                                    v-model="checkboxChange"
                                    label="Hard"
                                    value="Hardware Change"
                                  ></v-checkbox>
                                  <v-checkbox
                                    v-model="checkboxChange"
                                    label="Other"
                                    value="Other Changes"
                                  ></v-checkbox>
                                </v-layout>

                                <v-divider></v-divider>
                                <v-textarea
                                  class="mx-5"
                                  filled
                                  auto-grow
                                  label="Extra Info"
                                  v-model="procExtraInfo"
                                  rows="2"
                                  row-height="30"
                                  shaped
                                  :rules="formRules"
                                ></v-textarea>

                                <v-card-actions>
                                  <v-spacer></v-spacer>

                                  <v-btn text @click="procedureAddMenu = false">
                                    Discard
                                  </v-btn>
                                  <v-btn
                                    color="primary"
                                    text
                                    @click="addTicketProcedure"
                                  >
                                    Add
                                  </v-btn>
                                </v-card-actions>
                              </v-card>
                            </v-form>
                          </v-menu>

                             <v-menu
                            v-model="ticketInviteMenu"
                            :close-on-content-click="false"
                            :nudge-width="200"
                            offset-y
                          >
                          <template v-slot:activator="{ on, attrs }">
                            

                              <v-btn
                                fab
                                dark
                                color="orange darken-3"
                                v-bind="attrs"
                                v-on="on"
                              >
                                <v-icon dark> mdi-account-plus </v-icon>
                              </v-btn>
                            </template> 
                            <v-form
                              v-model="procInvite"
                              ref="procInviteRef"
                              @submit.prevent="submit"
                            >
                              <v-card max-width="450" min-width="300">
                                <v-list>
                                  <v-list-item>
                                    <v-list-item-content>
                                      <v-list-item-title
                                        >Invite</v-list-item-title
                                      >
                                      <v-list-item-subtitle
                                        >Invite personnel to
                                        ticket</v-list-item-subtitle
                                      >
                                    </v-list-item-content>
                                  </v-list-item>
                                </v-list>
                                <v-layout
                                  row
                                  justify-space-around
                                  class="mx-3 my-3"
                                >
                                  <v-autocomplete
                                    v-model="invitedPersonnel"
                                    :loading="inviteeLoading"
                                    :items="items"
                                    :search-input.sync="search"
                                    :rules="formRules"
                                    clearable
                                    item-text="clientList"
                                    item-value="clientList"
                                    class="mx-4"
                                    flat
                                    hide-no-data
                                    hide-details
                                    placeholder="Type name"
                                    rounded
                                    filled
                                    return-object
                                  ></v-autocomplete>
                                </v-layout>

                                <v-textarea
                                  class="mx-5"
                                  filled
                                  auto-grow
                                  label="Short message"
                                  v-model="inviteeMsg"
                                  rows="2"
                                  row-height="30"
                                  shaped
                                ></v-textarea>

                                <v-card-actions>
                                  <v-spacer></v-spacer>

                                  <v-btn text @click="ticketInviteMenu = false">
                                    Discard
                                  </v-btn>
                                  <v-btn
                                    color="primary"
                                    text
                                    @click="inviteTicket"
                                  >
                                    Invite
                                  </v-btn>
                                </v-card-actions>
                              </v-card>
                            </v-form> 
                          </v-menu>
                          
                          <v-btn
                            fab
                            dark
                            color="green darken-4"
                            @click="ticketCloseDialog = true"
                          >
                            <v-icon dark> mdi-check </v-icon>
                          </v-btn>
                        </v-layout>
                        <v-container
                          class="mx-auto align-left"
                          v-if="!handleTicket"
                        >
                          <v-card
                            class="mx-auto green"
                            flat
                            style="width: 100%"
                          >
                            <v-card-text>
                              <v-sheet
                                v-if="numberOfProcedures"
                                class="mr-1 pa-5 mb-2"
                                color="grey lighten-3"
                              >
                                No procedures!
                              </v-sheet>

                              <v-layout
                                column
                                align-content-space-around
                                align-left
                                v-for="(procedure, index) in $store.state.ticket
                                  .tickProcedures"
                                :key="procedure.id"
                              >
                                <v-card
                                  class="mx-auto ma-2 d-flex"
                                  width="100%"
                                >
                                  <v-container>
                                    <v-card-title
                                      >Procedure
                                      {{ procedure.id }}</v-card-title
                                    >
                                    <v-card-text>
                                      <v-layout row align-content-space-around>
                                        <v-chip class="ma-1">
                                          {{ procedure.change }}
                                        </v-chip>
                                      </v-layout>
                                    </v-card-text>

                                    <v-card-actions>
                                      <v-spacer></v-spacer>

                                      <v-btn
                                        icon
                                        @click="revealSummary = !revealSummary"
                                      >
                                        <v-icon>{{
                                          revealSummary
                                            ? "mdi-chevron-up"
                                            : "mdi-chevron-down"
                                        }}</v-icon>
                                      </v-btn>
                                    </v-card-actions>
                                    <v-expand-transition>
                                      <v-card
                                        v-if="revealSummary"
                                        class="
                                          transition-fast-in-fast-out
                                          v-card--reveal
                                        "
                                        style="height: 100%"
                                      >
                                        <v-card-text class="pb-0">
                                        
                                          <p>
                                            {{ procedure.summary }}
                                          </p>
                                        </v-card-text>
                                        <v-card-actions class="pt-0">
                                          <v-btn
                                            text
                                            color="teal accent-4"
                                            @click="revealSummary = false"
                                          >
                                            Close
                                          </v-btn>
                                          <v-btn
                                            text
                                            color="red accent-4"
                                            @click="
                                              confirmProcedureDelete(procedure)
                                            "
                                          >
                                            Delete
                                          </v-btn>
                                        </v-card-actions>
                                      </v-card>
                                    </v-expand-transition>
                                  </v-container>
                                </v-card>
                              </v-layout>
                            </v-card-text>
                          </v-card>
                        </v-container>

                        <v-dialog
                          v-model="procedureDeleteDialog"
                          v-if="procedureDeleteDialog"
                          persistent
                          max-width="290"
                        >
                          <v-card>
                            <v-card-title class="headline">
                              Delete Procedure?
                            </v-card-title>
                            <v-card-text>
                              You are about to delete information from this
                              ticket, changes you make will be
                              recorded.</v-card-text
                            >
                            <v-card-actions>
                              <v-spacer></v-spacer>
                              <v-btn
                                color="green darken-1"
                                text
                                @click="declineProcedureDelete()"
                              >
                                Cancel
                              </v-btn>
                              <v-btn
                                color="green darken-1"
                                text
                                @click="deleteProcedure(deletingProcedure)"
                              >
                                Confirm
                              </v-btn>
                            </v-card-actions>
                          </v-card>
                        </v-dialog>

<!-- Ticket close dialog -->
                        <v-dialog
                          v-model="ticketCloseDialog"
                          v-if="ticketCloseDialog"
                          persistent
                          max-width="690"
                        >
                          <v-card>
                            <v-card-title class="headline">
                              Ticket resolved?
                              {{ $store.getters.availableProcedures }}
                            </v-card-title>

                            <v-card-text
                              v-if="
                                $store.getters.availableProcedures > 0
                                  ? true
                                  : false
                              "
                            >
                              This ticket is about to be marked as resolved
                            </v-card-text>
                            <v-card-text
                              v-if="
                                $store.getters.availableProcedures <= 0
                                  ? true
                                  : false
                              "
                            >
                              Please add atleast a single procedure to be able
                              to close ticket.
                            </v-card-text>
                            <v-card-actions>
                              <v-spacer></v-spacer>
                              <v-btn
                                color="green darken-1"
                                text
                                @click="declineTicketClose()"
                              >
                                Cancel
                              </v-btn>
                              <v-btn
                                color="green darken-1"
                                text
                                :disabled="
                                  $store.getters.availableProcedures <= 0
                                    ? true
                                    : false
                                "
                                @click="confirmTicketClose()"
                              >
                                Confirm
                              </v-btn>
                            </v-card-actions>
                          </v-card>
                        </v-dialog>
                      </v-col>
                   

                      <!-- -CheckOut Dialog -->
                      <v-dialog
                        v-model="ticketCheckOutDialog"
                        v-if="ticketCheckOutDialog"
                        persistent
                        max-width="590"
                      >
                        <v-form
                          v-model="checkOutApproval"
                          ref="tickCheckOutRef"
                          @submit.prevent="submit"
                        >
                          <v-card>
                            <v-card-title class="headline">
                              Checking out ticket
                              {{ $store.state.ticket.selected.id }}
                            </v-card-title>
                            <v-card-text>
                              <v-row justify="center">
                                <v-col sm="12">
                                  <v-layout
                                    row
                                    justify-space-around
                                    class="mx-3 my-3"
                                  >
                                  </v-layout>
                                </v-col>
                                <v-col sm="4">
                                  <v-text-field
                                    label="Amount"
                                    hint="Total amount"
                                    persistent-hint
                                    required
                                    :rules="formRules"
                                    v-model="checkout.tick_amount"
                                  ></v-text-field>
                                </v-col>
                                <v-col sm="4">
                                  <v-select
                                    :items="['CASH', 'CHEQUE', 'MOBILE']"
                                    label="Method"
                                    :rules="formRules"
                                    v-model="checkout.tick_payment_method"
                                  ></v-select>
                                </v-col>
                                <v-col sm="4">
                                  <v-text-field
                                    label="Ref"
                                    hint="Trans ID"
                                    persistent-hint
                                    required
                                    :rules="formRules"
                                    v-model="checkout.tick_ref"
                                  ></v-text-field>
                                </v-col>
                                <v-col sm="12">
                                  <v-file-input
                                    accept=".jpg, .jpeg, .png, .pdf"
                                    label="Receipt"
                                    v-model="checkout.receipt_attach"
                                  >
                                    <template v-slot:selection="{ text }">
                                      <v-chip small label color="orange">
                                        {{ text }}
                                      </v-chip>
                                    </template></v-file-input
                                  >
                                </v-col>
                                <v-col sm="12">
                                  <v-textarea
                                    class="mx-5"
                                    filled
                                    auto-grow
                                    label="Description"
                                    v-model="checkout.tick_description"
                                    rows="1"
                                    row-height="10"
                                    shaped
                                  ></v-textarea>
                                </v-col>
                              </v-row>
                            </v-card-text>
                            <v-card-actions>
                              <v-spacer></v-spacer>
                              <v-btn
                                color="green darken-1"
                                text
                                @click="cancelCheckout"
                              >
                                Cancel
                              </v-btn>
                              <v-btn
                                color="green darken-1"
                                text
                                @click="checkoutMethod"
                              >
                                Checkout
                              </v-btn>
                            </v-card-actions>
                          </v-card>
                        </v-form>
                      </v-dialog>

                      <v-col sm="12" v-if="!isTicketOpened">
                        <v-layout row justify-space-around>
                          <v-btn
                            tile
                            color="success"
                            @click="addHandler"
                            v-if="!isTicketHandled"
                          >
                            Handle
                          </v-btn>
                          <!-- Start of line-->

                          <v-menu
                            v-model="ticketAssignMenu"
                            :close-on-content-click="false"
                            :nudge-width="200"
                            offset-y
                          >
                            <template v-slot:activator="{ on, attrs }">
                              <v-btn
                                tile
                                color="teal"
                                v-bind="attrs"
                                v-on="on"
                                v-if="!isTicketHandled"
                              >
                                Assign
                              </v-btn>
                            </template>
                            <v-form
                              v-model="tickAssign"
                              ref="tickAssignRef"
                              @submit.prevent="submit"
                            >
                              <v-card max-width="450" min-width="300">
                                <v-list>
                                  <v-list-item>
                                    <v-list-item-content>
                                      <v-list-item-title
                                        >Assign</v-list-item-title
                                      >
                                      <v-list-item-subtitle
                                        >Assign personnel to
                                        ticket</v-list-item-subtitle
                                      >
                                    </v-list-item-content>
                                  </v-list-item>
                                </v-list>
                                <v-layout
                                  row
                                  justify-space-around
                                  class="mx-3 my-3"
                                >
                                  <v-autocomplete
                                    v-model="assignedPersonnel"
                                    :loading="assigneeLoading"
                                    :items="items"
                                    :search-input.sync="search"
                                    :rules="formRules"
                                    clearable
                                    item-text="clientList"
                                    item-value="clientList"
                                    class="mx-4"
                                    flat
                                    hide-no-data
                                    hide-details
                                    placeholder="Type name"
                                    rounded
                                    filled
                                    return-object
                                  ></v-autocomplete>
                                </v-layout>

                                <v-textarea
                                  class="mx-5"
                                  filled
                                  auto-grow
                                  label="Short message"
                                  v-model="assigneeMsg"
                                  rows="2"
                                  row-height="30"
                                  shaped
                                ></v-textarea>

                                <v-card-actions>
                                  <v-spacer></v-spacer>

                                  <v-btn text @click="ticketAssignMenu = false">
                                    Discard
                                  </v-btn>
                                  <v-btn
                                    color="primary"
                                    text
                                    @click="assignTicket"
                                  >
                                    Assign
                                  </v-btn>
                                </v-card-actions>
                              </v-card>
                            </v-form>
                          </v-menu>

                          <!-- End of line -->
                        </v-layout>
                      </v-col>

                      <v-col
                        sm="12"
                        class="justify-center"
                        v-if="isTicketOpened"
                      >
                        <v-row align="center" justify="space-around">
                          <v-btn
                            tile
                            color="orange"
                            @click="ticketCheckOutDialog = true"
                            v-if="
                              $store.state.ticket.selected.status == 'chckd'
                                ? false
                                : true
                            "
                          >
                            <!-- <v-icon left> mdi-check-outline </v-icon> -->
                            Checkout
                          </v-btn>
                          <v-chip
                            label
                            color="success"
                            v-if="
                              $store.state.ticket.selected.status == 'chckd'
                                ? true
                                : false
                            "
                          >
                            <v-icon left> mdi-check-outline </v-icon>
                            Checked</v-chip
                          >

                          <v-btn
                            tile
                            color="orange"
                            v-if="
                              $store.state.ticket.selected.status == 'chckd'
                                ? false
                                : true
                            "
                          >
                            Reopen
                          </v-btn>
                        </v-row>
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

export default {
  components: { computerCare },
  data() {
    return {
      formRules: [(v) => !!v || "Required"],
      entries: [],
      inviteeLoading: false,
      assigneeLoading: false,
      search: null,
      invitedPersonnel: null,
      assignedPersonnel: null,
      procAdd: false,
      procInvite: false,
      tickAssign: false,
      checkOutApproval: false,
      procedureAddMenu: false,
      ticketInviteMenu: false,
      ticketAssignMenu: false,
      loadingProceduresDisplay: false,
      numberOfProcedures: false,
      deletingProcedure: null,
      procedureDeleteDialog: false,
      ticketCloseDialog: false,
      ticketCheckOutDialog: false,
      checkboxChange: [],
      procExtraInfo: "",
      inviteeMsg: "",
      assigneeMsg: "",
      ticket: null,
      addedTicketMethods: [],
      revealSummary: false,
      handlingTicket: false,

      checkout: {
        tick_amount: 0,
        tick_ref: "",
        tick_description: "",
        tick_tick_id: "",
        tick_payment_method: "",
        receipt_attach: null,
      },

      procedure: {
        change: "",
        summary: "",
        carrier: "",
        tick_id: "",
      },

      tick_and_handler: {
        id: "",
        handler: "",
      },

      formRules: [(v) => !!v || "This is required"],
    };
  },
  components: {
    computerCare,
  },
  methods: {
    cancelCheckout() {
      this.ticketCheckOutDialog = false;
      this.checkout.tick_amount = "";
      this.checkout.tick_payment_method = "";
      this.checkout.tick_ref = "";
      this.checkout.receipt_attach = null;
      this.checkout.tick_description = "";
    },
    addHandler() {
      this.handlingTicket = true;

      if (!this.ticket.handler) {
        this.ticket.handler = this.$store.state.user.name;
        this.tick_and_handler.id = this.$store.state.ticket.selected.id;
        this.tick_and_handler.handler = this.$store.state.user.name;
        axios
          .put("api/ticket/addhandler/", { ticket: this.tick_and_handler })
          .then((response) => {
            if (response.status == 200) {
              console.log(response.data);
              this.handlingTicket = false;
              this.tick_and_handler.id = "";
              this.tick_and_handler.handler = "";
            } else {
              console.log("unable to add handler to ticket!");
            }
          })
          .catch((error) => {
            console.log(error.response.data);
          });
      }

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
    inviteTicket() {
      if (this.$refs.procInviteRef.validate()) {
        console.log("Inviting ");
        this.ticketInviteMenu = false;
        this.inviteeMsg = "";
        setTimeout(() => this.$refs.procInviteRef.resetValidation(), 3000);
      }
    },
    assignTicket() {
      if (this.$refs.tickAssignRef.validate()) {
        console.log("Assigning ");
        this.ticketAssignMenu = false;
        this.assigneeMsg = "";
        setTimeout(() => this.$refs.tickAssignRef.resetValidation(), 3000);
      }
    },
    addTicketProcedure() {
      this.procedure.change = "";
      this.procedure.tick_id = "";
      this.procedure.carrier = "";
      this.procedure.summary = "";

      if (this.$refs.procAddRef.validate()) {
        this.procedure.change = this.checkboxChange;
        this.procedure.tick_id = this.ticket.id_no;
        this.procedure.carrier = this.$store.state.user.name;
        this.procedure.summary = this.procExtraInfo;

        // console.log(this.procedure);
        axios
          .post("api/procedure/store/", {
            procedure: this.procedure,
          })

          .then((response) => {
            if (response.status == 201) {
              // console.log(response.data);
              this.checkboxChange = [];
              this.procExtraInfo = "";
              this.procedureAddMenu = false;
              this.reloadProcedures();
            } else {
              console.log("unable to add method!");
            }
          })
          .catch((error) => {
            console.log(error.response.data);
          });
      } else {
        setTimeout(() => this.$refs.procAddRef.resetValidation(), 3000);
      }
    },
    reloadProcedures() {
      axios
        .get("api/procedure/" + this.ticket.id_no)

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

    confirmProcedureDelete(id) {
      this.deletingProcedure = id;
      this.procedureDeleteDialog = true;
    },

    confirmTicketClose() {
      axios
        .put("api/ticket/" + this.$store.state.ticket.selected.id)
        .then((response) => {
          if (response.status == 200) {
            this.$store.state.ticket.selected.status = "closed";
            this.ticketCloseDialog = false;
          } else {
            console.log("unable to close ticket!");
          }
        })
        .catch((error) => {
          console.log(error.response.data);
        });
    },
    declineTicketClose() {
      this.ticketCloseDialog = false;
    },
    declineProcedureDelete() {
      this.deletingProcedure = null;
      this.procedureDeleteDialog = false;
    },

    deleteProcedure(id) {
      console.log("Deleting Id ", id.id);

      axios
        .delete("api/procedure/" + id.id)
        .then((response) => {
          if (response.status == 200) {
            this.$store.commit("spliceProcedures", id);
            this.deletingProcedure = null;
            this.procedureDeleteDialog = false;
            console.log("deleted!");
          } else {
            console.log("unable to reload procedures!");
          }
        })
        .catch((error) => {
          console.log(error.response.data);
        });
    },

    checkoutMethod() {
      let formData = new FormData();
      // formData.append("receipt_attach", this.checkout.receipt_attach);
      // formData.append("checkout", this.checkout);
      this.checkout.tick_tick_id = this.$store.state.ticket.selected.id_no;
      formData.append("tick_amount", this.checkout.tick_amount);
      formData.append("tick_ref", this.checkout.tick_ref);
      formData.append("tick_description", this.checkout.tick_description);
      formData.append("tick_tick_id", this.checkout.tick_tick_id);
      formData.append("tick_payment_method", this.checkout.tick_payment_method);
      formData.append("receipt_attach", this.checkout.receipt_attach);

      if (this.$refs.tickCheckOutRef.validate()) {
        console.log("checking out");
        //  { checkout: this.checkout },
        axios
          .post("api/sales/store", formData, {
            headers: {
              "Content-Type": "multipart/form-data",
            },
          })

          .then((response) => {
            console.log(response.data);
            if (response.status == 200) {
              try {
                axios
                  .put(
                    "api/ticket/check/" + this.$store.state.ticket.selected.id
                  )
                  .then((response) => {
                    if (response.status == 200) {
                      console.log("Succsefully made sale");
                      this.$store.state.ticket.selected.status = "chckd";
                      this.ticketCheckOutDialog = false;
                    }
                  })
                  .catch((error) => {
                    console.log(error);
                  });
              } catch (error) {
                console.log(error);
              }
            } else console.log("failed to check out");
          })
          .catch((error) => {
            console.log(error.response.data);
          });
      } else {
        setTimeout(() => this.$refs.tickCheckOutRef.resetValidation(), 3000);
      }
    },
  },

  computed: {
    // isitchecked() {
    //   axios
    //     .get("api/sales/" + this.$store.state.ticket.selected.id_no)

    //     .then((response) => {
    //       if (response.status == 200) {
    //         if (response.data) {
    //           console.log(response.data);
    //           axios
    //             .put(
    //               "api/ticket/check/" + this.$store.state.ticket.selected.id_no
    //             )
    //             .then((response) => {
    //               if (response.status == 200) {
    //                 console.log("Greater than 0 :", response.data);
    //                  return true;
    //               }
    //             })
    //             .catch((error) => {
    //               console.log(error);
    //             });

    //         } else {
    //           console.log("Less than 0 :", response.data);
    //           return false;
    //         }
    //         // console.log(response.data);
    //         // this.ticketProcedures = response.data;
    //         // this.$store.commit(
    //         //   "selectedTicketProcedures",
    //         //   this.ticketProcedures
    //         // );
    //       } else {
    //         console.log("cant identify if checked or not!");
    //       }
    //     })
    //     .catch((error) => {
    //       console.log(error.response.data);
    //     });
    // },
    items() {
      return this.entries.map((res) => {
        const clientList = res.name;

        // console.log(res);
        return Object.assign({}, res, { clientList });
      });
    },

    ticketProperties() {
      this.handlingTicket = false;
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
    isTicketOpened() {
      if (this.$store.state.ticket.selected.status == "open") {
        return false;
      } else {
        return true;
      }
    },

    isTicketHandled() {
      this.ticketInviteMenu = false;
      this.ticketAssignMenu = false;
      if (this.$store.state.ticket.selected.handler) {
        return true;
      } else {
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
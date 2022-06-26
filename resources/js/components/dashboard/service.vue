<template>
  <v-container>
    <v-btn color="primary" @click="dialog = true" block> New </v-btn>
    <v-row justify="center" >
      <v-dialog v-model="dialog" persistent max-width="600px" >
        <v-card>
          <v-card-title>
            <span class="headline">Services</span>
          </v-card-title>
          <v-card-text>
            <v-container>
              <v-row>
                <v-col cols="12" sm="6">
                  <v-card class="mx-auto" max-width="300">
                    <v-img
                      :src='getImage("compcare.png")'
                      height="100px"></v-img>

                    <v-card-title> Computer Care </v-card-title>

                    <v-card-subtitle> Repairs and Cleaning </v-card-subtitle>

                    <v-card-actions>
                      <v-spacer></v-spacer>
                      <!-- Button comes here -->
                      <v-btn color=" primary" @click="dialogComputerCare = !dialogComputerCare">
                        Add
                      </v-btn>
                      <v-spacer></v-spacer>
                    </v-card-actions>
                  </v-card>
                </v-col>
                <v-dialog v-model="dialogComputerCare" max-width="600px" persistent
                  transition="dialog-bottom-transition">
                  <v-card tile>
                    <v-card-text>
                      <computer-care @cancelForm="dialogComputerCare = !dialogComputerCare" />
                    </v-card-text>
                  </v-card>
                </v-dialog>
                <!--  -->
                <v-col cols="12" sm="6">
                  <v-card class="mx-auto" max-width="300">
                    <v-img
                     :src='getImage("managed.png")'
                      height="100px"></v-img>

                    <v-card-title> Managed IT </v-card-title>

                    <v-card-subtitle>
                      Software and Technical Support
                    </v-card-subtitle>

                    <v-card-actions>
                      <v-spacer></v-spacer>
                      <v-btn color=" primary" @click="dialogManagedIt = !dialogManagedIt">
                        Add
                      </v-btn>

                      <v-spacer></v-spacer>
                    </v-card-actions>
                  </v-card>
                </v-col>
                <v-dialog v-model="dialogManagedIt" max-width="600px" persistent transition="dialog-bottom-transition">
                  <v-card tile>
                    <v-card-text>
                      <managed-it @cancelFormManagedIt="
                        dialogManagedIt = !dialogManagedIt
                      " />
                    </v-card-text>
                  </v-card>
                </v-dialog>

                <v-col cols="12" sm="6">
                  <v-card class="mx-auto" max-width="300">
                    <v-img   :src='getImage("consultancy.png")' height="100px"></v-img>

                    <v-card-title> IT Consultancy </v-card-title>

                    <v-card-subtitle>
                      Procurement, Project, Assessments
                    </v-card-subtitle>

                    <v-card-actions>
                      <v-spacer></v-spacer>
                      <v-btn disabled="true" color=" primary" @click="dialogConsultancy = !dialogConsultancy">
                        Add
                      </v-btn>

                      <v-spacer></v-spacer>
                    </v-card-actions>
                  </v-card>
                </v-col>
                <v-dialog v-model="dialogConsultancy" max-width="600px" persistent
                  transition="dialog-bottom-transition">
                  <v-card tile>
                    <v-card-text>
                      <consultancy @cancelFormConsultancy="
                        dialogConsultancy = !dialogConsultancy
                      " />
                    </v-card-text>
                  </v-card>
                </v-dialog>

                <v-col cols="12" sm="6">
                  <v-card class="mx-auto" max-width="300">
                    <v-img   :src='getImage("training.png")'
                      height="100px"></v-img>

                    <v-card-title> IT Training </v-card-title>

                    <v-card-subtitle>
                      Software Development, Literacy, Graphics
                    </v-card-subtitle>

                    <v-card-actions>
                      <v-spacer></v-spacer>
                      <v-btn color=" primary" @click="dialogTraining = !dialogTraining">
                        Add
                      </v-btn>

                      <v-spacer></v-spacer>
                    </v-card-actions>
                  </v-card>
                </v-col>
                <v-dialog v-model="dialogTraining" max-width="600px" persistent transition="dialog-bottom-transition">
                  <v-card tile>
                    <v-card-text>
                      <training @cancelFormTraining="dialogTraining = !dialogTraining" />
                    </v-card-text>
                  </v-card>
                </v-dialog>
              </v-row>
            </v-container>
          </v-card-text>
          <v-card-actions>
            <v-btn color="blue darken-1" text @click="createPurchase">
              Add Expense
            </v-btn>
            <v-btn color="blue darken-1" text @click="closeMainDialog">
              Cancel
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>

      <v-dialog v-model="purchaseDialog" v-if="purchaseDialog" persistent max-width="590">
        <v-form ref="purchaseRef" @submit.prevent="submit">
          <v-card>
            <v-card-title class="headline"> Adding Expense </v-card-title>
            <v-card-text>
              <v-row justify="center">
                <v-col cols="12" sm="4">
                  <v-text-field label="Item/Service" persistent-hint required :rules="formRules"
                    v-model="purchase.item_service"></v-text-field>
                </v-col>
                <v-col  cols="12" sm="4">
                  <v-select :items="[
                    'production',
                    'payroll',
                    'util:water',
                    'util:power',
                    'util:airtime',
                    'util:data',
                    'util:fuel',
                    'util:power',
                    'rentals',
                    'other',
                  ]" label="Category" :rules="formRules" v-model="purchase.category"></v-select>
                </v-col>
                <v-col cols="12" sm="4">
                  <v-text-field label="Approval by" persistent-hint required :rules="formRules"
                    v-model="purchase.approved_by"></v-text-field>
                </v-col>
                <v-col cols="12" sm="4">
                  <v-text-field label="Amount" persistent-hint required :rules="formRules" v-model="purchase.amount">
                  </v-text-field>
                </v-col>
                <v-col cols="12" sm="4">
                  <v-select :items="['CASH', 'CHEQUE', 'MOBILE']" label="Method" :rules="formRules"
                    v-model="purchase.payment_method"></v-select>
                </v-col>
                <v-col cols="12" sm="4">
                  <v-text-field label="Ref" hint="Trans ID" persistent-hint required :rules="formRules"
                    v-model="purchase.ref"></v-text-field>
                </v-col>
                <v-col cols="12" sm="12">
                  <v-file-input accept=".jpg, .jpeg, .png, .pdf" label="Receipt" v-model="purchase.receipt_attach">
                    <template v-slot:selection="{ text }">
                      <v-chip small label color="secondary">
                        {{ text }}
                      </v-chip>
                    </template>
                  </v-file-input>
                </v-col>

                <v-col cols="12" sm="12">
                  <v-textarea class="mx-5" filled auto-grow label="Description" v-model="purchase.description" rows="1"
                    row-height="10" shaped></v-textarea>
                </v-col>
              </v-row>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="green darken-1" text @click="cancelPurchase">
                Cancel
              </v-btn>
              <v-btn color="green darken-1" text @click="confirmPurchase" :loading="loadingPurchase"
                :disabled="loadingPurchase">
                Confirm
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-form>
      </v-dialog>
    </v-row>
  </v-container>
</template>

<script>
import ComputerCare from "../forms/computer-care.vue";
import Consultancy from "../forms/consultancy.vue";
import ManagedIt from "../forms/managed-it.vue";
import Training from "../forms/training.vue";

export default {
  data() {
    return {
      formRules: [(v) => !!v || "Required"],

      dialogComputerCare: false,
      dialogManagedIt: false,
      dialogConsultancy: false,
      dialogTraining: false,
      dialog: false,
      purchaseDialog: false,
      loadingPurchase: false,

      purchase: {
        item_service: "",
        amount: null,
        approved_by: "",
        requested_by: this.$store.state.user.name,
        ref: "",
        description: "",
        receipt_attach: null,
        payment_method: "",
        category: "",
      },
    };
  },

  components: {
    ComputerCare,
    ManagedIt,
    Consultancy,
    Training,
  },

  methods: {
    closeMainDialog() {
      this.getAllTickets();
      this.getmanagedItTickets();
      this.getItTrainingTickets();
      this.getComputerCareTickets();
      this.dialog = false;
    },

    openServiceDialog() {
      console.log("Open the drawer");
      this.dialog = true;
    },

    confirmPurchase() {

      this.loadingPurchase = true;
      let formData = new FormData();
      formData.append("item_service", this.purchase.item_service);
      formData.append("amount", this.purchase.amount);
      formData.append("approved_by", this.purchase.approved_by);
      formData.append("requested_by", this.$store.state.user.name);
      formData.append("ref", this.purchase.ref);
      formData.append("description", this.purchase.description);
      formData.append("receipt_attach", this.purchase.receipt_attach);
      formData.append("payment_method", this.purchase.payment_method);
      formData.append("category", this.purchase.category);

      if (this.$refs.purchaseRef.validate()) {


        axios
          .post("api/purchases/store", formData, {
            headers: {
              "Content-Type": "multipart/form-data",
            }
          })
          .then((response) => {
            if (response.status == 201) {
              console.log("Purchase Recorded");
              console.log(response.data);
              this.loadingPurchase = false;
              setTimeout(() => {
                this.purchaseDialog = false;
              }, 100);
            }
          })
          .catch((error) => {
            console.log(error.data);
          });
      }
    },

    cancelPurchase() {
      this.purchaseDialog = false;
      this.purchase.item_service = "";
      this.purchase.amount = null;
      this.purchase.approved_by = "";
      this.purchase.ref = "";
      this.purchase.description = "";
      this.purchase.receipt_attach = null;
      this.purchase.payment_method = "";
      this.purchase.category = "";
      this.loadingPurchase = false;
    },
    createPurchase() {
      this.dialog = false; //close the services window
      this.purchaseDialog = true;
    },
    getAllTickets() {
      axios
        .get("api/tickets")
        .then((response) => {
          // this.allTickets = response.data;
          this.$store.commit("loadAllTickets", response.data);
        })
        .catch((error) => {
          console.log(error);
        });
    },

    getmanagedItTickets() {
      axios
        .get("api/tickets/managed_it")
        .then((response) => {
          // this.managedItTickets = response.data;
          this.$store.commit("loadManagedItTickets", response.data);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getItTrainingTickets() {
      axios
        .get("api/tickets/it_training")
        .then((response) => {
          // this.itTrainingTickets = response.data;
          this.$store.commit("loadItTrainingTickets", response.data);
        })
        .catch((error) => {
          console.log(error);
        });
    },

    getComputerCareTickets() {
      axios
        .get("api/tickets/comp_care")
        .then((response) => {
          // this.computerCareTickets = response.data;
          this.$store.commit("loadComputerCareTickets", response.data);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getImage(name){
 return require(`./ui/${name}`);
}
  },
};
</script>

<style scoped>
.nav_column {
  margin-top: 5;
}

.bg{
    background:  url('https://computerclinicmw.com/wp-content/uploads/2022/06/service.jpg') no-repeat center center fixed !important;
  background-size: cover;
}
</style>
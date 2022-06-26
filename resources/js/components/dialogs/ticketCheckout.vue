<template>
    <v-container>
        <v-btn :disabled="
            $store.getters.ticketBal < 1 ? true : false
        " tile color="orange" @click="ticketCheckOutDialog = true">
            <!-- <v-icon left> mdi-check-outline </v-icon> -->
            Check
        </v-btn>
        <v-row justify="center">
            <!-- -CheckOut Dialog -->
            <v-dialog v-model="ticketCheckOutDialog" v-if="ticketCheckOutDialog" persistent max-width="590">
                <v-form ref="tickCheckOutRef" @submit.prevent="submit">
                    <v-card>
                        <v-card-title class="headline">
                            Checking out ticket
                            {{ $store.state.ticket.selected.id }}
                        </v-card-title>
                        <v-card-text>
                            <v-row justify="center">
                                <v-col cols="12" sm="12">
                                    <v-layout row justify-space-around class="mx-3 my-3">
                                    </v-layout>
                                </v-col>
                                <v-col cols="12" sm="4">
                                    <v-text-field label="Amount" hint="Total amount" persistent-hint required
                                        :rules="formRules" v-model="checkout.tick_amount"></v-text-field>
                                </v-col>
                                <v-col  cols="12" sm="4">
                                    <v-select :items="['CASH', 'CHEQUE', 'MOBILE']" label="Method" :rules="formRules"
                                        v-model="checkout.tick_payment_method"></v-select>
                                </v-col>
                                <v-col  cols="12" sm="4">
                                    <v-text-field label="Ref" hint="Trans ID" persistent-hint required
                                        :rules="formRules" v-model="checkout.tick_ref"></v-text-field>
                                </v-col>
                                <v-col sm="12" cols="12">
                                    <v-file-input accept=".jpg, .jpeg, .png, .pdf" label="Receipt"
                                        v-model="checkout.receipt_attach">
                                        <template v-slot:selection="{ text }">
                                            <v-chip small label color="orange">
                                                {{ text }}
                                            </v-chip>
                                        </template>
                                    </v-file-input>
                                </v-col>
                                <v-col sm="12" cols="12">
                                    <v-textarea class="mx-5" filled auto-grow label="Description"
                                        v-model="checkout.tick_description" rows="1" row-height="10" shaped>
                                    </v-textarea>
                                </v-col>
                            </v-row>
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="green darken-1" text @click="cancelCheckout">
                                Cancel
                            </v-btn>
                            <v-btn :loading="checkOutLoading" color="green darken-1" text @click="checkoutMethod">
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
export default {
    data() {
        return {
            ticketCheckOutDialog: false,
            checkOutLoading: false,
            checkout: {
                tick_amount: null,
                tick_ref: "",
                tick_description: "",
                tick_tick_id: "",
                tick_payment_method: "",
                receipt_attach: null,
            },
            formRules: [(v) => !!v || "This is required"],
        };
    },

    components: {},

    methods: {
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

        cancelCheckout() {
            this.ticketCheckOutDialog = false;
            this.checkout.tick_amount = null;
            this.checkout.tick_payment_method = "";
            this.checkout.tick_ref = "";
            this.checkout.receipt_attach = null;
            this.checkout.tick_description = "";
        },
        checkoutMethod() {


            //start loading button
            this.checkOutLoading = true;
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
                            // axios.get('api/ticket/' + this.$store.state.ticket.selected.id_no).then((response) => {

                            //     if (response.status == 200) {
                            //         //share updated information on the ticket.
                            //         this.$store.commit("selectTicket", response.data);

                            //     }
                            //     else {
                            //         console.log("Reselect ticket for changes to show");
                            //     }

                            // }).catch((err) => {
                            //     console.log(err);
                            // });

                            this.$store.commit("selectTicket", response.data);
                            this.getAllTickets();
                            this.getmanagedItTickets();
                            this.getItTrainingTickets();
                            this.getComputerCareTickets();
                            this.checkOutLoading = false;
                            this.cancelCheckout();
                            console.log("Succsefully made sale");

                            // try {
                            //     let ticketPayload = {
                            //         ticket_id: this.$store.state.ticket.selected.id,
                            //         amount_paid: this.checkout.tick_amount,
                            //     };
                            //     axios
                            //         .post("api/ticket/check/", {
                            //             ticketPayload: JSON.stringify(ticketPayload),
                            //         })
                            //         .then((response) => {
                            //             if (response.status == 200) {
                            //                 console.log("Succsefully made sale");
                            //                 console.log(response.data);
                            //                 this.$store.state.ticket.selected.status = "chckd";
                            //                 // this.getAllTickets();
                            //                 // this.getmanagedItTickets();
                            //                 // this.getItTrainingTickets();
                            //                 // this.getComputerCareTickets();
                            //                 this.checkOutLoading = false;
                            //                 this.cancelCheckout();
                            //             }
                            //         })
                            //         .catch((error) => {
                            //             console.log(error);
                            //         });
                            // } catch (error) {
                            //     console.log(error);
                            // }
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

    },
    created() {

    },
};
</script>

<style>
.nav_column {
    margin-top: 5;
}



/* .v-card {
  display: flex !important;
  flex-direction: column;
  
}

.v-dialog{
 overflow: hidden !important;
}
.v-card-text {
  flex-grow: 1;
  overflow: auto;
} */
</style>
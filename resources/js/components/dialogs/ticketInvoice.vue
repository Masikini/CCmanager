<template>
    <v-container>
        <v-btn :disabled="
            $store.getters.ticketBal > 0 ? false : true
        " color="primary" @click="generateInvoice" block> Invoice </v-btn>

    </v-container>
</template>

<script>
export default {
    data() {
        return {
        };
    },

    components: {},

    methods: {
        generateInvoice() {
            const invoicename =
                this.$store.state.ticket.selected.client_id.split(",")[0] +
                "Invoice.pdf";
            // });
            let arrOfObj = {
                serial_number: this.$store.state.ticket.selected.id_no,
                paid: this.$store.state.ticket.selected.paid,
                costs: this.$store.state.ticket.selected.costs_metadata,
                client: this.$store.state.ticket.selected.client_id,
            };
            axios
                .post(
                    "api/invoices/balance",
                    { invoiceData: JSON.stringify(arrOfObj) },
                    { responseType: "arraybuffer" }
                )
                .then(function (response) {
                    let blob = new Blob([response.data], { type: "application/pdf" });
                    let link = document.createElement("a");
                    link.href = window.URL.createObjectURL(blob);

                    link.download = invoicename;
                    link.click();

                    // console.log(response.data);
                });
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
</style>
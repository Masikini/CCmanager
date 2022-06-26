<template>
  <v-sheet>
    <v-tabs background-color="primary lighten-1" dark centered v-model="tab">
      <v-tab> SALES </v-tab>
      <v-tab v-if="$store.getters.loggedUserLevel"> EXPENSES</v-tab>
    </v-tabs>

    <v-tabs-items v-model="tab">
      <v-tab-item>
        <v-card>
          <v-card-title>
            <v-text-field v-model="allSearch" append-icon="mdi-magnify" label="Search" single-line hide-details>
            </v-text-field>
          </v-card-title>
          <v-data-table @click:row="handleClick" item-key="id" single-select :headers="allHeaders" :items="allSales"
            :search="allSearch"></v-data-table>
        </v-card>
      </v-tab-item>
      <v-tab-item v-if="$store.getters.loggedUserLevel">
        <v-data-table @click="selectExpense" item-key="id" single-select :headers="expensesHeaders" :items="allExpenses"
          :search="allSearch">

        </v-data-table>
      </v-tab-item>
    </v-tabs-items>
  </v-sheet>
</template>

<script>
export default {
  data() {
    return {
      allSales: [],
      allExpenses: [],
      tab: null,
      selectedItem: "",

      allSearch: "",

      allHeaders: [
        {
          text: "ID",
          align: "start",
          filterable: false,
          value: "id",
        },
        { text: "TICK ID", value: "tick_id" },
        { text: "AMOUNT", value: "amount" },
        { text: "PAYMENT", value: "payment_method" },
        { text: "REF", value: "ref" },
        { text: "DESCRIPTION", value: "description" },
      ],
      expensesHeaders: [
        {
          text: "ID",
          align: "start",
          filterable: false,
          value: "id",
        },
        { text: "REF", value: "ref" },
        { text: "ITEM/SERVICE", value: "item_service" },
        { text: "CATEGORY", value: "category" },
        { text: "AMOUNT", value: "amount" },
        { text: "DATE", value: "date" },
      ],
    };
  },
  methods: {
    handleClick(value, row) {
      row.select(true);
      this.selectedItem = value;
      this.$store.commit("selectSale", this.selectedItem);
      // console.log("Ref ticket", value.tick_id);

      //source out the ticket information so as to get the name of client
      // axios.get('api/ticket/' + value.tick_id).then((response) => {
      //   if (response.status == 200) {

      //     // console.log("Ref ticket", value.tick_id);
      //     this.$store.commit("selectRefClient", response.data);

      //   }
      //   else {
      //     console.log("Ref Client response not matching")
      //   }
      // }).catch((err) => {
      //   console.log(err);
      // })



      // this.desserts.indexOf(item)
      // console.log(this.$store.state.ticket.selected)
    },

    selectExpense(value, row) {
      row.select(true);
      this.$store.commit("selectPurchase", value);



    },

    getAllSales() {
      axios
        .get("api/sales")
        .then((response) => {
          this.allSales = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },

    getAllExpenses() {
      axios
        .get("api/purchases/")
        .then((response) => {
          this.allExpenses = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  
  },
  created() {
    this.getAllSales();
    this.getAllExpenses();
  },
 
};
</script>

<style scoped>
tr.v-data-table__selected {
  background: #7d92f5 !important;
}
</style>
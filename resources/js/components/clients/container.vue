<template>
  <v-sheet>
    <v-tabs background-color="primary lighten-1" dark centered v-model="tab">
      <v-tab> All </v-tab>
      <v-tab> SUBSCRIBERS</v-tab>
    </v-tabs>

    <v-tabs-items v-model="tab">
      <v-tab-item>
        <v-card>
          <v-card-title>
            <v-text-field
              v-model="allSearch"
              append-icon="mdi-magnify"
              label="Search"
              single-line
              hide-details
            
            ></v-text-field>
          </v-card-title>
          <v-data-table
            @click:row="handleClick"
            item-key="id"
            single-select
            :headers="allHeaders"
            :items="allClients"
            :search="allSearch"
            hide-default-footer
          ></v-data-table>
        </v-card>
      </v-tab-item>
      <!-- <v-tab-item>
        <v-card>
          <v-card-title>
            <v-text-field
              v-model="managedItSearch"
              append-icon="mdi-magnify"
              label="Search"
              single-line
              hide-details
            ></v-text-field>
          </v-card-title>
          <v-data-table
            @click:row="handleClick"
            item-key="id"
            single-select
            :headers="allHeaders"
            :items="managedItTickets"
            :search="managedItSearch"
            hide-default-footer
          ></v-data-table>
        </v-card>
      </v-tab-item> -->
    </v-tabs-items>
  </v-sheet>
</template>

<script>
export default {
  data() {
    return {
      allClients: [],
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
        { text: "NAME", value: "name" },
        { text: "PHONE", value: "phone" },
        { text: "EMAIL", value: "email" },
        { text: "RESIDENCE", value: "residence" },
      ],
    };
  },
  methods: {
    handleClick(value, row) {
     
      row.select(true);
      this.selectedItem = value;

      // axios
      //   .get("api/procedure/" + value.id)

      //   .then((response) => {
      //     if (response.status == 200) {
      //       console.log(response.data);
      //       this.ticketProcedures = response.data;
      //       this.$store.commit(
      //         "selectedTicketProcedures",
      //         this.ticketProcedures
      //       );
      //     } else {
      //       console.log("unable to get procedure!");
      //     }
      //   })
      //   .catch((error) => {
      //     console.log(error.response.data);
      //   });

      this.$store.commit("selectClient", this.selectedItem);

      // this.desserts.indexOf(item)
      // console.log(this.$store.state.ticket.selected)
    },

    getAllClients() {
      axios
        .get("api/clients")
        .then((response) => {
          this.allClients = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },

  },
  created() {
    this.getAllClients();
   
  },
};
</script>

<style scoped>
tr.v-data-table__selected {
  background: #7d92f5 !important;
}
</style>
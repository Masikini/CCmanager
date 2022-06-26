<template>
  <v-sheet >
   
    <v-tabs background-color="primary lighten-1" dark centered v-model="tab">
      <v-tab> All </v-tab>
      <v-tab> Managed IT </v-tab>
      <v-tab> Computer Care </v-tab>
      <v-tab> IT Training </v-tab>
    </v-tabs>

    <v-tabs-items v-model="tab">
      <v-tab-item>
        <v-card>
          <v-card-title>
            <v-text-field v-model="allSearch" append-icon="mdi-magnify" label="Search" single-line hide-details>
            </v-text-field>
          </v-card-title>
          <v-data-table @click:row="handleClick" item-key="id" single-select :headers="allHeaders" :items="$store.state.refData.allTickets"
            :search="allSearch" loading-text="Just a moment please...">
            <template v-slot:[`item.status`]="{ item }">
              <!-- <v-icon medium v-if="item.status == 'open'? true: false" color="red">mdi-minus-circle </v-icon>
              <v-icon medium v-if="item.status == 'close'? true: false" color="orange">mdi-close-circle </v-icon>
              <v-icon medium v-if="item.status == 'checked'? true: false" color="success">mdi-check-circle </v-icon> -->

              <v-chip :color="getColor(item.status)" dark>
                {{ item.status }}
              </v-chip>
            </template>
          </v-data-table>
        </v-card>
      </v-tab-item>
      <v-tab-item>
        <v-card>
          <v-card-title>
            <v-text-field v-model="managedItSearch" append-icon="mdi-magnify" label="Search" single-line hide-details>
            </v-text-field>
          </v-card-title>
          <v-data-table @click:row="handleClick" item-key="id" single-select :headers="allHeaders"
            :items="$store.state.refData.managedItTickets" :search="managedItSearch" hide-default-footer></v-data-table>
        </v-card>
      </v-tab-item>
      <v-tab-item>
        <v-card>
          <v-card-title>
            <v-text-field v-model="computerCareSearch" append-icon="mdi-magnify" label="Search" single-line
              hide-details></v-text-field>
          </v-card-title>
          <v-data-table @click:row="handleClick" item-key="id" single-select :headers="compCareHeader"
            :items="$store.state.refData.computerCareTickets" :search="computerCareSearch" hide-default-footer>
          </v-data-table>
        </v-card>
      </v-tab-item>
      <v-tab-item>
        <v-card>
          <v-card-title>
            <v-text-field v-model="itTrainingSearch" append-icon="mdi-magnify" label="Search" single-line hide-details>
            </v-text-field>
          </v-card-title>
          <v-data-table @click:row="handleClick" item-key="id" single-select :headers="itTrainingHeader"
            :items="$store.state.refData.itTrainingTickets" :search="itTrainingSearch" hide-default-footer>
          </v-data-table>
        </v-card>
      </v-tab-item>
    </v-tabs-items>
  </v-sheet>
</template>

<script>
export default {
  data() {
    return {
      allTickets: [],
      managedItTickets: [],
      itTrainingTickets: [],
      computerCareTickets: [],
      tab: null,
      selectedItem: "",
      ticketProcedures: null,
      allSearch: "",
      managedItSearch: "",
      itTrainingSearch: "",
      computerCareSearch: "",

      allHeaders: [
        {
          text: "ID",
          align: "start",
          filterable: false,
          value: "id_no",
        },
        { text: "SERVICE", value: "service" },
        { text: "CLIENT", value: "client_id" },
        { text: "ISSUER", value: "issuer" },
        { text: "STATUS", value: "status" },
      ],
      compCareHeader: [
        {
          text: "ID",
          align: "start",
          filterable: false,
          value: "id_no",
        },
        { text: "SERVICE", value: "list" },
        { text: "CLIENT", value: "client_id" },
        { text: "ISSUER", value: "issuer" },
        { text: "STATUS", value: "status" },
      ],
      itTrainingHeader: [
        {
          text: "ID",
          align: "start",
          filterable: false,
          value: "id_no",
        },
        { text: "COURSE ID", value: "course" },
        { text: "JOINED", value: "start" },
        { text: "STATUS", value: "status" },
      ],
    };
  },
  methods: {
    getColor(status) {
      if (status == "open") return "red";
      else if (status == "closed") return "green";
      else return "orange";
    },
    handleClick(value, row) {
      // this.$store.commit("clearProcedures");
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

      this.$store.commit("selectTicket", this.selectedItem);

      // this.desserts.indexOf(item)
      // console.log(this.$store.state.ticket.selected)
    },

    getAllTickets() {
      axios
        .get("api/tickets")
        .then((response) => {
          // this.allTickets = response.data;
          this.$store.commit("loadAllTickets", response.data);
          // this.allTickets = this.$store.state.refData.allTickets
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
  },
  created() {
    this.getAllTickets();
    this.getmanagedItTickets();
    this.getItTrainingTickets();
    this.getComputerCareTickets();
  },
};
</script>

<style scoped>
tr.v-data-table__selected {
  background: #7d92f5 !important;
}
</style>
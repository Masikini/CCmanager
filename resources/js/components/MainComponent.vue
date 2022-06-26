<template>

  <v-app>
  
    <v-navigation-drawer temporary v-model="drawer" fixed left>
      <v-container  height="128" width="100%">
        <v-layout column align-center>
          <v-img height="124" width="124"
            src="https://computerclinicmw.com/wp-content/uploads/2022/05/CC-logo-color-.png"></v-img>
        </v-layout>
      </v-container>
      <div class="nav_column">
        <service />
      </div>

      <v-list nav dense>
        <v-list-item-group v-model="selectedItem" color="primary">
          <v-list-item to="/dashboard" style="text-decoration: none">
            <v-list-item-icon>
              <v-icon large>mdi-view-dashboard</v-icon>
            </v-list-item-icon>

            <v-list-item-content>
              <v-list-item-title>Dashboard</v-list-item-title>
            </v-list-item-content>
          </v-list-item>

          <v-list-item to="/tickets" style="text-decoration: none" class="mt-5">
            <v-list-item-icon>
              <v-icon large>mdi-ticket-account</v-icon>
            </v-list-item-icon>

            <v-list-item-content>
              <v-list-item-title>Tickets</v-list-item-title>
            </v-list-item-content>
          </v-list-item>

          <v-list-item class="mt-5" to="/sales" style="text-decoration: none">
            <v-list-item-icon>
              <v-icon large>mdi-currency-usd</v-icon>
            </v-list-item-icon>

            <v-list-item-content>
              <v-list-item-title>Transactions</v-list-item-title>
            </v-list-item-content>
          </v-list-item>

          <v-list-item class="mt-5" to="/clients" style="text-decoration: none">
            <v-list-item-icon>
              <v-icon large>mdi-clipboard-account</v-icon>
            </v-list-item-icon>

            <v-list-item-content>
              <v-list-item-title>Clients</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item class="mt-5" to="/reports" style="text-decoration: none" v-if="$store.getters.loggedUserLevel">
            <v-list-item-icon>
              <v-icon large>mdi-chart-areaspline</v-icon>
            </v-list-item-icon>

            <v-list-item-content>
              <v-list-item-title>Reports</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item class="mt-5" to="/admin" style="text-decoration: none" v-if="$store.getters.loggedUserLevel">
            <v-list-item-icon>
              <v-icon large>mdi-account-tie</v-icon>
            </v-list-item-icon>

            <v-list-item-content>
              <v-list-item-title>Admin</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list-item-group>
        
      </v-list>
    </v-navigation-drawer>

    <v-navigation-drawer  v-model="infoDrawer" temporary app right width="300" class="hidden-md-and-up">
      <component :is="sidePanel" />
    </v-navigation-drawer>
    <v-navigation-drawer  permanent  right width="400"  app class="hidden-xs-only">
      <component :is="sidePanel" />
    </v-navigation-drawer>

    <v-main>
      <!--  -->
      <v-app-bar clipped-right flat height="72" elevate-on-scroll fixed>
          <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
 
        <v-layout row justify-center align-center>
          <span class="justify-center headline"> {{ current_tab }} </span>
        </v-layout>
          <!-- <v-app-bar-nav-icon @click.stop="infoDrawer = !infoDrawer" class="hidden-md-and-up"></v-app-bar-nav-icon> -->
         <v-btn icon @click.stop="infoDrawer = !infoDrawer" class="hidden-md-and-up">
        <v-icon>mdi-page-layout-sidebar-right</v-icon>
      </v-btn>
      </v-app-bar>
       <div style="height:72px;"></div>
      <router-view></router-view>
    </v-main>
  </v-app>
</template>

<script>
import Service from "./dashboard/service.vue";
import ticketsPanelVue from "./panel/ticketsPanel.vue";
import clientsPanelVue from "./panel/clientsPanel.vue";
import User from "./panel/user.vue";
import transactionPanelVue from "./panel/transactionPanel.vue";
import adminPanelVue from "./panel/adminPanel.vue";
import reportsPanelVue from "./panel/reportsPanel.vue";
import adminVue from "./admin.vue";
export default {
  data: () => ({
    user: null,
    drawer: null,
    infoDrawer:null,
    selectedItem: 0,
    current_tab: "",
  }),
  components: {
    Service,
    User,
    ticketsPanelVue,
    clientsPanelVue,
    adminVue,
    adminPanelVue,
    reportsPanelVue,
  },

  methods: {
    updateDialog() {
      console.log("Clicked");
    },
  },
  computed: {
    sidePanel() {
      switch (this.selectedItem) {
        case 0:
          this.current_tab = "Dashboard";
          return User;
          break;
        case 1:
          this.current_tab = "Tickets";
          this.$store.commit("clearSelectedTicket");
          return ticketsPanelVue;
          console.log("tiket panel");
          break;
        case 2:
          // this.$store.commit("clearSelected");
          // return ticketsPanelVue;
          this.current_tab = "Transactions";
          return transactionPanelVue;
          break;
        case 3:
          this.current_tab = "Clients";
          this.$store.commit("clearSelectedClient");
          return clientsPanelVue;
          break;

        case 4:
          this.current_tab = "Reports";
          // this.$store.commit("clearSelectedAdminUser");
          return reportsPanelVue;
          break;

        case 5:
          this.current_tab = "Admin";
          // this.$store.commit("clearSelectedAdminUser");
          return adminPanelVue;
          break;

        default:
          this.current_tab = "Dashboard";
          return User;
      }
    },
  },
  created() {

  },
  mounted() {
    // this.$router.push({ name: "dashboard" });
    // this.selectedItem = 0;
    this.$router.replace({ name: "dashboard" });

  },
};
</script>
<style scoped>
.nav_column {
  margin: 30px;
}

#no_bg::before {
  background-color: transparent !important;
}
</style>
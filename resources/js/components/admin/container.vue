<template>
  <v-sheet>
    <v-tabs background-color="primary lighten-1" dark centered v-model="tab">
      <v-tab @click="activatePanel(0)"> Users</v-tab>
      <v-tab @click="activatePanel(1)"> Costs </v-tab>
      <v-tab @click="activatePanel(2)"> Courses</v-tab>
      <v-tab @click="activatePanel(3)"> Notices</v-tab>
      <v-tab @click="activatePanel(4)"> Campaigns</v-tab>
    </v-tabs>

    <v-tabs-items v-model="tab">
      <v-tab-item>
        <v-card>
          <v-card-title>
            <v-row align-content="center">
              <v-col cols="9">
                <v-text-field v-model="usersSearch" append-icon="mdi-magnify" label="Search" single-line hide-details>
                </v-text-field>
              </v-col>
              <v-col cols="3">
                <v-btn depressed small color="primary" @click="dialogRegisterUser = true">
                  New User
                </v-btn>
              </v-col>
            </v-row>
          </v-card-title>
          <v-data-table @click:row="selectUser" item-key="id" single-select :headers="allHeaders"
            :items="$store.state.admin.users" :search="usersSearch" hide-default-footer>
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
            <v-row align-content="center">
              <v-col cols="9">
                <v-text-field v-model="costsSearch" append-icon="mdi-magnify" label="Search" single-line hide-details>
                </v-text-field>
              </v-col>
              <v-col cols="3">
                <v-btn depressed small color="primary" @click="dialogAddCost = true">
                  New Cost
                </v-btn>
              </v-col>
            </v-row>
          </v-card-title>
          <v-data-table @click:row="selectCost" item-key="id" single-select :headers="costsHeaders"
            :items="$store.state.admin.costs" :search="costsSearch" hide-default-footer></v-data-table>
        </v-card>
      </v-tab-item>
      <v-tab-item>
        <v-card>
          <v-card-title>
            <v-row align-content="center">
              <v-col cols="9">
                <v-text-field v-model="coursesSearch" append-icon="mdi-magnify" label="Search" single-line hide-details>
                </v-text-field>
              </v-col>
              <v-col cols="3">
                <v-btn depressed small color="primary" @click="dialogAddCourse = true">
                  New Course
                </v-btn>
              </v-col>
            </v-row>
          </v-card-title>
          <v-data-table @click:row="selectCourse" item-key="id" single-select :headers="coursesHeaders"
            :items="$store.state.admin.courses" :search="coursesSearch" hide-default-footer></v-data-table>
        </v-card>
      </v-tab-item>
      <v-tab-item>
        <v-card>
          <v-card-title>
            <v-row align-content="center">
              <v-col cols="9">
                <v-text-field v-model="noticesSearch" append-icon="mdi-magnify" label="Search" single-line hide-details>
                </v-text-field>
              </v-col>
              <v-col cols="3">
                <v-btn depressed small color="primary" @click="dialogAddNotice = true">
                  New Notice
                </v-btn>
              </v-col>
            </v-row>
          </v-card-title>
          <v-data-table @click:row="selectNotice" item-key="id" single-select :headers="noticesHeaders"
            :items="$store.state.admin.notices" :search="noticesSearch" hide-default-footer></v-data-table>
        </v-card>
      </v-tab-item>
      <!-- <v-tab-item>
        <v-card>
          <v-card-title>
            <v-text-field
              v-model="campaignSearch"
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
            :headers="campaignHeaders"
            :items="allCampaigns"
            :search="campaignSearch"
            hide-default-footer
          ></v-data-table>
        </v-card>
      </v-tab-item> -->
      <v-tab-item>
        <v-card>
          <v-card-title>
            <v-row align-content="center">
              <v-col cols="9">
                <v-text-field v-model="campaignSearch" append-icon="mdi-magnify" label="Search" single-line
                  hide-details></v-text-field>
              </v-col>
              <v-col cols="3">
                <v-btn depressed small color="primary" @click="dialogAddCampaign = true">
                  New Campaign
                </v-btn>
              </v-col>
            </v-row>
          </v-card-title>
          <v-data-table @click:row="handleClick" item-key="id" single-select :headers="campaignHeaders"
            :items="allCampaigns" :search="campaignSearch" hide-default-footer></v-data-table>
        </v-card>
      </v-tab-item>
    </v-tabs-items>

    <v-dialog v-model="dialogRegisterUser" max-width="600px" max-height="500px" persistent
      transition="dialog-bottom-transition">
      <v-card tile>
        <v-card-text>
          <!-- <managed-it @cancelFormCampaign="dialogCampaigns = !dialogCampaigns" /> -->

          <RegisterUser @cancelFormRegisterUser="dialogRegisterUser = !dialogRegisterUser" @addUser="getallUsers" />
        </v-card-text>
      </v-card>
    </v-dialog>

    <v-dialog v-model="dialogAddCost" max-width="600px" max-height="500px" persistent
      transition="dialog-bottom-transition">
      <v-card tile>
        <v-card-text>
          <!-- <managed-it @cancelFormCampaign="dialogCampaigns = !dialogCampaigns" /> -->

          <AdminCost @cancelFormCost="dialogAddCost = !dialogAddCost" @addCost="getallCosts" />
        </v-card-text>
      </v-card>
    </v-dialog>
    <v-dialog v-model="dialogAddCourse" max-width="600px" max-height="500px" persistent
      transition="dialog-bottom-transition">
      <v-card tile>
        <v-card-text>
          <!-- <managed-it @cancelFormCampaign="dialogCampaigns = !dialogCampaigns" /> -->

          <AdminCourse @cancelFormCourse="dialogAddCourse = !dialogAddCourse" @addCourse="getallCourses" />
        </v-card-text>
      </v-card>
    </v-dialog>
    <v-dialog v-model="dialogAddNotice" max-width="600px" max-height="500px" persistent
      transition="dialog-bottom-transition">
      <v-card tile>
        <v-card-text>
          <!-- <managed-it @cancelFormCampaign="dialogCampaigns = !dialogCampaigns" /> -->

          <AdminNotice @cancelFormNotice="dialogAddNotice = !dialogAddNotice" @addNotice="getallNotices" />
        </v-card-text>
      </v-card>
    </v-dialog>
    <v-dialog v-model="dialogAddCampaign" max-width="600px" max-height="500px" persistent
      transition="dialog-bottom-transition">
      <v-card tile>
        <v-card-text>
          <!-- <managed-it @cancelFormCampaign="dialogCampaigns = !dialogCampaigns" /> -->

          <AdminCampaign @cancelFormCampaign="dialogAddCampaign = !dialogAddCampaign" @addCampaign="getallCampaigns" />
        </v-card-text>
      </v-card>
    </v-dialog>
  </v-sheet>
</template>

<script>
import AdminCampaign from "../forms/adminCampaign.vue";
import AdminCost from "../forms/adminCosts.vue";
import AdminCourse from "../forms/adminCourse.vue";
import AdminNotice from "../forms/adminNotice.vue";
import RegisterUser from "../Register.vue";
import moment from "moment";

export default {
  components: {
    AdminCampaign,
    AdminCost,
    RegisterUser,
    AdminCourse,
    AdminNotice,
  },
  data() {
    return {
      allUsers: [],
      allCosts: [],
      allCampaigns: [],
      allCourses: [],
      allNotices: [],
      tab: null,
      selectedItem: "",
      ticketProcedures: null,
      usersSearch: "",
      costsSearch: "",
      noticesSearch: "",
      campaignSearch: "",
      coursesSearch: "",
      dialogRegisterUser: false,
      dialogAddCost: false,
      dialogAddCourse: false,
      dialogAddNotice: false,
      dialogAddCampaign: false,


      allHeaders: [
        {
          text: "ID",
          align: "start",
          filterable: false,
          value: "id",
        },
        { text: "Name", value: "name" },
        { text: "Email", value: "email" },
        { text: "Level", value: "level" },
      ],

      noticesHeaders: [
        {
          text: "ID",
          align: "start",
          filterable: false,
          value: "id",
        },
        { text: "Description", value: "description" },
        { text: "End", value: "end" },
      ],

      costsHeaders: [
        {
          text: "ID",
          align: "start",
          filterable: false,
          value: "id",
        },
        { text: "Cost Id", value: "id_no" },
        { text: "Name", value: "name" },
        { text: "Fee", value: "fee" },
        { text: "Desc", value: "description" },
      ],

      coursesHeaders: [
        {
          text: "ID",
          align: "start",
          filterable: false,
          value: "id",
        },
        { text: "Course Code", value: "id_no" },
        { text: "Course Name", value: "name" },
        { text: "Fee ", value: "fee" },
      ],
      campaignHeaders: [
        {
          text: "ID",
          align: "start",
          filterable: false,
          value: "id",
        },
        { text: "Title", value: "title" },

        { text: "Target", value: "target" },
        { text: "Engaged", value: "engaged" },
        { text: "Acquired", value: "acquired" },
        { text: "Facilitator", value: "facilitator" },
      ],
    };
  },

  methods: {
    getColor(status) {
      if (status == "open") return "red";
      else if (status == "close") return "orange";
      else return "green";
    },
    activatePanel(tabBar) {
      console.log("Active tab is", tabBar);
      this.$store.commit("selectAdminPanel", tabBar); //send the tab index to switch the sidepanel options corresponding to the selected tab.
    },
    getallUsers() {
      axios
        .get("api/users/")
        .then((response) => {
          // this.allUsers = response.data;
          this.$store.commit("adminusers", response.data);

          // console.log(this.allUsers);
        })
        .catch((error) => {
          console.log(error);
        });
    },

    getallCosts() {
      axios
        .get("api/costs/")
        .then((response) => {
          // this.allCosts = response.data;
          this.$store.commit("admincosts", response.data);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getallNotices() {
      axios
        .get("api/notices/")
        .then((response) => {
          // this.allNotices = response.data;
          this.$store.commit("adminnotices", response.data);
        })
        .catch((error) => {
          console.log(error);
        });
    },

    getallCourses() {
      axios
        .get("api/courses/")
        .then((response) => {
          // this.allCourses = response.data;
          this.$store.commit("admincourses", response.data);
        })
        .catch((error) => {
          console.log(error);
        });
    },

    getallCampaigns() {
      axios
        .get("api/campaigns/")
        .then((response) => {
          this.allCampaigns = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },

    handleClick(value, row) {
      console.log("Heylo");
    },

    selectUser(value, row) {
      // row.select(true);
      this.$store.commit("adminSelectUser", value);
      // console.log(value);
    },
    selectCost(value, row) {
      // row.select(true);
      this.$store.commit("adminSelectCost", value);
      // console.log(value);
    },
    selectCourse(value, row) {
      // row.select(true);
      this.$store.commit("adminSelectCourse", value);

    },
    selectNotice(value, row) {
      // row.select(true);
      this.$store.commit("adminSelectNotice", value);

    },
  },
  computed: {},
  created() {
    this.getallUsers();
    this.getallCosts();
    this.getallNotices();
    this.getallCourses();
    this.getallCampaigns();
  },
};
</script>

<style scoped>
tr.v-data-table__selected {
  background: #7d92f5 !important;
}
</style>
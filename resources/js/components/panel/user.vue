<template>
  <v-container class="d-flex justify-center mt-15">
    <v-layout column>
      <v-row>
        <v-col cols="12" sm="12" class="justify-center my-2">
          <v-row justify="center">
            <v-menu bottom min-width="200px" rounded offset-y :close-on-content-click="false">
              <template v-slot:activator="{ on }">
                <v-btn icon x-large v-on="on">
                  <v-avatar color="brown" size="125" class="hidden-xs-only">
                    <span style="font-size: 50px; color: white">{{
                        $store.getters.userInitials
                    }}</span>
                  </v-avatar>
                  
                  <v-avatar color="brown" size="85" class="hidden-sm-and-up">
                    <span style="font-size: 20px; color: white">{{
                        $store.getters.userInitials
                    }}</span>
                  </v-avatar>
                </v-btn>
              </template>
              <v-card>
                <v-list-item-content class="justify-center">
                  <div class="mx-auto text-center">
                    <v-avatar color="brown">
                      <span class="white--text headline">{{
                          $store.getters.userInitials
                      }}</span>
                    </v-avatar>
                    <h3>{{ $store.state.user.name }}</h3>
                    <p class="caption mt-1">
                      {{ $store.state.user.email }}
                    </p>
                    <v-divider class="my-3"></v-divider>
                    <ChangePassword />
                    <v-divider class="my-3"></v-divider>
                    <v-btn depressed rounded text @click="logout">
                      Logout
                    </v-btn>
                  </div>
                </v-list-item-content>
              </v-card>
            </v-menu>
          </v-row>
        </v-col>
        <v-col cols="12" sm="12">

        </v-col>
        <v-col cols="12" sm="12" class="justify-center my-2">
          <v-divider></v-divider>
          <v-col cols="12" sm="12">
            <v-layout row>
              <v-icon style="font-size: 25pt">mdi-calendar</v-icon>
              <span class="justify-left headline ml-2"> Planner </span>
            </v-layout>
            <v-layout class="justify-center mt-6 px-2">
              <vc-calendar :attributes="attributes">
                <!-- <template #day-popover>
                <div></div>
              </template> -->
              </vc-calendar>
            </v-layout>
          </v-col>
        </v-col>

        <v-col cols="12" sm="12" class="justify-center my-2 ml-4">
          <v-layout row>
            <v-icon style="font-size: 25pt">mdi-bullhorn</v-icon>
            <span class="justify-left headline ml-2"> Announcements </span>
          </v-layout>
        </v-col>
      </v-row>
      <v-row justify="center">
        <v-col cols="12" sm="12" class="justify-center">
          <v-sheet class="mt-2" width="400px">
            <v-slide-group class="pa-4" show-arrows>
              <v-slide-item v-for="(item, index) in $store.state.adminPanel.Notices" :key="item.id">
                <v-card :color="active ? 'primary' : 'grey lighten-1'" class="ma-4" height="120" width="120"
                  v-if="duration(item.end) < 0">
                  <v-card-title>
                    <span style="font-size: 12px; font-weight: bold">{{
                        noticeDuration(item.created_at)
                    }}</span>
                  </v-card-title>
                  <v-card-text>
                    <span>{{ descTrim(item.description) }}</span>

                    <!-- <span class="mt-2"
                        >{{ duration(item.end) * -1 }} Days togo!</span
                      > -->
                  </v-card-text>
                </v-card>
              </v-slide-item>
            </v-slide-group>
          </v-sheet>
        </v-col>
      </v-row>
    </v-layout>
  </v-container>
</template>

<script>
import moment from "moment";
import ChangePassword from "../dialogs/changePassword.vue";
export default {
  components: {
    ChangePassword,
  },
  data() {
    // const todos = [
    //   {
    //     description: "Take Noah to basketball practice.",
    //     isComplete: false,
    //     dates: { weekdays: 6 }, // Every Friday
    //     //  dates: new Date(2022,3,13),
    //     color: "red",
    //   },
    // ];
    return {
      changePasswordDialog: false,
      todos: [],
      // attributes: [
      //   {
      //     key: "today",
      //     highlight: {
      //       color: "purple",
      //       fillMode: "solid",
      //     },
      //     dates: new Date(),
      //     popover: true,
      //   },
      // ],
      // incId: todos.length,
      // todos,
      user: {
        initials: "",
        fullName: "",
        email: "",
      },
    };
  },
  methods: {
    getNotices() {
      axios
        .get("api/notices/thismonth")
        .then((response) => {

          this.todos = response.data;

        })
        .catch((error) => {
          console.log(error);
        });
    },

    duration(end) {
      console.log(end);
      var enddate = moment(end, "YYYY-MM-DD");

      var today = moment();
      return today.diff(enddate, "days");
      // var enddate= moment(end);
      // return moment.duration(today.diff(end)).asDays();

      // return moment().endOf('day').fromNow(dateoftoday);
    },

    noticeDuration(end) {
      console.log(end);
      var enddate = moment(end, "YYYY-MM-DD");

      var today = moment();
      var date_to_display = enddate.diff(today, "days");
      if (date_to_display < -1) {
        date_to_display = date_to_display * -1 + " Days ago";
        return date_to_display;
      } else if (date_to_display == -1) {
        return "Yesterday";
      } else if (date_to_display == 0) {
        return "Today";
      } else {
        return "Expired!";
      }

      // var enddate= moment(end);
      // return moment.duration(today.diff(end)).asDays();

      // return moment().endOf('day').fromNow(dateoftoday);
    },
    descTrim(desc) {
      var newdesc = "";

      if (desc.length > 12) {
        return desc.split("").slice(0, 70).join("") + "...";
      } else {
        for (let i = desc.length; i < 29; i++) {
          newdesc += " ";
        }

        // desc = desc + newdesc;
        // desc = desc.replace("xx", " ");
        return desc + newdesc;
      }
    },
    logout() {
      axios
        .post("/api/logout/")
        .then((response) => {
          this.$router.replace({ name: "login" });
        })
        .catch((error) => {
          console.log(error.response.data.errors);
        });
    },

    changePassword() {
      this.changePasswordDialog = true;
    }
  },

  created() {
    // this.getNotices();
    this.getNotices();
  },
  mounted() {
    // this.user.initials = this.$store.getters.userInitials;
    // this.user.fullName = this.$store.state.user.name;
    // this.user.email = this.$store.state.user.email;
  },
  computed: {
    attributes() {

      return [
        {
          key: "today",
          highlight: {
            color: "purple",
            fillMode: "solid",
          },
          dates: new Date(),
        },
        // Attributes for todos
        ...this.todos.map((todo) => ({
          dates: todo.dates,
          dot: {
            color: todo.color,
            // class: todo.isComplete ? "opacity-75" : "",
          },
          popover: {
            label: todo.description,
            visibility: 'focus',
            placement: 'auto',
          },
          customData: todo,
        })),
      ];
    },
  },
};
</script>

<style>
</style>
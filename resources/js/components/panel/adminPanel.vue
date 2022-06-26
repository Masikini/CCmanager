<template>
  <v-container class="d-flex justify-center mt-15">
    <v-row>
      <v-col sm="12" class="justify-center my-2">
        <v-scroll-y-transition mode="out-in">
          <!-- <span v-if="!isUserSelected"> Select a user</span>
          <span v-if="!isCostSelected"> Select a cost </span> -->

          <div v-if="isUserSelected" class="mx-5">
            <v-row>
              <v-col  cols="12" sm="12">
                <v-text-field :disabled="userEditable" label="Name" outlined dense v-model="selectedUser.name">
                </v-text-field>
              </v-col>
              <v-col  cols="12" sm="12">
                <v-text-field :disabled="userEditable" label="Email" outlined type="Email" dense
                  v-model="selectedUser.email"></v-text-field>
              </v-col>
              <v-col  cols="12" sm="12">
                <v-select :disabled="userEditable" :items="userLevels" label="Level" outlined dense
                  v-model="selectedUser.level"></v-select>
              </v-col>
              <v-col  cols="12" sm="12">
                <v-text-field :disabled="userEditable" label="New Password" outlined required type="Password" dense
                  v-model="userPassword"></v-text-field>
              </v-col>
              <v-col  cols="12" sm="12">
                <v-layout row justify-space-around>
                  <v-btn depressed color="primary" @click="editUser">
                    {{ editUpdateBtn }}
                  </v-btn>

                  <v-dialog v-model="userDeleteDialog" persistent max-width="290">
                    <template v-slot:activator="{ on, attrs }">
                      <v-btn color="error" depressed v-bind="attrs" v-on="on">
                        DELETE
                      </v-btn>
                    </template>
                    <v-card>
                      <v-card-title class="text-h5">
                        Are you sure?
                      </v-card-title>
                      <v-card-text>
                        Deleting user
                        {{ selectedUser.name }}
                      </v-card-text>
                      <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="green darken-1" text @click="userDeleteDialog = false">
                          Cancel
                        </v-btn>
                        <v-btn color="green darken-1" text @click="deleteUser">
                          Delete
                        </v-btn>
                      </v-card-actions>
                    </v-card>
                  </v-dialog>
                </v-layout>
              </v-col>
            </v-row>
          </div>

          <div v-if="isCostSelected" class="mx-5">
            <v-row>
              <v-col  cols="12" sm="6">
                <v-text-field :disabled="costEditable" label="Cost code" outlined dense v-model="selectedCost.id_no">
                </v-text-field>
              </v-col>
              <v-col  cols="12" sm="6">
                <v-text-field :disabled="costEditable" label="Cost fee" outlined dense v-model="selectedCost.fee">
                </v-text-field>
              </v-col>
              <v-col  cols="12" sm="12">
                <v-text-field :disabled="costEditable" label="Title" outlined dense v-model="selectedCost.name">
                </v-text-field>
              </v-col>
              <v-col  cols="12" sm="12">
                <v-text-field :disabled="costEditable" label="Description" outlined dense
                  v-model="selectedCost.description"></v-text-field>
              </v-col>

              <v-col  cols="12" sm="12">
                <v-layout row justify-space-around>
                  <v-btn depressed color="primary" @click="editCost">
                    {{ editUpdateBtn }}
                  </v-btn>

                  <v-dialog v-model="costDeleteDialog" persistent max-width="290">
                    <template v-slot:activator="{ on, attrs }">
                      <v-btn color="error" depressed v-bind="attrs" v-on="on">
                        DELETE
                      </v-btn>
                    </template>
                    <v-card>
                      <v-card-title class="text-h5">
                        Are you sure?
                      </v-card-title>
                      <v-card-text>
                        Deleting Cost
                        {{ selectedCost.name }}
                      </v-card-text>
                      <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="green darken-1" text @click="costDeleteDialog = false">
                          Cancel
                        </v-btn>
                        <v-btn color="green darken-1" text @click="deleteCost">
                          Delete
                        </v-btn>
                      </v-card-actions>
                    </v-card>
                  </v-dialog>
                </v-layout>
              </v-col>
            </v-row>
          </div>

          <div v-if="isCourseSelected" class="mx-5">
            <v-row>
              <v-col  cols="12" sm="6">
                <v-text-field :disabled="courseEditable" label="Course code" outlined dense
                  v-model="selectedCourse.id_no"></v-text-field>
              </v-col>
              <v-col  cols="12" sm="6">
                <v-text-field :disabled="courseEditable" label="Course fee" outlined dense v-model="selectedCourse.fee">
                </v-text-field>
              </v-col>
              <v-col  cols="12" sm="12">
                <v-text-field :disabled="courseEditable" label="Title" outlined dense v-model="selectedCourse.name">
                </v-text-field>
              </v-col>
              <v-col  cols="12" sm="12">
                <v-text-field :disabled="courseEditable" label="Description" outlined dense
                  v-model="selectedCourse.description"></v-text-field>
              </v-col>

              <v-col  cols="12" sm="12">
                <v-layout row justify-space-around>
                  <v-btn depressed color="primary" @click="editCourse">
                    {{ editUpdateBtn }}
                  </v-btn>

                  <v-dialog v-model="courseDeleteDialog" persistent max-width="290">
                    <template v-slot:activator="{ on, attrs }">
                      <v-btn color="error" depressed v-bind="attrs" v-on="on">
                        DELETE
                      </v-btn>
                    </template>
                    <v-card>
                      <v-card-title class="text-h5">
                        Are you sure?
                      </v-card-title>
                      <v-card-text>
                        Deleting Course
                        {{ selectedCourse.name }}
                      </v-card-text>
                      <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="green darken-1" text @click="courseDeleteDialog = false">
                          Cancel
                        </v-btn>
                        <v-btn color="green darken-1" text @click="deleteCourse">
                          Delete
                        </v-btn>
                      </v-card-actions>
                    </v-card>
                  </v-dialog>
                </v-layout>
              </v-col>
            </v-row>
          </div>
          <div v-if="isNoticeSelected" class="mx-5">
            <v-row>
              <v-col  cols="12" sm="12">
                <v-text-field :disabled="noticeEditable" label="Notice Description" outlined dense
                  v-model="selectedNotice.description"></v-text-field>
              </v-col>
              <v-col  cols="12" sm="6">
                <v-text-field :disabled="noticeEditable" label="End date" outlined dense type="date"
                  v-model="selectedNotice.end"></v-text-field>
              </v-col>
              <v-col  cols="12" sm="12">
                <v-layout row justify-space-around>
                  <v-btn depressed color="primary" @click="editNotice">
                    {{ editUpdateBtn }}
                  </v-btn>

                  <v-dialog v-model="noticeDeleteDialog" persistent max-width="290">
                    <template v-slot:activator="{ on, attrs }">
                      <v-btn color="error" depressed v-bind="attrs" v-on="on">
                        DELETE
                      </v-btn>
                    </template>
                    <v-card>
                      <v-card-title class="text-h5">
                        Are you sure?
                      </v-card-title>
                      <v-card-text>
                        Deleting Notice
                        {{ selectedNotice.description }}
                      </v-card-text>
                      <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="green darken-1" text @click="noticeDeleteDialog = false">
                          Cancel
                        </v-btn>
                        <v-btn color="green darken-1" text @click="deleteNotice">
                          Delete
                        </v-btn>
                      </v-card-actions>
                    </v-card>
                  </v-dialog>
                </v-layout>
              </v-col>
            </v-row>
          </div>
        </v-scroll-y-transition>
      </v-col>
    </v-row>
  </v-container>
</template> 

<script>
export default {
  components: {},
  data() {
    return {
      userLevels: ["admin", "user"],
      selectedUser: null,
      selectedCost: null,
      selectedCourse: null,
      selectedNotice: null,
      userEditable: true,
      noticeEditable: true,
      costEditable: true,
      courseEditable: true,
      editUpdateBtn: "EDIT",
      editUpdateBtn: "EDIT",
      userDeleteDialog: false,
      courseDeleteDialog: false,
      costDeleteDialog: false,
      noticeDeleteDialog: false,
      userPassword: "",
    };
  },
  components: {},
  methods: {
    editUser() {
      let updateUser = {
        name: this.selectedUser.name,
        email: this.selectedUser.email,
        level: this.selectedUser.level,
        password: this.userPassword,
      };

      if (this.editUpdateBtn == "EDIT") {
        this.userEditable = false;
        this.editUpdateBtn = "UPDATE";
      } else {
        axios
          .put("api/users/edit", { user: JSON.stringify(updateUser) })
          .then((response) => {
            console.log(response.data);
            if (response.data == "True") {
              this.userEditable = true;
              this.editUpdateBtn = "EDIT";
            }
          })
          .catch((error) => {
            console.log(error);
          });
      }
    },
    editCost() {
      let updateCost = {
        id_no: this.selectedCost.id_no,
        name: this.selectedCost.name,
        description: this.selectedCost.description,
        fee: this.selectedCost.fee,
      };

      if (this.editUpdateBtn == "EDIT") {
        this.costEditable = false;
        this.editUpdateBtn = "UPDATE";
      } else {
        axios
          .put("api/costs/edit", { cost: JSON.stringify(updateCost) })
          .then((response) => {
            console.log(response.data);
            if (response.data == "True") {
              this.costEditable = true;
              this.editUpdateBtn = "EDIT";
            }
          })
          .catch((error) => {
            console.log(error);
          });

        //do the updating and turn the button back to  edit
        this.costEditable = true;
        this.editUpdateBtn = "EDIT";
      }
    },
    editCourse() {
      let updateCourse = {
        id_no: this.selectedCourse.id_no,
        name: this.selectedCourse.name,
        description: this.selectedCourse.description,
        fee: this.selectedCourse.fee,
      };

      if (this.editUpdateBtn == "EDIT") {
        this.courseEditable = false;
        this.editUpdateBtn = "UPDATE";
      } else {
        axios
          .put("api/courses/edit", { course: JSON.stringify(updateCourse) })
          .then((response) => {
            console.log(response.data);
            if (response.data == "True") {
              this.courseEditable = true;
              this.editUpdateBtn = "EDIT";
            }
          })
          .catch((error) => {
            console.log(error);
          });

        //do the updating and turn the button back to  edit
        this.courseEditable = true;
        this.editUpdateBtn = "EDIT";
      }
    },

    editNotice() {
      let updateNotice = {
        id: this.selectedNotice.id,
        description: this.selectedNotice.description,
        end: this.selectedNotice.end,
      };

      if (this.editUpdateBtn == "EDIT") {
        this.noticeEditable = false;
        this.editUpdateBtn = "UPDATE";
      } else {
        axios
          .put("api/notices/edit", { notice: JSON.stringify(updateNotice) })
          .then((response) => {
            console.log(response.data);
            if (response.data == "True") {
              this.noticeEditable = true;
              this.editUpdateBtn = "EDIT";
            }
          })
          .catch((error) => {
            console.log(error);
          });

      }

    },
    deleteNotice() {
      axios
        .delete("api/notices/delete/" + this.selectedNotice.id)
        .then((response) => {
          console.log(response.data);
          this.getallNotices();
          this.noticeDeleteDialog = false;
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
    deleteUser() {
      axios
        .delete("api/users/delete/" + this.selectedUser.email)
        .then((response) => {
          console.log(response.data);
          this.getallUsers();
          this.userDeleteDialog = false;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    deleteCost() {
      axios
        .delete("api/costs/delete/" + this.selectedCost.id_no)
        .then((response) => {
          console.log(response.data);
          this.getallCosts();
          this.costDeleteDialog = false;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    deleteCourse() {
      axios
        .delete("api/courses/delete/" + this.selectedCourse.id_no)
        .then((response) => {
          console.log(response.data);
          this.getallCourses();
          this.courseDeleteDialog = false;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },

  created() { },

  watch: {},
  computed: {
    isUserSelected() {
      this.selectedUser = this.$store.state.admin.selectedUser;

      if (
        this.$store.getters.adminSelectedTab == 0 &&
        this.selectedUser != null
      ) {
        return true;
      } else {
        return false;
      }
    },

    isCostSelected() {
      this.selectedCost = this.$store.state.admin.selectedCost;
      if (
        this.$store.getters.adminSelectedTab == 1 &&
        this.$store.state.admin.selectedCost
      ) {
        return true;
      } else {
        return false;
      }
    },
    isCourseSelected() {
      this.selectedCourse = this.$store.state.admin.selectedCourse;
      if (
        this.$store.getters.adminSelectedTab == 2 &&
        this.$store.state.admin.selectedCourse
      ) {
        return true;
      } else {
        return false;
      }
    },
    isNoticeSelected() {
      this.selectedNotice = this.$store.state.admin.selectedNotice;
      if (
        this.$store.getters.adminSelectedTab == 3 &&
        this.$store.state.admin.selectedNotice
      ) {
        return true;
      } else {
        return false;
      }
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
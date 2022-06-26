<template>
  <v-container>
    <v-btn @click="dialog = true" text> Change Password</v-btn>

    <v-dialog v-model="dialog" v-if="dialog" persistent content-class="elevation-0">
      <v-layout align-center justify-center>
        <v-stepper v-model="passwordChangeStep">
          <v-stepper-items>
            <v-stepper-content step="1">
              <v-card>
                <v-card-title>
                  Current Password
                </v-card-title>
                <v-card-subtitle>
                  <span style="color: red">{{ errorMessage }}</span>
                </v-card-subtitle>

                <v-card-text>
                  <v-form ref="form">
                    <v-text-field prepend-icon="mdi-lock" light label="Password"
                      :append-icon="value ? 'mdi-eye-off' : 'mdi-eye'" @click:append="() => (value = !value)"
                      :type="value ? 'password' : 'text'" required :rules="formRules" v-model="loginForm.password">
                    </v-text-field>
                    <v-btn @click.prevent="login" block type="submit" :loading="loginLoading" :disabled="loginLoading">
                      Proceed</v-btn>
                  </v-form>
                </v-card-text>
                <v-card-actions>
                  <v-layout row>
                    <v-spacer></v-spacer>
                    <v-btn text @click="cancelDialog"> Cancel</v-btn>
                  </v-layout>
                </v-card-actions>
              </v-card>
            </v-stepper-content>

            <v-stepper-content step="2">
              <v-card light max-width="500" >
                <v-card-title> Change Password </v-card-title>
                <v-card-subtitle>
                  <span style="color: red">{{ errorMessage }}</span>
                </v-card-subtitle>
                <v-card-text>
                  <v-form>
                    <v-text-field prepend-icon="mdi-lock" light :rules="formRules" required label="New Password"
                      type="password" v-model="registerForm.password"></v-text-field>
                    <v-text-field prepend-icon="mdi-lock" light :rules="formRules" required label="Confirm New Password"
                      type="password" v-model="registerForm.confirm_password">
                    </v-text-field>
                    <v-btn @click.prevent="register" block type="submit" :loading="registerLoading"
                      :disabled="registerLoading">
                      Change</v-btn>
                  </v-form>
                </v-card-text>
                <v-card-actions>
                  <v-layout row>
                    <v-spacer></v-spacer>
                    <v-btn text @click="cancelDialog"> Cancel</v-btn>
                  </v-layout>
                </v-card-actions>
              </v-card>
            </v-stepper-content>
          </v-stepper-items>
        </v-stepper>
      </v-layout>
    </v-dialog>


  </v-container>
</template>

<script>
export default {
  data() {
    return {
      value: String,
      dialog: false,
      loginLoading: false,
      registerLoading: false,
      formRules: [(v) => !!v || "Required"],
      passwordChangeStep: 1,
      errorMessage: "",
      newUser: false,
      loginForm: {
        email: "",
        password: "",
      },

      registerForm: {
        name: "",
        email: "",
        password: "",
        confirm_password: "",
      },
      errors: [],

    };
  },
  components: {},

  methods: {
    openDialog() {
      console.log("Opened dialog!");
      this.dialog = true;
    },

    login() {
      if (this.$refs.form.validate()) {
        this.loginLoading = true;
        this.loginForm.email = this.$store.state.user.email;
        axios
          .post("/api/login", this.loginForm)
          .then((response) => {
            if (response.status == 200) {
              this.errorMessage = "";
              this.passwordChangeStep = 2;
              this.loginLoading = false;

            } else {
              this.errorMessage = " Invalid Password!, Try Again later";
              this.loginLoading = false;
            }
          })
          .catch((error) => {
            // this.errors = error.response.data.errors;
            this.errorMessage = " Invalid Credentials, Try Again later";
            this.loginLoading = false;
          });
      }
    },

    register() {

      if (this.registerForm.password == this.registerForm.confirm_password) {
        this.registerForm.name = this.$store.state.user.name;
        this.registerForm.email = this.$store.state.user.email;
        this.registerLoading = true;
        axios
          .put("/api/changePswd", this.registerForm)
          .then((response) => {
            if (response.status == 200) {
              console.log("Password Changed!");
              this.registerLoading = false;
              this.cancelDialog();
              this.$router.replace({ name: "login" });
            }
          })
          .catch((error) => {
            this.errors = error.response.data.errors;
            this.registerLoading = false;
            this.errorMessage = "Something went wrong, Try again later";
          });
      }
      else {

        this.errorMessage = "Passwords not matching!";

      }
      // console.log(this.registerForm);

    },


    cancelDialog() {

      this.$refs.form.reset();
      this.loginForm.email = "";
      this.loginForm.password = "";
      this.registerForm.name = "";
      this.registerForm.email = "";
      this.registerForm.password = "";
      this.registerForm.confirm_password = "";
      this.errorMessage = "";
      this.dialog = false;
      this.passwordChangeStep = 1;
    }
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
<template>
  <v-app>
    <v-content>
      <v-container class="fill-height">

        <v-layout align-center justify-center>
          <v-stepper v-model="login_signup" class="transpStepper">
            <v-stepper-items>
              <v-stepper-content step="1">
                <v-card max-width="500"  color="transparent" elevation="0" class="loginWindowWidth">
                  
                  <v-layout column  align-center>
                    <v-img height="150" width="150"
                      src="https://computerclinicmw.com/wp-content/uploads/2022/05/CC-logo-color-.png"></v-img>
                    <v-card-title class="headline"> eServices </v-card-title>
                  </v-layout>
               
                  <v-card-subtitle>
                    <span style="color: red">{{ errorMessage }}</span>
                  </v-card-subtitle>

                  <v-card-text>
                    <v-form ref="form">
                      <v-text-field prepend-icon="mdi-email" light label="Email" type="email" required
                        :rules="formRules" v-model="loginForm.email">
                      </v-text-field>
                      <v-text-field prepend-icon="mdi-lock" light label="Password"
                        :append-icon="value ? 'mdi-eye-off' : 'mdi-eye'" @click:append="() => (value = !value)"
                        :type="value ? 'password' : 'text'" required :rules="formRules" v-model="loginForm.password">
                      </v-text-field>
                      <v-btn @click.prevent="login" block type="submit" :loading="loginLoading" :disabled="loginLoading" >
                        Sign In</v-btn>
                      <!-- <v-btn  text @click="login_signup = 2"> Sign Up</v-btn> -->
                    </v-form>
                  </v-card-text>
                  <!-- <v-card-actions>
                    <v-layout row>
                      <v-spacer></v-spacer>
                      <v-btn  text @click="login_signup = 2"> Sign Up</v-btn>
                    </v-layout>
                  </v-card-actions> -->
                </v-card>
              </v-stepper-content>

              <v-stepper-content step="2">
                <v-card light max-width="500" width="480">
                  <v-card-subtitle> Sign Up </v-card-subtitle>

                  <v-card-text>
                    <v-form>
                      <v-text-field prepend-icon="mdi-account" light label="Full Name" type="text" required
                        v-model="registerForm.name">
                      </v-text-field>
                      <v-text-field prepend-icon="mdi-email" light label="Email" type="email" required
                        v-model="registerForm.email">
                      </v-text-field>
                      <v-text-field prepend-icon="mdi-lock" light required label="Password" type="password"
                        v-model="registerForm.password"></v-text-field>
                      <v-text-field prepend-icon="mdi-lock" light required label="Confirm Password" type="password"
                        v-model="registerForm.confirm_password"></v-text-field>
                      <v-btn @click.prevent="register" block type="submit">
                        Sign Up</v-btn>
                    </v-form>
                  </v-card-text>
                </v-card>
              </v-stepper-content>
            </v-stepper-items>
          </v-stepper>
        </v-layout>
      </v-container>
    </v-content>
  </v-app>
</template>

<script>
export default {
  name: "app",
  data() {
    return {
      value: String,
      loginLoading: false,
      formRules: [(v) => !!v || "Required"],
      login_signup: 1,
      errorMessage: "",

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
  methods: {
    login() {
      if (this.$refs.form.validate()) {
        this.loginLoading = true;
        axios
          .post("/api/login", this.loginForm)
          .then((response) => {
            if (response.status == 200) {
              axios
                .get("/api/user")
                .then((response) => {
                  if (response.status == 200) {
                    this.user = response.data;

                    if (this.user) {
                      this.$store.commit("loggedUser", this.user);
                    }
                  }
                })
                .catch((error) => {
                  console.log(error.response.data.errors);
                });

              // this.loginLoading = false;

              this.$router.push({ name: "homepage" });
              this.loginLoading = false;
            } else {
              this.errorMessage = " Invalid Credentials, Try Again later";
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
      console.log(this.registerForm);
      axios
        .post("/api/registerUser", this.registerForm)
        .then((response) => {
          if (response.status == 201) {
            console.log("User Registered");
          }
        })
        .catch((error) => {
          this.errors = error.response.data.errors;
        });
    },

  },
  computed: {
    // firstUser() {
    //   //creating the first account using the SIGN UP, from there, all other accounts are created with this account

    //   axios.get('api/firstUser').then((response) => {


    //     console.log("user available login")
    //     return false;

    //   }).catch((err) => {

    //     console.log(err)

    //     if (err.response.status == 404) {
    //       console.log("No usr, sign up");
    //       return true;
    //     }
    //   })
    // }
  },
  created() {
    // this.firstUser();

  },
};
</script>
<style scoped>
#app {
  background: url('https://images.unsplash.com/photo-1649601338076-19746c4394c3?crop=entropy&cs=tinysrgb&fm=jpg&ixlib=rb-1.2.1&q=80&raw_url=true&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1498') no-repeat center center fixed !important;
  background-size: cover;
}

.transpStepper {
  /* color: "transparent"; */
  /* background-color: transparent; */
  box-shadow: none;
  background: rgba(255, 255, 255, 0.5);
  backdrop-filter: blur(5px);
}
.loginWindowWidth{
width: 320px;
}

@media(min-width:600px){
.loginWindowWidth{
width: 480px;
}

}
</style>
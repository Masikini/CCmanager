<template>
  <v-app>
    <span class="headline my-5">Create User </span>
    <v-divider></v-divider>
    <v-form ref="form" @submit.prevent="submit">
      <v-container class="pa-15">
        <span class="headline">New User</span>
        <v-row>
          <v-col cols="12">
            <v-text-field
              prepend-icon="mdi-account"
              light
              label="Full Name"
              type="text"
              required
              v-model="form.name"
              :rules="Rules"
            >
            </v-text-field>
          </v-col>
          <v-col cols="12">
            <v-text-field
              prepend-icon="mdi-email"
              light
              label="Email"
              type="email"
              required
              v-model="form.email"
              :rules="Rules"
            >
            </v-text-field>
          </v-col>
          <v-col cols="12">
            <v-text-field
              prepend-icon="mdi-lock"
              light
              required
              label="Password"
              type="password"
              v-model="form.password"
              :rules="Rules"
            ></v-text-field>
          </v-col>
          <v-col cols="12">
            <v-text-field
              prepend-icon="mdi-lock"
              light
              required
              label="Confirm Password"
              type="password"
              v-model="form.confirm_password"
              :rules="Rules"
            ></v-text-field>
          </v-col>
        </v-row>
      </v-container>
      <v-container class="px-15">
        <v-row>
          <v-col cols="6">
        <v-btn color="primary" @click.prevent="register" block type="submit">
          Sign Up</v-btn
        ></v-col>
        <v-col cols="6">
        <v-btn text @click="cancelForm"> Cancel </v-btn>
        </v-col>
         </v-row>
      </v-container>
    </v-form>
  </v-app>
</template>

<script>
export default {
  data() {
    return {
      Rules: [(v) => !!v || "Required"],

      form: {
        name: "",
        email: "",
        password: "",
        confirm_password: "",
      },
      errors: [],
    };
  },
  methods: {
    register() {
      if (this.$refs.form.validate()) {
        axios
          .post("/api/registerUser", this.form)
          .then((response) => {
            if (response.status == 201) {
              console.log("User Registered");
               this.$emit("addUser");
            }
          })
          .catch((error) => {
            this.errors = error.response.data.errors;
          });
      }
    },

    cancelForm() {
      this.form.name = "";
      this.form.email = "";
      this.form.password = "";
      this.form.confirm_password = "";
      this.$refs.form.resetValidation();
      this.$emit("cancelFormRegisterUser");
    },
  },
};
</script>
<style scoped>
</style>
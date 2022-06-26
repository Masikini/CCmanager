<template>
  <v-form v-model="valid" ref="form" @submit.prevent="submit">
    <v-container class="py-15 px-2">
      <span class="headline">New Client</span>
      <v-row>
        <v-col cols="12" sm="12">
          <v-text-field label="Full Name*" hint="Verifiable by ID" persistent-hint required v-model="client.name"
            :rules="nameRules" counter="30"></v-text-field>
        </v-col>
        <v-col cols="12" sm="6">
          <v-select :items="['NID', 'Passport']" label="ID Type" v-model="client.id_type"></v-select>
        </v-col>
        <v-col  cols="12" sm="6">
          <v-text-field label="ID No" hint="Verifiable by ID" persistent-hint v-model="client.id_no">
          </v-text-field>
        </v-col>
        <v-col  cols="12" sm="6">
          <v-text-field label="Email" v-model="client.email"></v-text-field>
        </v-col>
        <v-col  cols="12" sm="6">
          <v-text-field label="Phone Number*" type="number" v-model="client.phone" counter="12" required
            :rules="phoneRules"></v-text-field>
        </v-col>
        <v-col  cols="12" sm="6">
          <v-text-field label="Residence" v-model="client.residence"></v-text-field>
        </v-col>
        <v-col  cols="12" sm="6">
          <v-text-field label="Institution/Company" v-model="client.institution"></v-text-field>
        </v-col>
        <v-col  cols="12" sm="6">
          <v-select :items="['7-17', '18-29', '30+']" label="Age" v-model="client.age"></v-select>
        </v-col>
        <v-col  cols="12" sm="6">
          <v-select :items="['M', 'F', 'O']" label="Gender" hint="Male, Female, Other" v-model="client.gender">
          </v-select>
        </v-col>
      </v-row>
    </v-container>

    <v-container class="px-15">
      <v-btn color="primary" @click="register"> Register </v-btn>

      <v-btn text @click="registeredClient"> Already a Client </v-btn>
    </v-container>
  </v-form>

</template>

<script>
export default {
  data() {
    return {
      loading: false,
      entries: [],
      items: [],

      select: null,
      loadingConfirm: false,

      displayText: "",
      e1: 1,
      valid: false,
      valid2: false,
      ticketOpened: false,

      client: {
        name: "",
        id_type: "",
        id_no: "",
        email: "",
        phone: "",
        residence: "",
        institution: "",
        age: "",
        gender: "",
      },
      nameRules: [(v) => !!v || "Name is required"],

      courseRules: [(v) => !!v || "A course is required"],
      // emailRules: [(v) => /.+@.+/.test(v) || "E-mail must be valid"],
      phoneRules: [(v) => !!v || "Phone number is required"],
    };
  },
  methods: {
    cancelForm() {

      this.client.name = "";
      this.client.id_type = "";
      this.client.id_no = "";
      this.client.email = "";
      this.client.phone = "";
      this.client.residence = "";
      this.client.institution = "";
      this.client.age = "";
      this.client.gender = "";
      this.$refs.form.resetValidation();

      // this.$emit("cancelFormTraining");
    },
    register() {
      if (this.$refs.form.validate()) {
        axios
          .post("api/client/store", { client: this.client })

          .then((response) => {
            if (response.status == 201) {
              if (this.client.name) {
                this.select = this.client.name + " , " + this.client.phone;
                // this.goStep2();
                this.registeredClient();
                // this.querySelections(this.select);
                // console.log(this.select);
              }
            }
          })
          .catch((error) => {
            console.log(error.response.data);
          });
      }
    },


    registeredClient() {

      this.cancelForm();
      this.$emit("registered");
    },


  },

  created() {

  },
  computed: {

  },
  watch: {

  },
};
</script>

<style>
</style>
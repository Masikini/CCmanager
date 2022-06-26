<template>
  <v-app>
    <!--  -->

    <!-- <span class="headline my-5">Costs Form</span>

    <v-divider></v-divider> -->

    <v-form ref="form" @submit.prevent="submit">
      <v-container class="py-15 px-2">
        <span class="headline">New Cost</span>
        <v-row>
          <v-col sm="12" cols="12">
            <span style="color: red">{{ errorMessage }}</span>
          </v-col>
          <v-col cols="12" sm="4">
            <v-text-field label="Cost code" required :rules="formRules" v-model="cost.id_no"></v-text-field>
          </v-col>
          <v-col  cols="12" sm="4">
            <v-text-field label="Cost name" required :rules="formRules" v-model="cost.name"></v-text-field>
          </v-col>
          <v-col  cols="12" sm="4">
            <v-text-field label="Cost fee" required :rules="formRules" v-model="cost.fee"></v-text-field>
          </v-col>
          <v-col  cols="12" sm="4">
            <v-select :items="['Training', 'ComputerCare', 'ManagedIT']" label="Category" v-model="cost.category">
            </v-select>
          </v-col>
          <v-col sm="12" cols="12">
            <v-textarea filled auto-grow label="Description" rows="2" row-height="20" v-model="cost.description">
            </v-textarea>
          </v-col>
        </v-row>
      </v-container>

      <v-container class="px-5">
        <v-btn color="primary" @click="addCost"> Add Cost </v-btn>

        <v-btn text @click="cancelForm"> Cancel </v-btn>
      </v-container>
    </v-form>

    <!--  -->
  </v-app>
</template>

<script>
export default {
  data() {
    return {
      errorMessage: "",
      addCostLoading: false,
      formRules: [(v) => !!v || "Required"],
      cost: {
        id_no: "",
        name: "",
        category: "",
        description: "",
        fee: null,
      },

      titleRules: [(v) => !!v || "Title is required"],

      descriptionRules: [(v) => !!v || "A Description is required"],
      // emailRules: [(v) => /.+@.+/.test(v) || "E-mail must be valid"],
      targetRules: [(v) => !!v || "Target number is required"],
    };
  },
  methods: {
    cancelForm() {
      this.cost.description = "";
      this.cost.name = "";
      this.errorMessage = "";
      this.cost.category = "";
      (this.cost.fee = null),
        (this.cost.id_no = ""),
        this.$refs.form.resetValidation();

      this.$emit("cancelFormCost");
    },
    addCost() {
      console.log("regesitering");
      if (this.$refs.form.validate()) {
        this.addCostLoading = true;
        axios
          .post("api/costs/store", { cost: this.cost })

          .then((response) => {

            console.log("Cost added!");
            this.addCostLoading = false;
            setTimeout(() => {
              this.$emit("addCost");
              this.cancelForm();
            }, 100);

          })
          .catch((error) => {
            console.log(error.response.data);
            this.addCostLoading = false;
            this.errorMessage = "Something went wrong, unable to add Cost";

          });
      } else {
        console.log("Not confirmed");
        this.errorMessage = "Complete required fields";
      }
    },
  },
  computed: {
    // computedDateFormatted() {
    //   return this.formatDate(this.date);
    // },
  },
};
</script>

<style>
</style>
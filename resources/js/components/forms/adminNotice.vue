<template>
  <v-app>
    <!--  -->

    <span class="headline my-5">Notices Form</span>

    <v-divider></v-divider>

    <v-form ref="form" @submit.prevent="submit">
      <v-container class="py-15 px-2">
        <span class="headline">New Notice</span>
        <v-row>
          <v-col sm="12" cols="12">
            <span style="color: red">{{ errorMessage }}</span>
          </v-col>
          <v-col sm="12" cols="12">
            <v-textarea filled auto-grow label="Description" rows="2" row-height="20" v-model="notice.description">
            </v-textarea>
          </v-col>
          <v-col cols="12" sm="4">
            <v-text-field label="End" type="date" v-model="notice.end" required :rules="targetRules"></v-text-field>
          </v-col>
          <v-col cols="12" sm="4">
            <v-text-field label="Date" type="date" v-model="notice.dates" required :rules="targetRules"></v-text-field>
          </v-col>

          <v-col cols="12" sm="4">
            <v-select :items="['red', 'orange']" label="Color" v-model="notice.color" required :rules="targetRules">
            </v-select>
          </v-col>
        </v-row>
      </v-container>

      <v-container class="px-5">
        <v-btn color="primary" @click="register" :loading="addNoticeLoading" :disabled="addNoticeLoading">
          Add Notice
        </v-btn>

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
      addNoticeLoading: false,
      errorMessage: "",
      notice: {
        description: "",
        end: null,
        dates: null,
        color: "",
      },

      titleRules: [(v) => !!v || "Title is required"],

      descriptionRules: [(v) => !!v || "A Description is required"],
      // emailRules: [(v) => /.+@.+/.test(v) || "E-mail must be valid"],
      targetRules: [(v) => !!v || "Target number is required"],
    };
  },
  methods: {
    cancelForm() {
      this.notice.description = "";
      this.notice.end = null;
      this.notice.dates = null;
      this.notice.color = "";
      this.errorMessage = "";
      this.$refs.form.resetValidation();

      this.$emit("cancelFormNotice");
    },
    register() {
      console.log("regesitering");
      if (this.$refs.form.validate()) {
        this.addNoticeLoading = true;
        axios
          .post("api/notices/store", { notice: this.notice })

          .then((response) => {

            console.log("notice added!");
            this.addNoticeLoading = false;
            this.$emit("addNotice");
            //send email to platform users
            axios.get('/api/notify').then((response) => {
              console.log("Emailed  notification!")
            }).catch((err) => { console.log(err) });
            setTimeout(() => {
              this.cancelForm();
            }, 100);
            // this.cancelForm()

          })
          .catch((error) => {
            this.addNoticeLoading = false;
            this.errorMessage = "Something went wrong! unable to add notice";
            console.log(error.response.data);
          });
      } else {
        console.log("Not confirmed");
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
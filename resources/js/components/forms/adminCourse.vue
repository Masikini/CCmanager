<template>
  <v-app>
    <!--  -->

    <!-- <span class="headline my-5">courses Form</span>

    <v-divider></v-divider> -->

    <v-form ref="form" @submit.prevent="submit">
      <v-container class="py-15 px-2">
        <span class="headline">New course</span>
        <v-row>
          <v-col sm="12" cols="12">
            <span style="color: red">{{ errorMessage }}</span>
          </v-col>
          <v-col  cols="12" sm="4">
            <v-text-field
              label="Course code"
              required
              :rules="formRules"
              v-model="course.id_no"
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="4">
            <v-text-field
              label="course name"
              required
              :rules="formRules"
              v-model="course.name"
            ></v-text-field>
          </v-col>
          <v-col cols="12" sm="4">
            <v-text-field
              label="course fee"
              required
              :rules="formRules"
              v-model="course.fee"
            ></v-text-field>
          </v-col>

          <v-col sm="12" cols="12">
            <v-textarea
              filled
              auto-grow
              label="Description"
              rows="2"
              row-height="20"
              v-model="course.description"
            ></v-textarea>
          </v-col>
        </v-row>
      </v-container>

      <v-container class="px-5">
        <v-btn
          color="primary"
          @click="addCourse"
          :loading="addCourseLoading"
          :disabled="addCourseLoading"
        >
          Add course
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
      errorMessage: "",
      addCourseLoading: false,
      formRules: [(v) => !!v || "Required"],
      course: {
        id_no: "",
        name: "",
        description: "",
        fee: 0,
      },

      titleRules: [(v) => !!v || "Title is required"],

      descriptionRules: [(v) => !!v || "A Description is required"],
      // emailRules: [(v) => /.+@.+/.test(v) || "E-mail must be valid"],
      targetRules: [(v) => !!v || "Target number is required"],
    };
  },
  methods: {
    cancelForm() {
      this.course.description = "";
      this.course.name = "";
      this.errorMessage = "";
      (this.course.fee = 0),
        (this.course.id_no = ""),
        this.$refs.form.resetValidation();

      this.$emit("cancelFormCourse");
    },
    addCourse() {
      console.log("regesitering");

      if (this.$refs.form.validate()) {
        this.addCourseLoading = true;
        axios
          .post("api/courses/store", { course: this.course })

          .then((response) => {
       
              console.log("course added!");
              this.addCourseLoading = false;
              setTimeout(() => {
                this.$emit("addCourse");
                this.cancelForm();
              }, 100);
            
          })
          .catch((error) => {
            console.log(error.response.data);
            this.addCourseLoading = false;
            this.errorMessage = "Something went wrong, unable to add Course";
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
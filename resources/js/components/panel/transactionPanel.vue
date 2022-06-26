<template>
  <v-container class="justify-center mt-15">
    <v-row>
      <v-col sm="12" cols="12" class="justify-center my-2">
        <div>
          <!-- Side panel -->
          <!-- <component :is="loadTicket" v-bind="saleProperties" />
          
           -->

          <v-container class="d-flex justify-center">
            <v-row>
              <v-col sm="12" cols="12" class="justify-center my-2">
                <v-scroll-y-transition mode="out-in">
                  <div v-if="saleProperties">
                    <v-row justify="center">
                      <v-icon size="100" color="primary">
                        mdi-cash-multiple
                      </v-icon>

                      <v-col sm="12" cols="12"  class="justify-center">
                        <v-layout row justify-center align-center>
                          <span class="justify-center headline">
                            {{ sale.tick_id }}
                          </span>
                        </v-layout>
                      </v-col>
                      <v-col sm="12" cols="12"  class="justify-center">
                        <v-layout row justify-center align-center>
                          <span class="justify-center headline"
                            >{{ sale.payment_method }}
                          </span>
                        </v-layout>
                      </v-col>

                      <v-col sm="12" cols="12"  class="justify-center mx-2 mt-1">
                        <v-layout column align-left>
                          <v-list>
                            <v-list-group
                              :value="false"
                              prepend-icon="mdi-details"
                            >
                              <template v-slot:activator>
                                <v-list-item-title>Details</v-list-item-title>
                              </template>
                              <v-list-item-content>
                                <v-sheet
                                  class="mr-1 py-5 px-2"
                                  color="grey lighten-3"
                                >
                                  <v-layout column align-start>
                                    <v-layout row align-start>
                                      <span
                                        class="sub-headline mr-3 font-weight-bold"
                                      >
                                        Date:
                                      </span>
                                      {{ $store.getters.saleCreatedAt}}
                                    </v-layout>
                                    <!-- <v-layout row align-start>
                                      <span
                                        class="sub-headline mr-3 font-weight-bold"
                                      >
                                        Client:
                                      </span>
                                      {{ $store.getters.refClientName.client}}
                                    
                                    </v-layout> -->
                                    <!-- <v-layout row align-start>
                                      <span
                                        class="sub-headline mr-3 font-weight-bold"
                                      >
                                        ID:
                                      </span>
                                      {{ sale.id_type }} ,
                                     
                                    </v-layout> -->
                                  </v-layout>
                                </v-sheet>
                                <v-list-item-title class="mt-5"
                                  >Description</v-list-item-title
                                >
                                <v-sheet
                                  class="mr-1 py-5 px-2"
                                  color="grey lighten-3"
                                >
                                  {{ sale.description }}
                                </v-sheet>
                              </v-list-item-content>
                            </v-list-group>
                          </v-list>
                        </v-layout>
                      </v-col>

                      <v-col sm="12" cols="12" class="justify-center">
                        <v-card flat>
                          <v-card-title> Receipts</v-card-title>

                          <v-card-text class="justify-center">
                            <v-container>
                              <!-- <v-sheet class="mr-1 pa-5" color="grey lighten-3">
                                {{ sale.attach }}
                              </v-sheet> -->

                              <v-card>
                                <v-card-title> File </v-card-title>
                                <v-card-text>
                                  {{ sale.attach }}
                                </v-card-text>
                                <v-card-actions>
                                  <v-btn
                                    color="green darken-1"
                                    text
                                    @click="viewFile"
                                  >
                                    View
                                  </v-btn>
                                  <v-btn
                                    color="green darken-1"
                                    text
                                    @click="downloadFile"
                                  >
                                    Download
                                  </v-btn>
                                </v-card-actions>
                              </v-card>
                            </v-container>
                          </v-card-text>
                        </v-card>
                      </v-col>
                    </v-row>
                  </div>

                  <span v-if="!saleProperties"> Select a Transaction </span>
                </v-scroll-y-transition>
              </v-col>
            </v-row>
          </v-container>
        </div>
      </v-col>
    </v-row>
    <v-dialog
      v-model="fileviewDialog"
      v-if="fileviewDialog"
      persistent
      max-width="790"
      
    >
      <v-card class="my-auto">
        <v-card-title class="headline"> File </v-card-title>
        <v-card-text >
          {{ sale.attach }}
          
          <v-container>
          <iframe :src="this.file_to_view" frameborder="0" width="700" height="720" ></iframe>
           <!-- <object :data="this.file_to_view" type="application/pdf" width="100%" height="100%"> </object> -->
        </v-container>
        </v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="green darken-1" text @click="closeView"> Close </v-btn>
        </v-card-actions>
      </v-card>
      
    </v-dialog>
  </v-container>
</template> 

<script>
// import computerCare from "./tickets/computerCare";

export default {
  components: {},
  data() {
    return {
      entries: [],
      file_to_view: "",
      sale: null,
      fileviewDialog: false,
    };
  },
  components: {
    // computerCare,
  },
  methods: {

    closeView() {
      this.fileviewDialog = false;
    },
    viewFile() {
      axios
        .get("api/sales/view/" + this.sale.attach)
        .then((response) => {
          // var fileURL = window.URL.createObjectURL(new Blob([response.data]));
          console.log(response.data);
          this.file_to_view ='assets/'+this.sale.attach
        })
        .catch((error) => {
          console.log(error.response.data);
        });
      console.log(this.sale.attach);
      this.fileviewDialog = true;
    },
    downloadFile() {
      // let vm = this;

      axios({
        url: "api/sales/download/" + this.sale.attach,
        method: "GET",
        responseType: "blob",
      })
        .then((response) => {
          //  Vue.set(vm.model, 'model', response.data);
          console.log("downloading");
          var fileURL = window.URL.createObjectURL(new Blob([response.data]));
          var fileLink = document.createElement("a");

          fileLink.href = fileURL;
          fileLink.setAttribute("download", this.sale.attach);
          document.body.appendChild(fileLink);

          fileLink.click();
        })
        .catch((error) => {
          console.log(error.response.data);
        });
    },
  },

  computed: {
    saleProperties() {
      this.sale = this.$store.state.sale.selected;

      if (this.$store.state.sale.selected == null) {
        return false;
      } else {
        return true;
      }
    },
  },

  watch: {},
 
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
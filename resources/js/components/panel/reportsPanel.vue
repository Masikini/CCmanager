<template>
  <v-container class="justify-center mt-15">
    <v-row>
      <v-col sm="12" cols="12" class="justify-center my-2">
        <div>
          <v-container class="d-flex justify-center">
            <v-row>
              <v-col sm="12" cols="12" class="justify-center my-2">
                <v-scroll-y-transition mode="out-in">
                  <div v-if="$store.state.reports.sidePanel == 0">
                    <v-row justify="start">
                      <v-col sm="6"  cols="12" class="justify-start">
                        <v-card elevation="1" outlined>
                          <v-card-title>
                            Revenues
                          </v-card-title>
                          <v-card-text>
                            <v-layout column align-start>
                              <!-- <span class="justify-start headline"> Revenue </span> -->
                              <span class="justify-start subheadline">
                                <v-icon color="grey"> mdi-calendar-today </v-icon>:
                                {{ incomeStatementData.todayTotalRevenue }}
                              </span>
                              <span class="justify-start subheadline">
                                <v-icon color="grey"> mdi-calendar-week </v-icon>:
                                {{ incomeStatementData.weekTotalRevenue }}
                              </span>
                              <span class="justify-start subheadline">
                                <v-icon color="grey"> mdi-calendar-month </v-icon>:
                                {{ incomeStatementData.monthTotalRevenue }}
                              </span>
                            </v-layout>
                          </v-card-text>
                        </v-card>

                      </v-col>
                      <v-col sm="6" cols="12" class="justify-start">
                        <v-card elevation="1" outlined>
                          <v-card-title>
                            Expenses
                          </v-card-title>
                          <v-card-text>

                          </v-card-text>
                          <v-layout column align-start>
                            <!-- <span class="justify-start headline">Expenses </span> -->
                            <span class="justify-start subheadline">
                              Total: {{ incomeStatementData.totalExpenses }}
                            </span>
                          </v-layout>
                        </v-card>

                      </v-col>
                      <v-col sm="6" cols="12" class="justify-start">
                        <v-card elevation="1" outlined>
                          <v-card-title>
                            Profits
                          </v-card-title>
                          <v-card-text>
                            <v-layout column align-start>
                              <!-- <span class="justify-start headline">Profits </span> -->

                              <span class="justify-start subheadline">
                                Gross: {{ incomeStatementData.grossProfit }}
                              </span>

                              <span class="justify-start subheadline">
                                Net:{{ incomeStatementData.netProfit }}
                              </span>
                            </v-layout>
                          </v-card-text>
                        </v-card>
                      </v-col>
                    </v-row>
                  </div>
                </v-scroll-y-transition>
              </v-col>
            </v-row>
          </v-container>
        </div>
      </v-col>
    </v-row>
  </v-container>
</template> 

<script>
export default {
  components: {},
  data() {
    return {
      incomeStatementData: {
        monthTotalRevenue: 0,
        weekTotalRevenue: 0,
        todayTotalRevenue: 0,
        totalExpenses: 0,
        grossProfit: 0,
        netProfit: 0,
      },
    };
  },

  methods: {
    loadIncomeStatementData() {
      axios
        .get("api/reports/is")
        .then((response) => {
          console.log(response.data);

          this.incomeStatementData.monthTotalRevenue =
            response.data["totalRevenue"];
          this.incomeStatementData.totalExpenses =
            response.data["totalExpenses"];
          this.incomeStatementData.grossProfit = response.data["grossProfit"];
          this.incomeStatementData.netProfit = response.data["netProfit"];
          this.incomeStatementData.todayTotalRevenue =
            response.data["todayRevenue"];
          this.incomeStatementData.weekTotalRevenue =
            response.data["weekRevenue"];

          console.log(response.data["totalRevenue"]);
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },

  computed: {},
  created() {
    this.loadIncomeStatementData();
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
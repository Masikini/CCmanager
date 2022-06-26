<template>
  <v-sheet>
    <v-tabs background-color="primary lighten-1" dark centered v-model="tab">
      <v-tab @click="activatePanel(0)"> Income Statement </v-tab>
      <v-tab @click="activatePanel(1)"> Balance Sheet</v-tab>
    </v-tabs>

    <v-tabs-items v-model="tab">
      <v-tab-item>
        <v-card>
          <v-card-title>
            <v-row align-content="center">
              <v-col cols="5">
                <v-menu
                  ref="fromDateMenu"
                  :close-on-content-click="false"
                  :return-value.sync="report.from"
                  offset-y
                  min-width="290px"
                >
                  <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                      v-model="report.from"
                      label="From"
                      prepend-icon="mdi-calendar"
                      readonly
                      v-bind="attrs"
                      v-on="on"
                      required
                      :rules="targetRules"
                    ></v-text-field>
                  </template>
                  <v-date-picker v-model="fromDate" no-title scrollable>
                    <v-spacer></v-spacer>
                    <v-btn
                      text
                      color="primary"
                      @click="$refs.fromDateMenu.isActive = false"
                    >
                      Cancel
                    </v-btn>
                    <v-btn
                      text
                      color="primary"
                      @click="$refs.fromDateMenu.save(fromDate)"
                    >
                      OK
                    </v-btn>
                  </v-date-picker>
                </v-menu>
              </v-col>
              <v-col cols="5">
                <v-menu
                  ref="toDateMenu"
                  :close-on-content-click="false"
                  :return-value.sync="report.to"
                  offset-y
                  min-width="290px"
                >
                  <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                      v-model="report.to"
                      label="To"
                      prepend-icon="mdi-calendar"
                      readonly
                      v-bind="attrs"
                      v-on="on"
                    ></v-text-field>
                  </template>
                  <v-date-picker v-model="date" no-title scrollable>
                    <v-spacer></v-spacer>
                    <v-btn
                      text
                      color="primary"
                      @click="$refs.toDateMenu.isActive = false"
                    >
                      Cancel
                    </v-btn>
                    <v-btn
                      text
                      color="primary"
                      @click="$refs.toDateMenu.save(date)"
                    >
                      OK
                    </v-btn>
                  </v-date-picker>
                </v-menu>
              </v-col>
              <v-col cols="2">
                <v-btn
                  depressed
                  small
                  color="primary"
                  @click="report.to = null"
                >
                  Fetch
                </v-btn>
              </v-col>
            </v-row>
          </v-card-title>

          <v-container>
            <v-expansion-panels focusable inset>
              <v-expansion-panel>
                <v-expansion-panel-header>
                  General Report</v-expansion-panel-header
                >
                <v-expansion-panel-content>
                  <v-row>
                    <v-col sm="12" class="pt-6">
                      <v-card elevation="0" max-width="800" height="500">
                        <v-chart class="chart" :option="BarLineGeneralReport" />
                      </v-card>
                    </v-col>
                  </v-row>
                </v-expansion-panel-content>
              </v-expansion-panel>

              <v-expansion-panel>
                <v-expansion-panel-header>
                  Client Data</v-expansion-panel-header
                >
                <v-expansion-panel-content>
                  <v-row>
                    <!-- <v-col sm="12" class="pt-6">
                      <v-card elevation="0" width="800" height="500">
                        <v-chart class="chart" :option="BarClientAcquisition" />
                      </v-card>
                    </v-col> -->
                    <v-col sm="12" class="pt-6">
                      <v-card elevation="0" width="800" height="500">
                        <v-chart class="chart" :option="BarClientGender" />
                      </v-card>
                    </v-col>
                    <v-col sm="12" class="pt-6">
                      <v-card elevation="0" width="800" height="500">
                        <v-chart class="chart" :option="BarAgeGroup" />
                      </v-card>
                    </v-col>
                  </v-row>
                </v-expansion-panel-content>
              </v-expansion-panel>

              <v-expansion-panel>
                <v-expansion-panel-header>
                  Revenue Data</v-expansion-panel-header
                >
                <v-expansion-panel-content>
                  <v-row>
                    <v-col sm="12" class="pt-6">
                      <v-card elevation="0" width="800" height="700">
                        <v-chart class="chart" :option="LineRevenue" />
                      </v-card>
                    </v-col>
                    <v-col sm="12" class="pt-6">
                      <v-layout row justify-space-around>
                        <v-card elevation="0" width="400" height="500">
                          <v-chart class="chart" :option="PiePaymentByValue" />
                        </v-card>
                        <v-card elevation="0" width="400" height="500">
                          <v-chart
                            class="chart"
                            :option="PiePaymentByFrequency"
                          />
                        </v-card>
                      </v-layout>
                    </v-col>
                  </v-row>
                </v-expansion-panel-content>
              </v-expansion-panel>

              <v-expansion-panel>
                <v-expansion-panel-header>
                  Expenses Data
                </v-expansion-panel-header>
                <v-expansion-panel-content>
                  <v-col sm="12" class="pt-6">
                    <v-card elevation="0" width="800" height="700">
                      <v-chart class="chart" :option="LineExpenses" />
                    </v-card>
                  </v-col>
                </v-expansion-panel-content>
              </v-expansion-panel>
            </v-expansion-panels>
          </v-container>
        </v-card>
      </v-tab-item>
    </v-tabs-items>
  </v-sheet>
</template>

<script>
import VChart, { THEME_KEY } from "vue-echarts";
import "echarts";
export default {
  components: {
    VChart,
  },
  provide: {
    [THEME_KEY]: "light",
  },
  data() {
    return {
      targetRules: [(v) => !!v || "Field is required"],
      tab: null,
      date: null,
      fromDate: null,
      report: {
        from: null,
        to: null,
      },

      // BarClientAcquisition: {
      //   title: {
      //     text: "Acquisition, Retention, Drop",
      //   },
      //   legend: {},
      //   tooltip: {},
      //   dataset: {
      //     source: [
      //       ["product", "Acquisition", "Retention", "Drop"],
      //       ["January", 43.3, 85.8, 93.7],
      //       ["February", 83.1, 73.4, 55.1],
      //       ["March", 86.4, 65.2, 82.5],
      //     ],
      //   },
      //   xAxis: { type: "category" },
      //   yAxis: {},
      //   // Declare several bar series, each will be mapped
      //   // to a column of dataset.source by default.
      //   series: [{ type: "bar" }, { type: "bar" }, { type: "bar" }],
      // },

      BarClientGender: {
        title: {
          text: "Gender Distribution",
        },
        legend: {},
        tooltip: {},
        dataset: {
          source: [],
        },
        xAxis: { type: "category" },
        yAxis: {},
        // Declare several bar series, each will be mapped
        // to a column of dataset.source by default.
        series: [{ type: "bar" }, { type: "bar" }, { type: "bar" }],
      },

      BarAgeGroup: {
        title: {
          text: "Age Group Distribution",
        },
        legend: {},
        tooltip: {},
        dataset: {
          source: [],
        },
        xAxis: { type: "category" },
        yAxis: {},
        // Declare several bar series, each will be mapped
        // to a column of dataset.source by default.
        series: [{ type: "bar" }, { type: "bar" }, { type: "bar" }],
      },

      BarLineGeneralReport: {
        title: {
          text: "General Report",
        },
        legend: {},
        tooltip: {},
        dataset: {
          source: [],
        },
        xAxis: { type: "category" },
        yAxis: {},
        // Declare several bar series, each will be mapped
        // to a column of dataset.source by default.
        series: [{ type: "bar" }, { type: "bar" }, { type: "line" }],
      },

      PiePaymentByValue: {
        feature: {
          saveAsImage: {},
        },
        title: {
          text: "Payment Method by Value",
        },
        tooltip: {
          trigger: "item",
        },
        legend: {
          top: "5%",
          left: "center",
        },
        series: [
          {
            name: "Payment by",
            type: "pie",
            radius: ["40%", "70%"],
            avoidLabelOverlap: false,
            itemStyle: {
              borderRadius: 10,
              borderColor: "#fff",
              borderWidth: 2,
            },
            label: {
              show: false,
              position: "center",
            },
            emphasis: {
              label: {
                show: true,
                fontSize: "20",
                fontWeight: "bold",
              },
            },
            labelLine: {
              show: false,
            },
            data: [],
          },
        ],
      },
      PiePaymentByFrequency: {
        feature: {
          saveAsImage: {},
        },
        title: {
          text: "Payment Method by Frequency",
        },
        tooltip: {
          trigger: "item",
        },
        legend: {
          top: "5%",
          left: "center",
        },
        series: [
          {
            name: "Payment by",
            type: "pie",
            radius: ["40%", "70%"],
            avoidLabelOverlap: false,
            itemStyle: {
              borderRadius: 10,
              borderColor: "#fff",
              borderWidth: 2,
            },
            label: {
              show: false,
              position: "center",
            },
            emphasis: {
              label: {
                show: true,
                fontSize: "20",
                fontWeight: "bold",
              },
            },
            labelLine: {
              show: false,
            },
            data: [],
          },
        ],
      },

      LineRevenue: {
        title: {
          text: "Sales",
        },
        tooltip: {
          trigger: "axis",
        },
        legend: {
          data: ["IT Training", "Comp Care", "ManagedIT"],
        },
        grid: {
          left: "3%",
          right: "4%",
          bottom: "3%",
          containLabel: true,
        },
        toolbox: {
          feature: {
            saveAsImage: {},
          },
        },
        xAxis: {
          type: "category",
          boundaryGap: false,
          data: [],
        },
        yAxis: {
          type: "value",
        },
        series: [],
      },

      LineExpenses: {
        title: {
          text: "Goods and Service Sales",
        },
        tooltip: {
          trigger: "axis",
        },
        legend: {
          data: ["IT Training", "Comp Care", "ManagedIT"],
        },
        grid: {
          left: "3%",
          right: "4%",
          bottom: "3%",
          containLabel: true,
        },
        toolbox: {
          feature: {
            saveAsImage: {},
          },
        },
        xAxis: {
          type: "category",
          boundaryGap: false,
          data: [],
        },
        yAxis: {
          type: "value",
        },
        series: [],
      },
    };
  },
  methods: {
    activatePanel(tabBar) {
      console.log("Active tab is", tabBar);
      this.$store.commit("selectReportPanel", tabBar); //send the tab index to switch the sidepanel options corresponding to the selected tab.
    },

    loadBarLineGeneralReport() {
      axios
        .get("api/reports/gr") //general report
        .then((response) => {
          console.log(response.data[0]);
          this.BarLineGeneralReport.dataset.source = response.data[0];

          // JSON.parse(response.data).forEach((element) => {
          //   console.log(element);
          // });
        })
        .catch((error) => {
          console.log(error);
        });
    },
    loadBarClientData() {
      axios
        .get("api/reports/cdr") //client data report
        .then((response) => {
          // console.log(response.data[0]);
          this.BarClientGender.dataset.source = response.data[0];
          this.BarAgeGroup.dataset.source = response.data[1];

          // JSON.parse(response.data).forEach((element) => {
          //   console.log(element);
          // });
        })
        .catch((error) => {
          console.log(error);
        });
    },

    loadLineExpensesData() {
      axios
        .get("api/reports/er") //expenses report
        .then((response) => {
          // console.log(response.data[0]);
          this.LineExpenses.series = response.data[1];
          this.LineExpenses.xAxis.data = response.data[0];

          // JSON.parse(response.data).forEach((element) => {
          //   console.log(element);
          // });
        })
        .catch((error) => {
          console.log(error);
        });
    },

    loadLineRevenueData() {
      axios
        .get("api/reports/rr") //expenses report
        .then((response) => {
          // console.log(response.data[0]);
          this.LineRevenue.xAxis.data = response.data[0];
          this.LineRevenue.series = response.data[1];
          this.PiePaymentByFrequency.series[0].data = response.data[2];
          this.PiePaymentByValue.series[0].data = response.data[3];

          // JSON.parse(response.data).forEach((element) => {
          //   console.log(element);
          // });
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
  created() {
    this.loadBarLineGeneralReport();
    this.loadBarClientData();
    this.loadLineExpensesData();
    this.loadLineRevenueData();
  },
};
</script>

<style scoped>
tr.v-data-table__selected {
  background: #7d92f5 !important;
}
</style>
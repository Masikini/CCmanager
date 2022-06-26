<template>
  <div class="pa-5">
    <v-container class="pa-1">
      <v-row>
        <!-- <v-col sm="3">
          <v-card max-width="400" max-height="350">
            <v-card-text class="text-center">
              <v-row>
                <v-col cols="12">
                  <span class="headline">Leads</span><br />
                  <span class="sub-headline">(This week)</span>
                </v-col>
                <v-col sm="12">
                  <v-progress-circular
                    :rotate="360"
                    :size="180"
                    :width="15"
                    :value="60"
                    color="teal"
                  >
                    <v-row>
                      <v-col sm="12" class="justify-center my-2">
                        <v-layout row justify-center align-center>
                          <v-icon style="font-size: 25pt">mdi-target</v-icon>

                          <span class="headline ml-2">{{ 50 }}</span>
                        </v-layout>
                      </v-col>

                      <v-col sm="12" class="justify-center">
                        <v-layout row justify-center align-center>
                          <v-icon style="font-size: 25pt"
                            >mdi-checkbox-marked-circle</v-icon
                          >

                          <span class="headline ml-2">{{ 20 }}</span>
                        </v-layout>
                      </v-col>
                    </v-row>
                  </v-progress-circular>
                </v-col>
                <v-col sm="12">
                  <v-layout column justify-left align-center class="mt-2">
                  <v-layout row justify-center align-center>
                    <span style="font-size: 20px">Sales:</span>

                    <span style="font-size: 20px" class="ml-10">{{ 50 }}</span>
                  </v-layout>
                  <v-layout row justify-center align-center class="mt-5">
                    <span style="font-size: 20px">Subscribers:</span>

                    <span style="font-size: 20px" class="ml-2">{{ 50 }}</span>
                  </v-layout>
                  </v-layout>
                </v-col>
              </v-row></v-card-text
            >
          </v-card>
        </v-col> -->
        <v-col sm="12" cols="12">
          <v-card max-width="800">
            <v-chart class="chart" :option="optionBar" />
          </v-card>
        </v-col>

        <!-- <v-col sm="4">
          <v-card max-width="500">
            <v-chart class="chart" :option="optionPie" /> </v-card
        ></v-col> -->
        <v-col cols="12" sm="12"> </v-col>
      </v-row>
    </v-container>
  </div>
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
      optionPie: {
        title: {
          text: "Service Distribution",
          left: "center",
        },
        tooltip: {
          trigger: "item",
          formatter: "{a} <br/>{b} : {c} ({d}%)",
        },
        legend: {
          orient: "vertical",
          left: "right",
          padding: [30, 5, 0, 0], //top-right-bottom-left
          data: ["CompCare", "Training", "Consultancy", "ManagedIT"],
        },
        series: [
          {
            name: "Service Distribution",
            type: "pie",
            radius: "55%",
            center: ["50%", "60%"],
            data: [
              { value: 335, name: "CompCare" },
              { value: 310, name: "Training" },
              { value: 234, name: "Consultancy" },
              { value: 135, name: "ManagedIT" },
            ],
            emphasis: {
              itemStyle: {
                shadowBlur: 10,
                shadowOffsetX: 0,
                shadowColor: "rgba(0, 0, 0, 0.5)",
              },
            },
            itemStyle: {
              normal: {
                label: {
                  show: false,
                },
                labelLine: {
                  show: false,
                },
              },
            },
          },
        ],
      },
      optionBar: {
        legend: {},
        tooltip: {},
        dataset: {
        //   source: [
        //  ["product", "TotalTickets", "Opened"],
        //     ["2021", 20, 2],
        //     ["2022", 8, 5],
        //   ],
          source: [],
        },
        xAxis: { type: "category" },
        yAxis: {},
        // Declare several bar series, each will be mapped
        // to a column of dataset.source by default.
        // series: [{ type: "bar" }, { type: "bar" }, { type: "bar" }],
        series: [{ type: "bar" }, { type: "bar" }, { type: "bar" },{ type: "bar" }],
      },


      
    };
  },
  methods: {
    loadCharts() {
      axios
        .get("api/stat/tickets")
        .then((response) => {
          console.log(response.data[0]);
          this.optionBar.dataset.source = response.data[0];

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
    this.loadCharts();
  },
  mounted() {},
};
</script>

<style scoped>
.chart {
  height: 350px;
}
</style>
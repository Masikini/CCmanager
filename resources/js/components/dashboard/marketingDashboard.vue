<template>

  <v-container class="pa-1">

    <v-slide-group v-model="model" class="pa-4" active-class="success" show-arrows>

      <v-slide-item v-for="(item, index) in $store.state.adminPanel.Campaigns" :key="item.id">
        <v-card elevation="3" class="mr-3" outlined @click="viewCampaign(index)">
          <v-card-title>#{{ item.title }}</v-card-title>
          <v-card-text justify-center align-center>
            <v-layout column align-start>
              <!-- <span class="justify-start headline"> Revenue </span> -->
              <span class="justify-start subheadline">
                <v-icon color="grey" left> mdi-target </v-icon>:
                {{ item.target }}
              </span>
              <!-- <span :v-if="campaignScore(item.title)" class="justify-start subheadline">
                <v-icon color="grey" left> mdi-check-circle </v-icon>:
                {{ $store.state.adminPanel.CampaignScore }}
              </span> -->
              <span class="mt-2">
                <v-icon color="grey" left> mdi-timer-sand </v-icon>:
                {{ duration(item.end) * -1 }} Days togo!
              </span>
            </v-layout>

          </v-card-text>
        </v-card>
      </v-slide-item>
    </v-slide-group>

    <v-dialog v-model="campaignDialog" content-class="elevation-0">
      <v-card max-width="500">
        <!-- <v-chart class="chart" :option="optionBar" /> -->
        <v-card-title>
          {{ selectedCampaign.title }} Campaign
        </v-card-title>

        <v-card-text>
          <v-layout row align-center justify-center class="mt-2">
            <!-- <span class="justify-start headline"> Revenue </span> -->
            <v-chip class="mr-1">
              <span class="justify-start subheadline">

                <v-icon color="grey" left> mdi-target </v-icon>:
                {{ selectedCampaign.target }}
              </span>
            </v-chip>
            <v-chip class="mr-1">
              <span :v-if="campaignScore(selectedCampaign.title)" class="justify-start subheadline">
                <v-icon color="grey" left> mdi-check-circle </v-icon>:
                {{ $store.state.adminPanel.CampaignScore }}
              </span>
            </v-chip>
            <v-chip class="mr-1">
              <span class="mt-2">
                <v-icon color="grey" left> mdi-timer-sand </v-icon>:
                {{ duration(selectedCampaign.end) * -1 }} Days togo!
              </span>
            </v-chip>
          </v-layout>
          <v-divider></v-divider>
          <p class="font-italic">
           {{selectedCampaign.description}}
          </p>
          <v-list class="transparent">
            <!-- <v-col cols="12" sm="12">
              <v-layout row>
                <span>{{ item.issuer }}</span>
                <span>{{ item.total }}</span>
              </v-layout>
            </v-col> -->
            <v-list-item>
              <v-list-item-subtitle>
                <strong>Name</strong>
              </v-list-item-subtitle>
              <v-list-item-subtitle class="text-right">
                <strong>Score</strong>
              </v-list-item-subtitle>
            </v-list-item>
            <v-list-item v-for="(item, index) in $store.state.adminPanel.Campaigners" :key="item.id">
              <v-list-item-title>{{ item.issuer }}</v-list-item-title>

              <!-- <v-list-item-icon>
                <v-icon>{{ item.icon }}</v-icon>
              </v-list-item-icon> -->

              <v-list-item-subtitle class="text-right">
                <v-chip label>
                  {{ item.total }}
                </v-chip>

              </v-list-item-subtitle>
            </v-list-item>
          </v-list>
        </v-card-text>

      </v-card>
    </v-dialog>
  </v-container>


</template>

<script>
import moment from "moment";

export default {

  data() {

    return {
      model: null,
      selectedCampaign: "",
      campaignDialog: false,
      totalScores: 0,
    };
  },
  methods: {
    duration(end) {
      console.log(end);
      var enddate = moment(end, "YYYY-MM-DD");

      var today = moment();
      return today.diff(enddate, "days");
      // var enddate= moment(end);
      // return moment.duration(today.diff(end)).asDays();

      // return moment().endOf('day').fromNow(dateoftoday);
    },

    campaignScore(title) {
      axios.get('api/campaignScore/' + title).then((response) => {
        console.log(response.data)

        this.$store.commit('AddCampaignScore', response.data);
        return true;
      }).catch((err) => {
        console.log(err);

        return false;
      })
    },
    viewCampaign(id) {
      this.selectedCampaign = this.$store.state.adminPanel.Campaigns[id];

      if (this.selectedCampaign) {
        this.campaignDialog = true;
        console.log(this.selectedCampaign);

        axios.get('api/campaigners/' + this.selectedCampaign.title).then((response) => {
          console.log(response.data)
          this.$store.commit('AddCampaigners', response.data["campaigners"]);
          this.totalScores = response.data[1]["score"];
        }).catch((err) => { console.log(err); })

      }

    },


    getallCampaigns() {
      axios
        .get("api/campaigns/")
        .then((response) => {
          this.$store.commit('AddCampaigns', response.data);
        })
        .catch((error) => {
          console.log(error);
        });
    },


  },
  created() {
    this.getallCampaigns();
    this.totalScores = 0;
  },
  computed: {
    getPercentage() {
      return (this.selectedCampaign.acquired / this.selectedCampaign.target) * 100;
    }
  }
};
</script>

<style scoped>
.chart {
  height: 350px;
}
</style>
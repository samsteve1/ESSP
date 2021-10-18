<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-10">
        <div class="card">
          <div class="card-header"><h4>Campaigns</h4></div>

          <div class="card-body">
            <span v-if="!isReady">Loading...</span>

            <div v-if="isReady">
              <span v-if="hasError" class="text-danger"
                >Failed to load advertising campaigns.</span
              >
              <div class="my-2 mx-">
                <a class="btn btn-primary btn-sm" href="campaigns/create">
                  <i class="fa fa-plus"></i> New campaign
                </a>
              </div>
              <div class="table-responsive-sm">
                <table v-if="campaigns.length" class="table">
                  <thead class="thead-dark">
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Name</th>
                      <th scope="col">Daily Budget</th>
                      <th scope="col">Total Budget</th>
                      <th scope="col">From</th>
                      <th scope="col">To</th>
                      <th scope="col"></th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr v-for="(campaign, index) in campaigns" :key="index">
                      <th scope="row">{{ index + 1 }}</th>
                      <td>{{ campaign.name }}</td>
                      <td>{{ campaign.daily_budget_formatted }}</td>
                      <td>{{ campaign.total_budget_formatted }}</td>
                      <td>{{ campaign.from }}</td>
                      <td>{{ campaign.to }}</td>
                      <td>
                        <button
                          class="btn btn-secondary btn-sm"
                          @click="viewCreatives(campaign.creatives)"
                        >
                          <span class="text-sm">View creatives</span>
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <div v-else>
                  <p>
                    No campaigns added yet. Click the "New campaign" button to
                    add one.
                  </p>
                </div>
              </div>
              <creative
                v-if="showCreatives"
                :creatives="creatives"
                @close="showCreatives = false"
              ></creative>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import Creative from "./Creative.vue";
export default {
  components: { Creative },
  data() {
    return {
      campaigns: [],
      creatives: [],
      isReady: false,
      hasError: false,
      showCreatives: false,
    };
  },
  async mounted() {
    await this.getAllCampaigns();
  },
  methods: {
    async getAllCampaigns() {
      let campaigns = axios
        .get("api/campaigns")
        .then((response) => {
          this.campaigns = response.data;
          this.isReady = true;
        })
        .catch((error) => {
          this.isReady = true;
          this.hasError = true;
          console.log(error);
        });
    },
    viewCreatives(creatives) {
      this.showCreatives = true;
      this.creatives = creatives;
    },
  },
};
</script>

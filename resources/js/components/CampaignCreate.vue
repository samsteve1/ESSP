<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-10">
        <div class="card">
          <div class="card-header"><h4>Create campaign</h4></div>
          <div class="card-body">
            <div class="row">
              <div class="col">
                <a href="/" class="btn btn-primary btn-sm my-2"
                  ><i class="fa fa-arrow-left"></i> View all campaigns</a
                >
              </div>
            </div>
            <form @submit.prevent="submit">
              <span class="text-danger my-1" v-if="errors.store">{{
                errors.store
              }}</span>

              <span class="text-success my-1" v-if="successNotification">{{
                successNotification
              }}</span>

              <div class="form-group">
                <label for="name">Name</label>
                <input
                  type="text"
                  class="form-control"
                  id="name"
                  aria-describedby="name"
                  placeholder="Enter campaign name"
                  required
                  v-model="campaign.name"
                />
              </div>
              <div class="form-group">
                <label for="from">Start date</label>
                <input
                  type="date"
                  class="form-control"
                  name="from"
                  id="from"
                  placeholder="From"
                  required
                  v-model="campaign.startDate"
                />
              </div>

              <div class="form-group">
                <label for="to">End date</label>
                <input
                  type="date"
                  class="form-control"
                  name="to"
                  id="to"
                  placeholder="To"
                  required
                  v-model="campaign.endDate"
                />
              </div>

              <div class="form-group">
                <label for="daily_budget">Daily budget</label>
                <input
                  type="number"
                  step="0.01"
                  class="form-control"
                  name="daily_budget"
                  id="daily_budget"
                  placeholder="Enter daily budget e.g 10.50"
                  v-model="campaign.dailyBudget"
                />
              </div>
              <div class="form-group">
                <label for="total_budget">Total budget</label>
                <input
                  type="number"
                  step="0.01"
                  class="form-control"
                  name="total_budget"
                  id="total_budget"
                  placeholder="Enter total budget e.g. 20.30"
                  v-model="campaign.totalBudget"
                />
              </div>
              <div class="form-group">
                <label for="creative_uploads">Creative uploads</label>
                <input
                  type="file"
                  class="form-control"
                  name="creative_uploads[]"
                  id="creative_uploads"
                  placeholder="Choose creative uploads"
                  multiple
                  required
                  @change="creativeUploadAdded($event)"
                />
                <small v-if="errors.creativeUpload" class="text-danger">{{
                  errors.creativeUpload
                }}</small>
              </div>

              <button
                type="submit"
                class="btn"
                :class="{
                  'btn-primary': !submitting,
                  'btn-secondary': submitting,
                }"
                :disabled="submitting"
              >
                {{ submitting ? "Submitting" : "Submit" }}
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import axios from "axios";
export default {
  data() {
    return {
      campaign: {
        name: null,
        startDate: null,
        endDate: null,
        dailyBudget: null,
        totalBudget: null,
        creativeUploads: [],
      },
      submitting: false,
      errors: { creativeUpload: null, store: null },
      successNotification: null,
    };
  },
  methods: {
    submit() {
      if (!this.campaign.creativeUploads.length) {
        this.errors.creativeUpload =
          "You must upload at least one creative banner.";
        return false;
      }

      this.submitting = true;
      const formData = new FormData();
      formData.append("name", this.campaign.name);
      formData.append("daily_budget", parseFloat(this.campaign.dailyBudget));
      formData.append("total_budget", parseFloat(this.campaign.totalBudget));
      formData.append("to", this.campaign.endDate);
      formData.append("from", this.campaign.startDate);
      for (let i = 0; i < this.campaign.creativeUploads.length; i++) {
        formData.append(
          "creatives[" + i + "]",
          this.campaign.creativeUploads[i]
        );
      }
      axios
        .post("/api/campaigns", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then((response) => {
          this.errors.submit = null;
          this.submitting = false;
          this.successNotification = "Advertisement campaign saved.";
          this.resetCampaignForm();
        })
        .catch(() => {
          this.errors.store =
            "Failed to save advertisement campaign. Please try again.";
          this.submitting = false;
        });
    },
    creativeUploadAdded(event) {
      let files = event.target.files;
      for (let i = 0; i < files.length; i++) {
        if (
          files[i].type === "image/png" ||
          files[i].type === "image/jpeg" ||
          files[i].type === "image/jpg"
        ) {
          this.campaign.creativeUploads.push(files[i]);
          this.errors.creativeUpload = null;
        } else {
          this.errors.creativeUpload =
            " Uploaded image(s) must be image format.";
        }
      }
    },
    resetCampaignForm() {
      this.campaign.name = null;
      this.campaign.startDate = null;
      this.campaign.endDate = null;
      this.campaign.dailyBudget = null;
      this.campaign.totalBudget = null;
      this.campaign.creativeUploads.length = 0;
    },
  },
};
</script>
<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-10">
        <div class="card">
          <div class="card-header"><h4>Edit campaign</h4></div>
          <div class="card-body">
            <div class="row">
              <div class="col">
                <a href="/" class="btn btn-primary btn-sm my-2"
                  ><i class="fa fa-arrow-left"></i> View all campaigns</a
                >
              </div>
            </div>
            <form @submit.prevent="update">
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
                {{ submitting ? "Updating" : "Update" }}
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      errors: {},
      submitting: false,
      campaign: {
        name: null,
        startDate: null,
        endDate: null,
        dailyBudget: null,
        totalBudget: null,
        creativeUploads: [],
      },
      errors: { creativeUpload: null, store: null },
      successNotification: null,
    };
  },
  mounted() {
    this.campaign.name = this.campaignResource.name;
    this.campaign.startDate = this.campaignResource.from;
    this.campaign.endDate = this.campaignResource.to;
    this.campaign.dailyBudget = this.campaignResource.daily_budget_amount;
    this.campaign.totalBudget = this.campaignResource.total_budget_amount;
  },
  props: {
    campaignResource: {
      type: Object,
      required: true,
    },
  },
  methods: {
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
    update() {
      this.submitting = true;
      const formData = new FormData();
      formData.append("name", this.campaign.name);
      formData.append("daily_budget", parseFloat(this.campaign.dailyBudget));
      formData.append("total_budget", parseFloat(this.campaign.totalBudget));
      formData.append("to", this.campaign.endDate);
      formData.append("from", this.campaign.startDate);
      formData.append("_method", "PATCH");
      for (let i = 0; i < this.campaign.creativeUploads.length; i++) {
        formData.append(
          "creatives[" + i + "]",
          this.campaign.creativeUploads[i]
        );
      }

      axios
        .post("/api/campaigns/" + this.campaignResource.id, formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then((response) => {
          this.errors.store = null;
          this.submitting = false;
          this.successNotification = "Advertisement campaign updated.";
        })
        .catch(() => {
          this.errors.store =
            "Failed to save advertisement campaign. Please try again.";
          this.submitting = false;
        });
    },
  },
};
</script>
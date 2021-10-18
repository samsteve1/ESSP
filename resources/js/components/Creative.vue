<template>
  <div>
    <transition name="modal">
      <div class="modal-mask">
        <div class="modal-wrapper">
          <div class="modal-container">
            <div class="modal-header">
              <slot name="header"> Creative uploads </slot>
            </div>
            <div class="modal-body">
              <slot name="body">
                <div>
                  <div class="row">
                    <div
                      class="col-4"
                      v-for="(creative, index) in creatives"
                      :key="index"
                    >
                      <img :src="creative.path" class="img-fluid" />
                    </div>
                  </div>
                </div>
              </slot>
            </div>
            <div class="modal-footer">
              <slot name="footer">
                <button
                  class="btn btn-secondary btn-sm"
                  @click="$emit('close')"
                >
                  Close
                </button>
              </slot>
            </div>
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>
<script>
export default {
  data() {
    return {};
  },
  mounted() {},
  props: {
    creatives: {
      type: Array,
      required: true,
    },
  },
};
</script>
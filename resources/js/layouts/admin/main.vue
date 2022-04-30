<script>
import Vertical from "./vertical";
import Horizontal from "./horizontal";

export default {
  props: {
     access_token: {
       type: String,
       required: true
     }
  },
  components: { Vertical, Horizontal },
  data() {
    return {};
  },
  computed: {
    layoutType() {
        return this.$root.layout?.type;
    }
  },
  methods: {},
  mounted() {
    
    // document.querySelector("html").setAttribute('dir', 'rtl');
  }
};
</script>

<template>
  <div>
    <Vertical  :access_token="access_token" v-if="layoutType === 'vertical'">
      <slot />
    </Vertical>

    <Horizontal v-if="layoutType === 'horizontal'">
      <slot />
    </Horizontal>
  </div>
</template>

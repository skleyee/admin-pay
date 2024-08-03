<template>
  <div id="app">
    <header-block></header-block>
    <div class="container">
      <router-view />
    </div>
  </div>
</template>

<script>
import HeaderBlock from "@/components/HeaderBlock";

export default {
  name: "App",

  components: {
    HeaderBlock
  },

  created() {},
};
</script>

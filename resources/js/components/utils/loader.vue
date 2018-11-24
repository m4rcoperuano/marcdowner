<template>
  <div id="loading-container">
    <img src="/loader.gif" style="width:300px;"/>
  </div>
</template>

<script>
    export default {

    }
</script>

<style scoped>
    #loading-container {
      position:absolute;
      width:100%;
      height:100%;
      z-index: 50000;
      display:flex;
      justify-content: center;
      align-items: center;
      background-color:white;
      top:0;
      left:0;
    }
</style>
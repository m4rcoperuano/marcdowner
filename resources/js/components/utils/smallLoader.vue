<template>
    <div id="loading-container">
        <img src="/img/small-loader.gif" />
    </div>
</template>

<script>
    export default {

    };
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
    }
</style>
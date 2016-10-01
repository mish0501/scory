<template>
  <div>
    <h1>TestPage</h1>
  </div>
</template>

<script>
  export default {
    ready(){
      this.on('questions', function(data){
        console.log(data);
      })
    }
  }
</script>

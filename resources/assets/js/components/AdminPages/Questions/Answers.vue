<template lang="html">
  <div>
    <div v-for="answer, index in answers">
      <div class='form-group' v-if="index == 0">
        <label class='col-md-2 control-label'>Отговори</label>
        <div class='col-md-5'>
          <input class='form-control' placeholder='Името на отговора' type='text' v-model="answer.name">
        </div>
        <div class='col-md-5 col-sm-1 col-xs-1'>
          <div class="checkmark checked">
            <label>
              <i class="icon-ok"></i>
              <input type="checkbox" class="hide" value="0" name='correct[]'>
            </label>
          </div>
        </div>
      </div>
      <div class='form-group' v-else>
        <div class='col-md-5 col-md-offset-2'>
          <input class='form-control' placeholder='Името на отговора' type='text' v-model="answer.name">
        </div>
        <div class='col-md-5 col-sm-1 col-xs-1'>
          <div class="checkmark">
            <label>
              <i class="icon-ok"></i>
              <input type="checkbox" class="hide" value="0" name='correct[]'>
            </label>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: [
    'answers'
  ]
}
</script>

<style lang="css">
  .checkmark{
    color: #eee;
    background-color: #ddd;
    border-radius: 50%;
    border: #ddd 5px solid;
    width: 28px;
    height: 28px;
    position: absolute;
    text-align: center;
    line-height: 19px;
    font-size: 14pt;
    margin-left: -20px;
    margin-top: 2px;
    cursor: pointer;
  }

  .checkmark label{
    cursor: pointer;
  }

  .checkmark.checked{
    color: #fff;
    background-color: #5daf2b;
    border: #5daf2b 5px solid;
  }
</style>

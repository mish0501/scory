(function() {
  var submit = $('button[type=submit]');
  $('.radio-input').on('click', function(){
    if(submit.is(':disabled')){
        submit.attr('disabled', false);
    }

    if(this.checked) {
      $('.checked').removeClass('checked');
      $(this).parent().addClass('checked');
    }
  });
  $('.checkbox-input').on('click', function(){
    if(submit.is(':disabled')){
        submit.attr('disabled', false);
    }
    
    if(this.checked) {
      $(this).parent().addClass('checked');
    }else{
      $(this).parent().removeClass('checked');
    }
  });
}());

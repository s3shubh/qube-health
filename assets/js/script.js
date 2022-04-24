$(document).ready(function(){
  var maxField = 10;
  var addButton = $('.add_button');
  var wrapper = $('.field_wrapper');
  var fieldHTML =' <table><tr><td style="padding: 10px 10px 10px 10px;"><input type="text" class="tmp" name="field_name[]" value="" /></td><td><a href="javascript:void(0);" class="remove_button btn btn-danger" title="Add field">Remove</a></td></tr></table>'
  var x = 1;
  $(addButton).click(function(){
      if(x < maxField){
          x++;
          $(wrapper).append(fieldHTML);
      }
  });
  $(wrapper).on('click', '.remove_button', function(e){
      e.preventDefault();
      $(this).closest('tr').remove();
      x--;
  });
});
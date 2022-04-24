$('#phone').on('keypress', function(e) {
    var $this = $(this);
    var regex = new RegExp("^[0-9\b]+$");
    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    // for 10 digit number only
    if ($this.val().length > 9) {
        e.preventDefault();
        return false;
    }
    if ($this.val().length === 9) {
        $this.removeClass('is-invalid');
        $this.addClass('is-valid');
        $('#send_opt').prop("disabled", false);
    }else{
        //alert();
        $('#send_opt').prop("disabled", true);
    }
    if (e.charCode < 54 && e.charCode > 47) {
        if ($this.val().length == 0) {
            e.preventDefault();
            return false;
        } else {
            return true;
        }

    }
    if (regex.test(str)) {
        return true;
    }
    e.preventDefault();
    return false;
});

$('#phone').on('blur', function(e) {
    var $this = $(this);
    if ($this.val().length === 10) {
        $this.removeClass('is-invalid');
        $this.addClass('is-valid');
        $('#send_opt').prop("disabled", false);
    }else{
        $this.removeClass('is-valid');
        $this.addClass('is-invalid');
        $('#send_opt').prop("disabled", true);
        e.preventDefault();
        return false;
    }
});

$('#phone').on('keyup', function(e) {
    var $this = $(this);
    if ($this.val().length === 10) {
        $this.addClass('is-valid');
        $('#send_opt').prop("disabled", false);
    }else{
        $this.removeClass('is-valid');
        $('#send_opt').prop("disabled", true);
        e.preventDefault();
        return false;
    }
});
let digitValidate = function(ele){
    ele.value = ele.value.replace(/[^0-9]/g,'');
  }
  
  let tabChange = function(val){
      let ele = document.querySelectorAll('.otp');
      if(ele[val-1].value != ''){
        ele[val].focus()
      }else if(ele[val-1].value == ''){
        ele[val-2].focus()
      }   
   }
  
  
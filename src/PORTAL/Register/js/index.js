var data = {};
data.fest_id = document.getElementById('fest_id');
data.college = document.getElementById('college');
data.name = document.getElementById('name');
data.email = document.getElementById('email');
data.phone = document.getElementById('phone');
data.accom = document.getElementById('accom');
data.reg = document.getElementById('reg');

var clearData = function(){
  data.fest_id.value="";
  data.college.value="";
  data.name.value="";
  data.email.value="";
  data.phone.value="";
  data.accom.checked=false;
  data.reg.checked=false;
}

var validateData = function(){
  var formdata = {};
  formdata.fest_id=data.fest_id.value;
  formdata.name=data.name.value;
  formdata.college=data.college.value;
  formdata.phone=data.phone.value.match(/\d{10}/g);
  formdata.email=data.email.value.match(/.+[@].+\..+/g);
  if(!formdata.fest_id) {
    toastr.error('Please use alphabets and numbers.', 'Participant ID Invalid');
    return false;
  }
  if(!formdata.name) {
    toastr.error('Please use alphabets and albphabets only.', 'Participant Name Invalid');
    return false;
  }
  if(!formdata.college) {
    toastr.error('Please use alphabets and numbers.', 'College Name Invalid');
    return false;
  }
  if(!formdata.phone) {
    toastr.error('Please enter a 10 digit number.', 'Phone Invalid');
    return false;
  }
  if(!formdata.email) {
    toastr.error('Please format as user@hostname.something', 'Email Invalid');
    return false;
  }
  toastr.success('You made it.','WTF How?');
  return true;
}

var register = function(){
  data.fest_id.value=data.fest_id.value.toUpperCase();
  var form = document.getElementById('my-fucking-form');
  if(validateData()) {
    form.submit();
    form.reset();
    return false;
  }
}

window.onload=function(e){
  clearData();
  toastr.options = {
    "closeButton": false,
    "debug": false,
    "newestOnTop": true,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "100",
    "timeOut": "7000",
    "extendedTimeOut": "0",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
  }
}
var data = {};
data.fest_id = document.getElementById('fest_id');
data.college = document.getElementById('college');
data.name = document.getElementById('name');
data.email = document.getElementById('email');
data.phone = document.getElementById('phone');
data.accom = document.getElementById('accom');
data.reg = document.getElementById('reg');

function clearData(){
  data.fest_id.value="";
  data.college.value="";
  data.name.value="";
  data.email.value="";
  data.phone.value="";
  data.accom.checked=false;
  data.reg.checked=false;
  data.fest_id.removeAttribute("disabled");;
  data.college.removeAttribute("disabled");;
  data.name.removeAttribute("disabled");;
  data.email.removeAttribute("disabled");;
  data.phone.removeAttribute("disabled");;
}

function validateData(){
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
  return true;
}

function submitForm(){
  console.log("Me was called.");
  var url = "register.php/?";
  url += "fest_id="+data.fest_id.value;
  url += "&college="+data.college.value;
  url += "&name="+data.name.value;
  url += "&email="+data.email.value;
  url += "&phone="+data.phone.value;
  url += "&accom="+data.accom.checked;
  url += "&reg="+data.reg.checked;
  var request = new XMLHttpRequest();
  request.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      var res = JSON.parse(this.responseText);
      console.log(this.responseText);
      swal(res.title, res.message, res.type);
    }
  };
  request.open("GET", url, true);
  request.send();
}

function register(){
  data.fest_id.value=data.fest_id.value.toUpperCase();
  var form = document.getElementById('my-fucking-form');
  if(validateData()) {
    if(data.accom.checked||data.reg.checked){
      swal({
        title: "Master Password",
        text: "Please enter master password for alloting Free Services.",
        type: "input",
        inputType: "password",
        showCancelButton: true,
        closeOnConfirm: false,
        animation: "slide-from-top",
        inputPlaceholder: "Master Password",
        showLoaderOnConfirm: true,
      },
      function(inputValue){
        if (inputValue === false) return false;
        else if (inputValue === "") {
          swal.showInputError("You need to write something!");
          return false;
        }
        var request = new XMLHttpRequest();
        request.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            var res = JSON.parse(this.responseText);
            if(res.message){
              submitForm();
            }
            else{
              swal.showInputError("Invalid Master Password");
            }
          }
        };
        request.open("GET", "master.php?action=masterpassword&password="+inputValue, true);
        request.send();
      });
    }
    else{
      submitForm();
    }
  }
}

function checkOnline(){
  swal({
    title: "Atmos ID",
    text: "Please enter the Atmos ID",
    type: "input",
    showCancelButton: true,
    closeOnConfirm: false,
    animation: "slide-from-top",
    inputPlaceholder: "ATMH***",
    showLoaderOnConfirm: true,
  },
  function(inputValue){
    var param = false;
    if (inputValue === false) return false;
    else if (inputValue === "") {
      swal.showInputError("You need to write something!");
      return false;
    }
    inputValue = inputValue.toUpperCase();
    if (inputValue.startsWith('ATMH')){
      param = "online_register";
    }
    if (inputValue.startsWith('ATMH_CA')){
      param = "online_ca_register";
    }
    if(!param){
      swal.showInputError("Invalid Atmos ID format.");
      return false;
    }
    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        var res = JSON.parse(this.responseText);
        if(res.status==300){
          swal.showInputError("ATMOS ID not found.");
          return false;
        }
        if(res.status==200){
          data.fest_id.value=inputValue;
          data.college.value=res.college;
          data.name.value=res.name;
          data.email.value=res.email;
          data.phone.value=res.phone;
          data.fest_id.disabled=true;
          data.college.disabled=true;
          data.name.disabled=true;
          data.email.disabled=true;
          data.phone.disabled=true;
          swal("ATMOS ID Found.", "User Details Have Been Filled.", "success");
        }
      }
    };
    var formdatatosend = new FormData();
    formdatatosend.append(param, '1');
    formdatatosend.append('atmos_id', inputValue);
    request.open("POST", "http://bits-atmos.org/App/doshReg.php", true);
    request.send(formdatatosend);
  });
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
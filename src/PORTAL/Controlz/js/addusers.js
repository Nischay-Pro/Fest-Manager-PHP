var currentworkshop = {};

$(document).ready(function(){
  updateData(document.getElementById('sel1'));
  $('#datetimepicker').click(function(){
    $(this).datetimepicker({
      lang:'en',
      minDate:0,
      maxDate:'15.10.2016',
      formatDate:'d.m.Y',
      allowTimes:['09:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00','18:00','19:00','20:00']
    });
  });
});

function updateData(select){
  var workshopobject = select.options[select.selectedIndex];
  var workshopid = workshopobject.value;
  var request = new XMLHttpRequest();
  request.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      var dat = JSON.parse(this.responseText);
      //var dat = this.responseText;
      dat = dat[0];
      console.log(dat);
      currentworkshop = dat;
      document.getElementById('bitsian-holder').value = currentworkshop.max_count_bits - currentworkshop.current_count_bits;
      document.getElementById('outsider-holder').value = currentworkshop.max_count_general - currentworkshop.current_count_general;
    }
  };
  request.open("GET", "workshopcall.php?action=getDataWorkshop&id="+workshopid, true);
  request.send();
}

function verifyPayment(){
  swal({
    title: 'Enter Email',
    text: 'You can apply only one coupon.',
    type: 'input',
    inputPlaceholder: 'Type email for payment confirmation.',
    showCancelButton: true,
    closeOnConfirm: false,
    disableButtonsOnConfirm: true,
    confirmLoadingButtonColor: '#DD6B55'
  }, function(inputValue){
    if (inputValue === false) return false;
    if (inputValue === "") {
      swal.showInputError("You need to write something!");
      return false;
    }
    var select = document.getElementById('sel1');
    var workshopobject = select.options[select.selectedIndex];
    var workshopname = workshopobject.innerHTML;
    var email = inputValue;
    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        var dat = JSON.parse(this.responseText);
        var paid = dat[0].paid == "false"? false : true;
        if(!paid) {
          swal("Good job!", "You have not paid your shit.", "error")
        }
        if(paid){
          verifyUser();
        }
      }
    };
    request.open("GET", "workshopcall.php?action=checkPaid&work_name="+workshopname+"&email="+email, true);
    request.send();
  });
}

function verifyUser(){
  swal({
    title: 'Enter Email',
    text: 'You can apply only one coupon.',
    type: 'input',
    inputPlaceholder: 'Type email for payment confirmation.',
    showCancelButton: true,
    closeOnConfirm: false,
    disableButtonsOnConfirm: true,
    confirmLoadingButtonColor: '#DD6B55'
  }, function(inputValue){
    if (inputValue === false) return false;
    if (inputValue === "") {
      swal.showInputError("You need to write something!");
      return false;
    }
    var select = document.getElementById('sel1');
    var workshopobject = select.options[select.selectedIndex];
    var workshopname = workshopobject.innerHTML;
    var email = inputValue;
    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        var dat = JSON.parse(this.responseText);
        var paid = dat[0].paid == "false"? false : true;
        if(!paid) {
          swal("Good job!", "You have not paid your shit.", "error")
        }
        if(paid){

        }
      }
    };
    request.open("GET", "workshopcall.php?action=checkPaid&work_name="+workshopname+"&email="+email, true);
    request.send();
  });
}

function checkCoupon(){
  var user = document.getElementById('part-id').value;
  var costholder = document.getElementById('cost-holder');
  if(costholder.value>150){
    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        var dat = JSON.parse(this.responseText);
        if(dat.message){
          swal({
            title: 'Add Coupon?',
            text: 'You can apply only one coupon.',
            type: 'info',
            showCancelButton: true,
            closeOnConfirm: true,
            disableButtonsOnConfirm: true,
            confirmLoadingButtonColor: '#DD6B55'
          }, function(isConfirm){
            if(isConfirm){
              document.getElementById('coupon').value="Coupon Applied.";
              //TODO toastr
              document.getElementById('cost-holder').value-=150;
              document.getElementById('coupon-hidden').value=1;
              document.getElementById('coupon-button').disabled=true;
            }
            else{
              document.getElementById('coupon').value="Coupon Not Applied.";
              document.getElementById('coupon-hidden').value=0;
            }
          });
        }
        else{
            document.getElementById('coupon').value="Coupon Not Available.";
            document.getElementById('coupon-hidden').value=0;
        }
      }
    };
    request.open("GET", "workshopcall.php/?action=checkCouponUser&userid="+user, true);
    request.send();
  }
  else {
    document.getElementById('coupon').value="Coupon cannot be applied.";
    document.getElementById('coupon-hidden').value=0;
  }
  
}

var inputfield = document.getElementById('part-id');

inputfield.addEventListener("keyup", function(){
  var partid = inputfield.value;
  var button = document.getElementById('submit-button');
  var partidval = partid.match(/[fhFH](20)\d{5}/g);
  var valid = false;
  var outsider = true;
  if (partidval != null && partid.length==8){
    document.getElementById('coupon-button').disabled = false;
    outsider = false;
    valid = true;
  }
  if(partid.startsWith('ATMH')){
    document.getElementById('coupon-button').disabled = true;
    outsider = true;
    valid = true;
  }
  if(partid.length == 0){
    inputfield.style.background = "#ffffff";
    document.getElementById('cost-holder').value=0;
    return;
  }
  if(!valid){
    inputfield.style.background = "#ffaaaa";
    button.disabled = true;
    document.getElementById('cost-holder').value=0;
    return;
  }
  button.disabled = false;
  var seats = outsider? document.getElementById('outsider-holder').value : document.getElementById('bitsian-holder').value;
  var cost = outsider? currentworkshop.cost_general : currentworkshop.cost_bits;
  if(seats == 0){
    button.disabled = true;
    inputfield.style.background = "#eeee55";
    return;
  }
  document.getElementById('outsider').value=outsider?1:0;
  document.getElementById('cost-holder').value=cost;
  if(outsider){
    inputfield.style.background = "#aaeebb";
    return;
  }
  if(!outsider){
    inputfield.style.background = "#aaccdd";
    return;
  }
}); 

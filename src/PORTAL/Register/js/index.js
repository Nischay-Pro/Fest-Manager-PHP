$(document).ready(function(){
      function ShowAndClear(data){
  alert(data);
  $('#valname').attr('value','');
  $('#valemail').attr('value','');
  $('#valpearl_id').attr('value','');
  $('#valcollege').attr('value','');
  $('#valphone').attr('value','');
  $('#name').val('');
  $('#email').val('');
  $('#pearl_id').val('');
  $('#college').val('');
  $('#phone').val('');
  $('.checked').hide();
    $('.getinfo').show();
}
  $('.checked').hide();
  $('.check_details').click(function(){
    var detail=$('#search_query').val();
    $.post('http://learnwebbing.hol.es/pearlreg/reg_16.php',{detail:detail},function(response,status){
      $.each(response , function (index, value) {
        if(index=='name'){
          $('#valname').attr('value',value);
        }
        else if(index=='email'){
          $('#valemail').attr('value',value);
        }
        else if(index=='college'){
          $('#valcollege').attr('value',value);
        }
        else if(index=='phone'){
          $('#valphone').attr('value',value);
        }
        });
      $('.getinfo').hide();
      $('.checked').show();
    },"json");
  });
  $('.registeronline').click(function(){
    // todo start work here
    var pearl_id=$('#valpearl_id').val();
    var email=$('#valemail').val();
    var college=$('#valcollege').val();
    var phone=$('#valphone').val();
    var name=$('#valname').val();
    var reg,accom;
    
            if($('.reg-o-checkbox').prop("checked") == true){
            reg=1;
            }
            else if($('.reg-o-checkbox').prop("checked") == false){
              reg=0;
            }
        
            if($('.accom-o-checkbox').prop("checked") == true){
            accom=1;
            }
            else if($('.accom-o-checkbox').prop("checked") == false){
              accom=0;
            }
      
    if(pearl_id==''||college==''||name==''||email==''||phone==''){
      alert('Please fill all fields');
    }
   
      else{
      $.post('register.php',{pearl_id:pearl_id,college:college,name:name,email:email,phone:phone,reg:reg,accom:accom},function(data,status){
    ShowAndClear(data);
      
    });
    }
    
  });
  $('.register').click(function(){
    // todo start work here
    var pearl_id=$('#pearl_id').val();
    var email=$('#email').val();
    var college=$('#college').val();
    var phone=$('#phone').val();
    var name=$('#name').val();
    var reg,accom;
    
            if($('.reg-checkbox').prop("checked") == true){
            reg=1;
            }
            else if($('.reg-checkbox').prop("checked") == false){
              reg=0;
            }
        
            if($('.accom-checkbox').prop("checked") == true){
            accom=1;
            }
            else if($('.accom-checkbox').prop("checked") == false){
              accom=0;
            }
      
    if(pearl_id==''||college==''||name==''||email==''||phone==''){
      alert('Please fill all fields');
    }
   
      else{
      $.post('register.php',{pearl_id:pearl_id,college:college,name:name,email:email,phone:phone,reg:reg,accom:accom},function(data,status){
    ShowAndClear(data);
      
    });
    }
    
  });
  
});
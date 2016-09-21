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
  if(data.fest_id.value)
}

window.onload=function(e){
  clearData();
}
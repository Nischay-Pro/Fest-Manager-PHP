
function valid() {
var output = true;
$(".accommodation-error").html('');
if($("#pid-field").css('display') != 'none') {
	if(!($("#pearlid").val())) {
		output = false;
		$("#pearlid-error").html("required");
	}
	else if(($("#pearlid").val().substring(0,3)!='PLH')||($("#pearlid").val().length!=7))
	{
		output = false;
		$("#pearlid-error").html("wrong format");
	}
}

if($("#acom-field").css('display') != 'none') {
	if(!($("#sdate").val())) {
		output = false;
		$("#sdate-error").html("required");
	}	
	if(!($("#edate").val())) {
		output = false;
		$("#edate-error").html("required");
	}	
	if(!($("#noofdays").val())) {
		output = false;
		$("#noofdays-error").html("required");
	}
	if(!($("#bhavan").val())) {
		output = false;
		$("#bhavan-error").html("required");
	}
}

return output;
}

function valid2() {
var output = true;
$(".accommodation-error").html('');
	if(!($("#sdate").val())) {
		output = false;
		$("#sdate-error").html("required");
	}	
	if(!($("#edate").val())) {
		output = false;
		$("#edate-error").html("required");
	}	
	if(!($("#noofdays").val())) {
		output = false;
		$("#noofdays-error").html("required");
	}
	if(!($("#bhavan").val())) {
		output = false;
		$("#bhavan-error").html("required");
	}
	if(!($("#name").val())) {
		output = false;
		$("#name-error").html("required");
	}
	if(!($("#festId").val())) {
		output = false;
		$("#id-error").html("required");
	}
	if(!($("#college").val())) {
		output = false;
		$("#clg-error").html("required");
	}
	if(!($("#email").val())) {
		output = false;
		$("#email-error").html("required");
	}


return output;
}
$(document).ready(function() {
	
$('#noregsubmit').click(function(){
var output = valid2();
		if(output) {
			$.ajax({
				type: 'POST',
		        url: 'validate_insert.php',
				data: 
				{
					festId:$("#festId").val(),
					sdate:$("#sdate").val(),
					edate:$("#edate").val(),
					noofdays:$("#noofdays").val(),
					bhavan:$("#bhavan").val(),
					phone:$("#phone").val(),
					email:$("#email").val(),
					college:$("#college").val(),
					name:$("#name").val()
				},
		        cache:false,
		        success:function(response,status){
		        	//console.log(response);
		        		$("#myModal .modal-body").html(response);
		        		if(response[0]=='Y')
		        			$("#myModal .modal-title").html("Accommodation Successfull!!");
		        		else
		        		{	
		        			$("#myModal .modal-title").html("Accommodation Failed!!");
		        			$("#myModal .modal-body").html("Try Again");
						}
						$("#myModal").modal("show",{backdrop: 'static'});
						$("#myModal").on('hide.bs.modal', function () {
					            $("#pid").click();	
					            window.open('index.php','_self');
					    });
						
					},
			});
		}
});

	$('#place').change(function(){
            if ($('#place').val()==1)
			{
				 $(".bhavanclass").hide();	
               $(".outsideclass").show();
              // $(".onampus").hide();
               console.log("off campus it is");
			}
			 else
			{  $(".outsideclass").hide();
			   $(".bhavanclass").show();
			}
});

  	$.ajaxSetup({ cache: false });
	$("#pearlid").val('PLH');
	$("#pearlid").focus();
	$("#pid").click(function(){ 
		var current = $(".highlight");
		var prev = $(".highlight").prev("li");
		if(prev.length>0) {

			$("#pearlid").val('PLH');
			$("#"+current.attr("id")+"-field").hide();
			$("#"+prev.attr("id")+"-field").show();
			$(".highlight").removeClass("highlight");
			prev.addClass("highlight");
			$("#acom").html("Accommodation");
			$("#beforeacom").show();
			$("#rearly").hide();
			//$("#pid").hide();
			$("#validate").show();
			$("#pearlid").focus();
		}
	});

$('#pearlid').keydown(function(event){    
    if(event.keyCode==13){
       $('#validate').trigger('click');
    }
});

	$("#validate").click(function(){
		var output = valid();
		var flag=0;
		if(output)
		{
			$.ajax({
            type: 'POST',
            url: 'fill.php',
			data: {pearlid:$("#pearlid").val()},
            dataType: 'json',
            cache:false,
            success: function(response,status){

					if(response!=-1)
					{	
						//console.log(response[3]);
						$("#acom").html("Refund");
						$("#beforeacom").hide();
						$("#usdate").val(response[0]);
						$("#uedate").val(response[1]);
						$("#oldnoofdays").val(response[2]);
						$("#newnoofdays").val("");
						$("#rearly").show();
						if(response[3]<=9000)
						{
							$("#ref").hide();
							$("#cancel").show();
						}
						else
						{
							$("#cancel").hide();
							$("#ref").show();
						}
					}	
            },
        });	
		$.ajax({
		type: 'POST',
        url: 'validate_insert.php',
		data: {pearlid:$("#pearlid").val()},
        cache:false,
        success: function(response,status){
		if(response[0]!='t')
		{
			output=false;
			$("#pearlid-error").html(response);
		}
		if(output) {
			$("#name").val(response.substring(1));
			$("#rname").val(response.substring(1));
			$("#sdate").val("");
			$("#edate").val("");
			$("#noofdays").val("");
			var current = $(".highlight");
			var next = $(".highlight").next("li");
			if(next.length>0) {
				$("#validate").hide();
				$("#"+current.attr("id")+"-field").hide();
				$("#"+next.attr("id")+"-field").show();
				$(".highlight").removeClass("highlight");
				next.addClass("highlight");
				$("#finish").show();
			}
		}
	},
		});
		}
	});

	$("#refund").click(function(){
			$.ajax({
		type: 'POST',
        url: 'confirm.php',
		data: {pearlid:$("#pearlid").val()},
        cache:false,
        success:function(response,status){
			$("#confirmModal .modal-title").html("Confirmation");
						$("#confirmModal .modal-body").html(response);
						$("#confirmModal").modal("show");
						$("#confirmModal").on('hide.bs.modal', function () {
						            $("#pid").click();
						            $("#pid").focus();	
						    });
		$("#yes").click(function() {

		$.ajax({
		type: 'POST',
        url: 'refund.php',
		data: {pearlid:$("#pearlid").val()},
        cache:false,
        success:function(response,status){
			$("#myModal .modal-body").html(response);
			if(response!='Use "Refund Early" Button')
			{
				if(response[0]=='R')
					$("#myModal .modal-title").html("Successfully Refunded!!");
				else if(response[0]=='A')
					$("#myModal .modal-title").html("Error!!");
				else if(response[0]=='!')
				{
					$("#myModal .modal-title").html("Refund Failed!!");
					$("#myModal .modal-body").html("Try Again!");
				}
				else
					$("#myModal .modal-title").html("OverStayed!!");
				$("#myModal").on('hide.bs.modal', function () {
					$("#pid").click();
				});
				$("#myModal").modal("show");
			}
			else
			{	
				$("#myModal .modal-title").html("Wrong Option!!");
				$("#myModal").on('hide.bs.modal', function () {
					$("#newnoofdays").focus();
				});
				$("#myModal").modal("show");
				//window.open('index.php','_self');
			}

		},
		});
	});

		}
			});
	});
	
	$("#refundearly").click(function(){
		if(($("#newnoofdays").val()))
		{
			if($("#newnoofdays").val()<$("#oldnoofdays").val()&&$("#newnoofdays").val()!=0)
			{
				$.ajax({
		type: 'POST',
        url: 'confirm.php',
		data: {pearlid:$("#pearlid").val(),oldnoofdays:$("#oldnoofdays").val(),newnoofdays:$("#newnoofdays").val()},
        cache:false,
        success:function(response,status){
			$("#confirmModal .modal-title").html("Confirmation");
						$("#confirmModal .modal-body").html(response);
						$("#confirmModal").modal("show");
						$("#confirmModal").on('hide.bs.modal', function () {
						            $("#pid").click();
						            $("#pid").focus();	
						    });
		$("#yes").click(function() {
				$.ajax({
				type: 'POST',
		        url: 'refund.php',
				data: {pearlid:$("#pearlid").val(),oldnoofdays:$("#oldnoofdays").val(),newnoofdays:$("#newnoofdays").val()},
		        cache:false,
		        success:function(response,status){
						if(response[0]=='!')
						{
							$("#refund").click();
						}
						else if(response[0]=='#')
						{

							$("#myModal .modal-body").html(response.substring(1));
							$("#myModal .modal-title").html("Invalid Input!!");
							$("#myModal").modal("show");
							$("#myModal").on('hide.bs.modal', function () {
								$("#newnoofdays").focus();
							});
						}
						else if(response[0]=='!')
						{
							$("#myModal .modal-body").html("Try Again");
							$("#myModal .modal-title").html("Refund Failed!!");
							$("#myModal").modal("show");
						}
						else
						{
							$("#myModal .modal-body").html(response);
							console.log(response);
							$("#myModal .modal-title").html("Early Refund Successfull!!");
							$("#myModal").modal("show");
							$("#myModal").on('hide.bs.modal', function () {
								$("#pid").click();
								window.open('index.php','_self');
								
							});
						}
					},
				});
			});
		}
				});
			}
			else if($("#newnoofdays").val()==$("#oldnoofdays").val())
				$("#onod-error").html("Use 'Refund' Button");	
			else
				$("#onod-error").html("Invalid Input.");
		}
		else
		{
			$("#onod-error").html("required");
		}
	});	
	
	$("#increasestay").click(function(){
		if(($("#newnoofdays").val()))
		{
			if($("#newnoofdays").val()>$("#oldnoofdays").val()&&$("#newnoofdays").val()!=0)
			{
				$.ajax({
		type: 'POST',
        url: 'confirm.php',
		data: {pearlid:$("#pearlid").val(),oldnoofdays:$("#oldnoofdays").val(),newnoofdays:$("#newnoofdays").val()},
        cache:false,
        success:function(response,status){
        	//alert("here1");
			$("#confirmModal .modal-title").html("Confirmation");
						$("#confirmModal .modal-body").html(response);
						$("#confirmModal").modal("show");
						$("#confirmModal").on('hide.bs.modal', function () {
						            	
						    });
		$("#yes").click(function() {
			//console.log('clicked');
				$.ajax({
				type: 'POST',
		        url: 'refund.php',
		        datatype: 'json',
				data: {pearlid:$("#pearlid").val(),oldnoofdays:$("#oldnoofdays").val(),newnoofdays:$("#newnoofdays").val()},
		        cache:false,
		        success:function(response,status){
		        	//alert("here2");
		        	//console.log(response);
					if(response[0]=='!')
					{
						$("#refund").click();
					}
					else if(response[0]=='#')
					{
						$("#myModal .modal-body").html(response.substring(1));
						$("#myModal .modal-title").html("Invalid Input!!");
						$("#myModal").modal("show");
						$("#myModal").on('hide.bs.modal', function () {
							$("#newnoofdays").focus();
						});
					}
					else if(response[0]=='*')
					{
						$("#myModal .modal-body").html("Try Again");
						$("#myModal .modal-title").html("Update Failed!!");
						$("#myModal").modal("show");
					}
					else
					{
						$("#myModal .modal-body").html(response);
						$("#myModal .modal-title").html("Stay Increased Successfully!!");
						$("#myModal").modal("show");
						$("#myModal").on('hide.bs.modal', function () {
						window.open('index.php','_self');
								// $("#pid").click();
								// $("#pid").focus();	
						});
					}
					},
					error: function(){
						console.log('error2');
					}
				});
			});	
			},
			error: function(){
				console.log('error');
			}
		});
			}
			else
				$("#onod-error").html("Invalid Input.Enter total No. of days");
		}
		else
		{
			$("#onod-error").html("required");
		}
	});

	$("#finish").click(function(){
		var output = valid();
		if(output) {
			$.ajax({
				type: 'POST',
		        url: 'validate_insert.php',
				data: 
				{
					pearlid:$("#pearlid").val(),
					sdate:$("#sdate").val(),
					edate:$("#edate").val(),
					noofdays:$("#noofdays").val(),
					bhavan:$("#bhavan").val()
				},
		        cache:false,
		        success:function(response,status){
		        		$("#myModal .modal-body").html(response);
		        		if(response[0]=='Y')
		        			$("#myModal .modal-title").html("Accommodation Successfull!!");
		        		else
		        		{	
		        			$("#myModal .modal-title").html("Accommodation Failed!!");
		        			$("#myModal .modal-body").html("Try Again");
						}
						$("#myModal").modal("show",{backdrop: 'static'});
						$("#myModal").on('hide.bs.modal', function () {
					            $("#pid").click();	
					            window.open('index.php','_self');
					    });
						
					},
			});
		}
	});

	$("#cancel").click(function() {
		$("#confirmModal .modal-title").html("Confirmation");
						$("#confirmModal .modal-body").html("Are you sure you want to Cancel?");
						$("#confirmModal").modal("show");
						$("#confirmModal").on('hide.bs.modal', function () {
						            $("#pid").click();
						            $("#pid").focus();	
						    });
		$("#yes").click(function() {

		$.ajax({
	        type: 'POST',
	        url: 'cancel.php',
			data: {pearlid:$("#pearlid").val()},
	        cache:false,
	        success: function(response,status){
	            		if(response[0]=='Y')
	            			$("#myModal .modal-title").html("Cancellation Successfull!!");
	            		else
			        			$("#myModal .modal-title").html("Cancellation Failed!!(Note-Only Cancelling once is allowed)");
						$("#myModal .modal-body").html(response);
						$("#myModal").modal("show");
						$("#myModal").on('hide.bs.modal', function () {
						            $("#pid").click();
						            window.open('index.php','_self');	
						    });
				},
			});
       // });
   });
	});
	$('#sdate').datepicker({ dateFormat: 'yy-mm-dd'});
	$('#edate').datepicker({ dateFormat: 'yy-mm-dd'});
	$(function() {
		$( "#sdate" ).datepicker();
		$( "#edate" ).datepicker();	
	});	
	$("#edate").on("change",function(){
	  var sdate =$( "#sdate" ).datepicker("getDate");
	  var edate=$( "#edate" ).datepicker("getDate");
	  var noofdays=(edate.getTime()-sdate.getTime())/86400000;
	  if(noofdays<=0)
	  {
		  $("#edate-error").html("invalid");
		  $('#noofdays').val(''); 
      }
	  else
	  {
		$("#edate-error").html("");
		$('#noofdays').val(noofdays);    
	  }
	});
	$(function() {//Include in-campus and out-campus
		$.ajax({
            type: 'POST',
            url: 'bhavan.php',
            dataType: 'json',
            cache: false,
            success: function(result) {
                $.each(result,function(key,value) {
					if(value>0)
						$("#bhavan").append('<option value="'+key+'">'+key+"---"+value+"</option>");
				});
            },
        });
	});
});
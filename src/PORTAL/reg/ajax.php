<?php
include("../functions/functions.php");
if(isset($_POST['detail'])){
	
	$detail=mysqli_real_escape_string($con,$_POST['detail']);
	$check_detail_query=mysqli_query($con,"SELECT * FROM users WHERE pearl_id LIKE '%$detail%' /*OR phone LIKE '%$detail%' OR email LIKE '%$detail%'*/ ");
	$rows=mysqli_num_rows($check_detail_query);
	if($rows!=0){
	$result=mysqli_fetch_array($check_detail_query);
	$response=array();
	$response['name']=$result['name'];
	$response['email']=$result['email'];
	$response['college']=$result['college'];
	$response['phone']=$result['phone'];
	echo json_encode($response);
}
else{
		echo json_encode("no Records Found");
}
}

?>
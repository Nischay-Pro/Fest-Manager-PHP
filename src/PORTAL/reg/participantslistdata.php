<?php
include("functions/functions.php");
$query=mysqli_query($con,"SELECT * FROM users");
$i=0;
$response=array();
while($result=mysqli_fetch_array($query)){
	$response[$i]['id']=$result['id'];
	$response[$i]['name']=$result['name'];
	$response[$i]['email']=$result['email'];
	$response[$i]['college']=$result['college'];
	$response[$i]['phone']=$result['phone'];
	$i++;
}
echo json_encode($response);
?>

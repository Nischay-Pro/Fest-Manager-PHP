<?php
if(!empty($_POST))
{
	foreach($_POST as $field_name => $val)
	{
		$con=mysqli_connect("localhost","root","","pearl_16");
		//clean post values
		$field_userid = strip_tags(trim($field_name));
		$val = strip_tags(trim(mysqli_real_escape_string($con,$val)));

		//from the fieldname:user_id we need to get user_id
		$split_data = explode(':', $field_userid);
		$id = $split_data[1];
		$field_name = $split_data[0];
		if($field_name=='Event_date'){
			$val=strtotime($val);
		}
		else{
			$val=$val;
		}
		if(!empty($id) && !empty($field_name) && !empty($val))
		{
			//echo $field_name.$id.$val;
			mysqli_query($con,"UPDATE accomodation SET $field_name = '$val' WHERE Pearl_Id = '$id'");
			echo "Updated";
		} else {
			echo "Invalid Requests";
		}
	}
} else {
	echo "Invalid Requests";
}
?>
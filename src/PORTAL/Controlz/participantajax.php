<?php
include("../functions/functions.php");
if(isset($_POST['field_userid'])){
	$field_userid=$_POST['field_userid'];
	$split_data = explode(':', $field_userid);
		$event_id = $split_data[1];
		$field_name = $split_data[0];
		$query=mysqli_query($con,"(SELECT * FROM users as u where u.pearl_id IN (SELECT ep.pearl_id FROM event_participants as ep  WHERE ep.event_id=$event_id) OR u.pearl_id IN (SELECT gm.pearl_id FROM group_members as gm  WHERE gm.event_id=$event_id) )");
		$i=0;
		echo "<table class='table table-bordered table-striped'>
				<tr>
				<th>Pearl Id</th>
				<th>Name</th>
				<th>Email</th>
				<th>Phone</th>
				<th>College</th>
				</tr>";		
		while($result=mysqli_fetch_array($query)){
			//(SELECT * FROM users as u where u.pearl_id IN (SELECT ep.pearl_id FROM event_participants as ep  WHERE ep.event_id=1) OR u.pearl_id IN (SELECT gm.pearl_id FROM group_members as gm  WHERE gm.event_id=1) )
			$pearl_id=$result['pearl_id'];
			$name=$result['name'];
			$email=$result['email'];
			$college=$result['college'];
			$phone=$result['phone'];
			echo '<tr>
				<td>'.$pearl_id.'</td>
				<td>'.$name.'</td>
				<td>'.$email.'</td>
				<td>'.$phone.'</td>
				<td>'.$college.'</td>
				</tr>';
		}
		echo "</table>";
}
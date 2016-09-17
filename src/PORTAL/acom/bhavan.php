<?php
		include("functions/functions.php");
		$room=array();
		if($con)
		{
			$sql="select * from Rooms";
			$result=mysqli_query($con,$sql);
			if (mysqli_num_rows($result) > 0) {
				while($row = mysqli_fetch_assoc($result)) {	
					$room[$row['floor_id']] = $row['seats_left'];
				}
				echo json_encode($room);
				/*foreach ($room as $key => $value) {
						echo "Key: $key; Value: $value\n";
				}*/
			} else {
				echo "0 results";
			}
		}
		else
			echo "could not connect to database";		
?>
<?php
$con=mysqli_connect("localhost","root","","pearl_16");
function getevents(){
	$con=mysqli_connect("localhost","root","","pearl_16");
$query=mysqli_query($con,"SELECT * FROM event_details NATURAL JOIN pearl_events");
$i=1;
while($result=mysqli_fetch_array($query)){
		$id=$result['id'];
		$Event_id=$result['Event_id'];
		$Event_date=$result['Event_date'];
		$Event_date= date('d-m-Y H:i:s', $Event_date);
		$Event_venue=$result['Event_venue'];
		$Roundname=$result['Roundname'];
		$Event_name=$result['event_name'];
		echo "<tr>
				<td>$i</td>
				<td ' id='EventName:$id'>$Event_name</td>
				<td contenteditable='true' id='Roundname:$id'>$Roundname</td>
				<td contenteditable='true' id='Event_date:$id'>$Event_date</td>
				<td contenteditable='true' id='Event_venue:$id'>$Event_venue</td>
				</tr>";
				$i++;
		
	}
}
function getIndiEvents(){
	$con=mysqli_connect("localhost","root","","pearl_16");
	$con=mysqli_connect("localhost","root","","pearl_16");
$query=mysqli_query($con,"SELECT * FROM pearl_events");
$i=1;
while($result=mysqli_fetch_array($query)){
		$event_id=$result['event_id'];
		$event_name=$result['event_name'];
		echo "<tr>
				<td>$i</td>
				<td class='events' id='event_name:$event_id'>$event_name</td>
				</tr>";
				$i++;
		
	}
}
function getEventdropdown(){
	$con=mysqli_connect("localhost","root","","pearl_16");
$query=mysqli_query($con,"SELECT * FROM pearl_events ORDER BY event_name ASC");
$i=1;
  echo '<div class="form-group">
  <select class="form-control" id="sel1" name="Event_id">';
  while($result=mysqli_fetch_array($query)){
    $name=$result['event_name'];
    $event_id=$result['event_id'];
    echo '<option  id="'.$event_id.'" value="'.$event_id.'">'.$name.'</option>';
  }
 echo '</select></div>';
}
function getIndiParticipants(){
	$con=mysqli_connect("localhost","root","","pearl_16");
$query=mysqli_query($con,"SELECT * FROM users AS u,event_participants AS e,pearl_events AS p WHERE u.pearl_id=e.pearl_id AND e.event_id=p.event_id");
$i=1;
  
  while($result=mysqli_fetch_array($query)){
    $event_name=$result['event_name'];
    $phone=$result['phone'];
    $name=$result['name'];
    $round_at=$result['round_at']+1;
    echo '<tr>
    	<td>'.$i.'</td>
    	<td>'.$name.'</td>
    	<td>'.$phone.'</td>
    	<td>'.$event_name.'</td>
    	<td>'.$round_at.'</td>
    		</tr>';
    		$i++;
  }
}function getGroupParticipants(){
	$con=mysqli_connect("localhost","root","","pearl_16");
$query=mysqli_query($con,"SELECT * FROM users AS u,group_members AS gm,pearl_events AS p,group_details AS gd WHERE u.pearl_id=gm.pearl_id AND gm.event_id=p.event_id");
$i=1;
  
  while($result=mysqli_fetch_array($query)){
    $event_name=$result['event_name'];
    $phone=$result['phone'];
    $name=$result['name'];
    $round_at=$result['round_at']+1;
    echo '<tr>
    	<td>'.$i.'</td>
    	<td>'.$name.'</td>
    	<td>'.$phone.'</td>
    	<td>'.$event_name.'</td>
    	<td>'.$round_at.'</td>
    		</tr>';
    		$i++;
  }
}
function getReport(){
  $con=mysqli_connect("localhost","root","","pearl_16");
  $query="Select Pearl_Id,Name,phone,email,DATE_FORMAT(EndDate,'%D %M') as 'RefundDate' from accomodation Natural Join users where dayofyear(curdate())>=dayofyear(enddate) and refund=0";
$result=mysqli_query($con,$query);
  while($row=mysqli_fetch_assoc($result))
  {
    echo "<tr>";
    echo "<td>".$row['Pearl_Id']."</td>";
    echo "<td>".$row['Name']."</td>";
    echo "<td>".$row['phone']."</td>";
    echo "<td>".$row['email']."</td>";
    echo "<td class='text-left'>".$row['RefundDate']."</td>";
    echo "</tr>";
  }

}
?>
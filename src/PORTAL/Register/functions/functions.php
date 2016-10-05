<?php
include("./../../functions/functions.php");
function getRegisteredUsers(){
    $query="SELECT * FROM users";
    $result = mysqli_query($con,$query);
    $i = 1;
    while ($row=mysqli_fetch_assoc($result))
    {
        echo "<tr>";
        echo "<td>".$i."</td>";
        echo "<td>".$row['pearl_id']."</td>";
        echo "<td>".$row['name']."</td>";
        echo "<td>".$row['email']."</td>";
        echo "<td>".$row['college']."</td>";
        echo "<td>".$row['phone']."</td>";
        echo "<td>".$row['updated_at']."</td>";
        echo "</tr>";
        $i = $i+1;
    }
}
?>
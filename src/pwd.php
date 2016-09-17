<?php
if(isset($_POST['submit'])){
	echo md5($_POST['password']);	
}
?>
<form action="pwd.php" method="POST">
<input type="password" name="password">
<input type="submit" name="submit" value="Generate Encrypted Password">
</form>
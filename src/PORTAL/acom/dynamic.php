<?php
function accomcost($days) {
    if($days==1)
    {
    	return 200;
    }
    else if($days==2)
    {
    	return 350;
    }
    else if ($days>=3)
    {
    	return 450;
    }
}


?>
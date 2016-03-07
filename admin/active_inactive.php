<?php
include_once("../database/db_conection.php");
if(!empty($_POST['id'])){	

	$user_id=mysqli_real_escape_string($db_conn,$_POST['id']);
	$status=mysqli_real_escape_string($db_conn,$_POST['status']);
	$active_inactive = "UPDATE user_data SET user_status='$status' WHERE user_id='$user_id'";
	mysqli_query($db_conn,$active_inactive);
	echo 1;
	
		
}

?>
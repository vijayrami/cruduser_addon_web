<?php
session_start();
include_once("../database/db_conection.php");

if(!empty($_POST["users"]) && is_array($_POST["users"])) {
	$rowCount = count($_POST["users"]);
	for($i=0;$i<$rowCount;$i++) {
		mysqli_query($db_conn,"DELETE FROM user_data WHERE user_id='" . $_POST["users"][$i] . "'");
	}
	$_SESSION['delete_multi_users'] = $rowCount;
	header("Location:view_users.php");
} else {
	$_SESSION['select_users'] = "Please Select Atleast one User";
	header("Location:view_users.php");
}
?>
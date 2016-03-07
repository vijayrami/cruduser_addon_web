<?php
include_once("../database/db_conection.php");
if($_POST['id'])
{
    $id = mysqli_real_escape_string($db_conn,$_POST['id']);
    $delete = "DELETE FROM user_data WHERE user_id='$id'";
    mysqli_query($db_conn,$delete);
}
?>
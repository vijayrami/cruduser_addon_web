<?php

session_start();
if(!isset($_SESSION['admin_user']))
{
 header("Location: index.php");
}
else if(isset($_SESSION['admin_user'])!="")
{
 header("Location: view_users.php");
}
if(isset($_GET['logout'])){
session_unset();
session_destroy();
header("Location: index.php");
}

?> 
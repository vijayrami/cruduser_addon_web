<?php
session_start();
include_once("database/db_conection.php");
if(!$_SESSION['user'])  
{   
    header("Location: index.php");//redirect to login page to secure the welcome page without login access
}   
include_once("header_front.php");
$user_data_id = $_SESSION['user_id'];
//get data from email query

$get_from_id_query="select * from user_data WHERE user_id='$user_data_id'"; 
$result_data = mysqli_query($db_conn, $get_from_id_query);   
?>
<body>  
<h1>Welcome</h1><br>  
<?php  
// Fetch one and one row
  while ($row=mysqli_fetch_row($result_data))
    {
		if(!function_exists('getAgedata')){
			function getAgedata($user_birth_date){
			 $adjust = (date("md") >= date("md", strtotime($user_birth_date))) ? 0 : -1; // Si aún no hemos llegado al día y mes en este año restamos 1
			 $years = date("Y") - date("Y", strtotime($user_birth_date)); // Calculamos el número de años 
			 return $years + $adjust; // Sumamos la diferencia de años más el ajuste
			}
		}
		
		$user_birth_date = $row[5];
		$old= getAgedata($user_birth_date);
		echo "your name: "."<b>".$row[1]."</b><br/>";
		echo "your email: "."<b>".$row[2]."</b><br/>";
		echo "your are "."<b>".$old."</b> years old.<br/>";
		echo "your are "."<b>".$row[6]."</b><br/>";
		
    }
  
?>  
 
<h2><a href="logout.php?logout">Logout here</a> </h2>  
  
</body>
</html>
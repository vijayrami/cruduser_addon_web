<?php
session_start();
include_once("database/db_conection.php");

if(!$_SESSION['user'])  
{   
    header("Location: index.php");//redirect to login page to secure the welcome page without login access
}   
include_once("header_front.php");
$user_data_mail = $_SESSION['user_email_id'];
//get data from email query

$get_from_id_query="select * from user_data WHERE user_email='$user_data_mail'"; 
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
		echo "<img alt='$row[1]' height='100px' width='100px' src='uploads/$row[4]'>"."<br/>";
		$user_birth_date = $row[5];
		$old= getAgedata($user_birth_date);
		echo "your name: "."<b>".$row[1]."</b><br/>";
		echo "your email: "."<b>".$row[2]."</b><br/>";
		echo "your are "."<b>".$old."</b> years old.<br/>";
		echo "your are "."<b>".$row[6]."</b><br/>";
		if($row[7] == 1){
			echo "you are <b>active</b> user<br/>";
		}else{
			echo "you are <b>inactive</b> user<br/>";
		}
		
		$user_country=$row[8]; 
		$user_state=$row[9]; 
		$user_city=$row[10]; 
		
		$user_address=$row[11];   

		$view_users_country="select * from country WHERE country_id = '$user_country'";//select query for viewing users.  
		$crun = mysqli_query($db_conn,$view_users_country);//here run the sql query.  

		while($crow=mysqli_fetch_assoc($crun))//while look to fetch the result and store in a array $row.  
		{  
			$user_country = $crow['name'];
		} 
		
		$view_users_state="select * from state WHERE state_id='$user_state'";//select query for viewing users.  
		$srun = mysqli_query($db_conn,$view_users_state);//here run the sql query.  

		while($srow=mysqli_fetch_assoc($srun))//while look to fetch the result and store in a array $row.  
		{  
			$user_state = $srow['name'];
		} 
		
		$view_users_city="select * from city WHERE city_id='$user_city'";//select query for viewing users.  
		$cityrun = mysqli_query($db_conn,$view_users_city);//here run the sql query.  

		while($cityrow=mysqli_fetch_assoc($cityrun))//while look to fetch the result and store in a array $row.  
		{  
			$user_city = $cityrow['city_name'];
		} 
		
		echo "Country: "."<b>".$user_country."</b><br/>state: "."<b>".$user_state."</b><br/> City: "."<b>".$user_city."</b><br/>";
		echo "Address: ".$user_address;
    }
  
?>  
 
<h2><a href="logout.php?logout">Logout here</a> </h2>  
  
</body>
</html>

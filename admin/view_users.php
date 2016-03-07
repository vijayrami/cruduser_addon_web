<?php
session_start();
include_once("../database/db_conection.php");
if(!$_SESSION['admin_user'])  
{  
  header("Location: index.php"); 
}  
include_once("../header.php");

if(isset($_POST['saveuserbtn']))//this will tell us what to do if some data has been post through form with button.  
{  
	$error_flag = false;
	$uploadOk = 1;
	$target_dir = '../'."uploads/";
    $update_id=$_POST['updateuserid']; 
    $update_image=$_POST['updateuserimage']; 
    $update_username = mysqli_real_escape_string($db_conn,$_POST['editusername']);
    $update_useremail = mysqli_real_escape_string($db_conn,$_POST['edituseremail']);
    $update_userpass = md5(mysqli_real_escape_string($db_conn,$_POST['edituserpass']));
    $update_userbirthdate = mysqli_real_escape_string($db_conn,$_POST['edituserbirthdate']);
    $update_useraddress = mysqli_real_escape_string($db_conn,$_POST['edit_admin_address']);
   // $update_final_userdesc = stripslashes($_POST['edit_admin_desc']);
    $update_usergender = mysqli_real_escape_string($db_conn,$_POST["opteditgender"]);
    $update_userstatus = mysqli_real_escape_string($db_conn,$_POST['opteditstatus']);
	
	$update_usercountry = mysqli_real_escape_string($db_conn,$_POST["selectadmincountry"]);
	$update_userstate = mysqli_real_escape_string($db_conn,$_POST["selectadminstate"]);
	$update_usercity = mysqli_real_escape_string($db_conn,$_POST["selectadmincity"]);
   	
    $check_update_email_query="select * from user_data WHERE user_email='$update_useremail' AND user_id !='$update_id' ";   

    $updateresult = mysqli_query($db_conn, $check_update_email_query);   
    if(mysqli_num_rows($updateresult)>0){
    	$error_flag = true;    	
		echo "<div role='alert' class='alert alert-warning alert-dismissible fade in'> <button aria-label='Close' data-dismiss='alert' class='close' type='button'><span aria-hidden='true'>×</span></button> Email <strong>$update_useremail</strong> is already exist in our database, Please try another one! </div>";				
	}
	if(is_uploaded_file($_FILES['edituserimage']['tmp_name'])){			
		
		$target_file = $target_dir . basename($_FILES["edituserimage"]["name"]);
		
		// Check if image file is a actual image or fake image
		$check = getimagesize($_FILES["edituserimage"]["tmp_name"]);
		if($check == false) {
        	echo "<div role='alert' class='alert alert-success alert-dismissible fade in'> <strong>File is not an image.</strong></div>";
	        $uploadOk = 0;
	    }
	    // Check file size
		if ($_FILES["edituserimage"]["size"] > 5242888) {
		    echo "<div role='alert' class='alert alert-success alert-dismissible fade in'> <strong>Sorry, your file is too large.</strong></div>";
		    $uploadOk = 0;
		}
		// Allow certain file formats
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);		
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
		    echo "<div role='alert' class='alert alert-success alert-dismissible fade in'> <strong>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</strong></div>";
		    $uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
    		echo "<div role='alert' class='alert alert-success alert-dismissible fade in'> <strong>Sorry, your file was not uploaded.</strong></div>";
		}
		$imageFilename = pathinfo($target_file,PATHINFO_FILENAME);	
		$savefinalimagename = $target_dir.$imageFilename.'_'.time().'.'.$imageFileType;
		$savequeryimage = $imageFilename.'_'.time().'.'.$imageFileType;
			
	} else {
		$uploadOk = 2;
	}
	
	if (($error_flag == false)&&($uploadOk == 1)){
	move_uploaded_file($_FILES["edituserimage"]["tmp_name"], $savefinalimagename);
	if ($update_image != 'Dummy.jpg'){
		unlink("$target_dir$update_image");
	}
    $update_query="UPDATE user_data SET user_name='$update_username',user_email='$update_useremail',user_pass='$update_userpass',user_image='$savequeryimage',user_birth_date='$update_userbirthdate',user_gender='$update_usergender',user_status='$update_userstatus',user_country='$update_usercountry',user_state='$update_userstate',user_city='$update_usercity',user_address='$update_useraddress' where user_id='$update_id'";  
  	
    $run_updatequery=mysqli_query($db_conn,$update_query); 
    if($run_updatequery)  
	{  
	   echo "<div role='alert' class='alert alert-warning alert-dismissible fade in'> <button aria-label='Close' data-dismiss='alert' class='close' type='button'><span aria-hidden='true'>×</span></button> <strong>User ID $update_id </strong> has been Updated successfully. </div>";
	}
	}  
	if (($error_flag == false) && ($uploadOk == 2)){
	$update_query="UPDATE user_data SET user_name='$update_username',user_email='$update_useremail',user_pass='$update_userpass',user_image='$update_image',user_birth_date='$update_userbirthdate',user_gender='$update_usergender',user_status='$update_userstatus',user_country='$update_usercountry',user_state='$update_userstate',user_city='$update_usercity',user_address='$update_useraddress' where user_id='$update_id'";  
    
    $run_updatequery=mysqli_query($db_conn,$update_query); 
    if($run_updatequery)  
	{  
	   echo "<div role='alert' class='alert alert-warning alert-dismissible fade in'> <button aria-label='Close' data-dismiss='alert' class='close' type='button'><span aria-hidden='true'>×</span></button> <strong>User ID $update_id </strong> has been Updated successfully. </div>";
	}
	}
}
if(isset($_POST['adduserbtn']))//this will tell us what to do if some data has been post through form with button.  
{  
	
	$error_flag = false;
	$uploadOk = 1;
	$target_dir = '../'."uploads/";
	
    $add_username = mysqli_real_escape_string($db_conn,$_POST['addusername']);
    $add_useremail = mysqli_real_escape_string($db_conn,$_POST['adduseremail']);
    $add_userpass = md5(mysqli_real_escape_string($db_conn,$_POST['adduserpass']));
    $add_userbirthdate = mysqli_real_escape_string($db_conn,$_POST['adduserbirthdate']);
	
	$add_usercountry = mysqli_real_escape_string($db_conn,$_POST['country']);
	$add_userstate = mysqli_real_escape_string($db_conn,$_POST['state']);
	$add_usercity = mysqli_real_escape_string($db_conn,$_POST['city']);
    
    $add_useraddress=mysqli_real_escape_string($db_conn,$_POST['add_admin_address']);
    //$final_adduserdesc = stripslashes($_POST['add_admin_desc']);
    
    $add_usergender = mysqli_real_escape_string($db_conn,$_POST["optaddgender"]);
	$add_userstatus = mysqli_real_escape_string($db_conn,$_POST['optaddstatus']);
    $check_add_email_query="select * from user_data WHERE user_email='$add_useremail'"; 
    $addresult = mysqli_query($db_conn, $check_add_email_query);   
    if(mysqli_num_rows($addresult)>0){
    	$error_flag = true;
    	//echo "<div role='alert' class='alert alert-warning alert-dismissible fade in'>Email <strong>$add_useremail</strong> is already exist in our database, Please try another one!</div>";	
		echo "<div role='alert' class='alert alert-warning alert-dismissible fade in'> <button aria-label='Close' data-dismiss='alert' class='close' type='button'><span aria-hidden='true'>×</span></button>Email <strong>$add_useremail</strong> is already exist in our database, Please try another one! </div>";				
	}
	if(is_uploaded_file($_FILES['adduserfile']['tmp_name'])){			
		
		$target_file = $target_dir . basename($_FILES["adduserfile"]["name"]);
		
		// Check if image file is a actual image or fake image
		$check = getimagesize($_FILES["adduserfile"]["tmp_name"]);
		if($check == false) {
        	echo "<div role='alert' class='alert alert-success alert-dismissible fade in'> <strong>File is not an image.</strong></div>";
	        $uploadOk = 0;
	    }
	    // Check file size
		if ($_FILES["adduserfile"]["size"] > 5242888) {
		    echo "<div role='alert' class='alert alert-success alert-dismissible fade in'> <strong>Sorry, your file is too large.</strong></div>";
		    $uploadOk = 0;
		}
		// Allow certain file formats
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);		
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
		    echo "<div role='alert' class='alert alert-success alert-dismissible fade in'> <strong>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</strong></div>";
		    $uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
    		echo "<div role='alert' class='alert alert-success alert-dismissible fade in'> <strong>Sorry, your file was not uploaded.</strong></div>";
		}
		$imageFilename = pathinfo($target_file,PATHINFO_FILENAME);	
		$addfinalimagename = $target_dir.$imageFilename.'_'.time().'.'.$imageFileType;
		$addqueryimage = $imageFilename.'_'.time().'.'.$imageFileType;
			
	} else {
		$addfinalimagename = $target_dir.'Dummy.jpg';
		$addqueryimage = 'Dummy.jpg';
	}
	if (($error_flag == false) && ($uploadOk == 1)){
	move_uploaded_file($_FILES["adduserfile"]["tmp_name"], $addfinalimagename);
    $add_query="insert into user_data (user_name,user_email,user_pass,user_image,user_birth_date,user_gender,user_status,user_country,user_state,user_city,user_address) VALUE ('$add_username','$add_useremail','$add_userpass','$addqueryimage','$add_userbirthdate','$add_usergender','$add_userstatus','$add_usercountry','$add_userstate','$add_usercity','$add_useraddress')";  
  	//echo $add_query;
	//exit;
    $run_addquery=mysqli_query($db_conn,$add_query); 
    if($run_addquery)  
	{  
	   echo "<div role='alert' class='alert alert-success alert-dismissible fade in'>User Emal <strong>$add_useremail </strong> has been added successfully.</div>";
	}
	}  
}
?>
<?php
if(isset($_SESSION['select_users'])!="")
{
	echo "<div role='alert' class='alert alert-success alert-dismissible fade in'> <strong>Please Select Atleast one User to perform an action.</strong></div>";
	unset($_SESSION['select_users']);
}
if(isset($_SESSION['delete_multi_users'])!="")
{
	$deleted_user = $_SESSION['delete_multi_users'];
	echo "<div role='alert' class='alert alert-success alert-dismissible fade in'> <strong>$deleted_user users has been deleted successfully.</strong></div>";
	unset($_SESSION['delete_multi_users']);
}
?>
<body>
<div class="container">
	<div class="row">
	<div class="table-scrol"> 
		<div class="row">
		<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
	    		<h1 align="center">All the Users</h1> 
	    </div>  
	    </div>
	    <p></p>
	    <div class="row">
	    <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
	  	<form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' method="post">
		<input type="submit" class="btn btn-success" name="adduser" value="Add User">
		</form>
		</div>  
		
		<div class="pull-right offset-0">		
		<!-- Small log out modal start -->
		<button class="btn btn-danger" data-toggle="modal" data-target=".bs-example-modal-sm">Logout</button>

		<div class="modal bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
		  <div class="modal-dialog modal-sm">
			<div class="modal-content">
			  <div class="modal-header"><h4>Logout <i class="fa fa-lock"></i></h4></div>
			  <div class="modal-body"><i class="fa fa-question-circle"></i> Are you sure you want to log-off?</div>
			  <div class="modal-footer"><a href="logout.php?logout" class="btn btn-danger btn-block">Logout</a></div>
			</div>
		  </div>
		</div>
		<!-- Small log out modal ends -->
		</div>
		</div>
		<p></p>
		<!---add user form start-->
		<?php
		if(isset($_POST['adduser']))//this will tell us what to do if some data has been post through form with button.  
		{  ?>
		    <div class="container">
		    	<div class="row">
			    <h2>Add Users</h2>
			    
			<form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' method="post" enctype="multipart/form-data">
		      
			  <div class="form-group">
			    <label for="addusername11">User Name</label>
			    <input type="text" class="form-control" name="addusername" value="" placeholder="Username" required  autofocus>
			  </div>
			  <div class="form-group">
			    <label for="adduseremail11">Email address</label>
			    <input type="email" class="form-control" name="adduseremail" value="" placeholder="E-mail" autofocus required>
			  </div>
			  <div class="form-group">
				<label for="adduserpassl11">Password</label>
				<input type="password" class="form-control" name="adduserpass" placeholder="Password" required autofocus>
			  </div> 
			  <div class="form-group">
		    	<label for="adduserInputFile">Profile Image</label>
		    	<input type="file" name="adduserfile" id="adduserInputFile">			
		  	  </div>
			  <div class="form-group">
			    <label for="adduserInputbdate">User Birth Date</label>
			    <input type="date" class="form-control birth_date" name="adduserbirthdate" value="" placeholder="Birth Date" autofocus required>
			  </div>
		  	  <div class="form-group">
		    	<label for="addusergender">Gender:</label>
		    	<label class="radio-inline"><input type="radio" name="optaddgender" value="Male" required autofocus>Male</label>
				<label class="radio-inline"><input type="radio" name="optaddgender" value="Female">Female</label>
		  	  </div>
			  <div class="form-group">
		    	<label for="adduserstatus">Status:</label>
		    	<label class="radio-inline"><input type="radio" name="optaddstatus" value="0" required autofocus>Inactive</label>
				<label class="radio-inline"><input type="radio" name="optaddstatus" value="1">Active</label>
		  	  </div>
				<!--country,state,city dropdown start-->
				<?php
				$view_country_query="SELECT country.country_Id,country.name FROM country INNER JOIN state ON country.country_Id=state.country_id GROUP BY country.name ";//select query for viewing users. 
				$run=mysqli_query($db_conn,$view_country_query);//here run the sql query.  
				?>
				<div class="frmDronpDown">
                    <div class="form-group">
                        <label>Country:</label><br/>
                        <select name="country" id="country-list" class="demoInputBox" onChange="getState(this.value);" required autofocus>
                        <option value="0">Select Country</option>
                        <?php
                        foreach($run as $country) {
                        ?>
                        <option value="<?php echo $country["country_Id"]; ?>"><?php echo $country["name"]; ?></option>
                        <?php
                        }
                        ?>
                        </select>
                    </div>
                    <div class="form-group state-list-display">
                        <label>State:</label><br/>                        
                        <select name="state" id="state-list" class="demoInputBox" onChange="getCity(this.value);" required autofocus>
                        <option value="">Select State</option>
                        </select>
                    </div>
                    <div class="form-group city-list-display">
                        <label>City:</label><br/>
                        <select name="city" id="city-list" class="demoInputBox" required autofocus>
                        <option value="">Select City</option>
                        </select>
                    </div>
				</div>		
				<!--country,state,city dropdown Ends-->
            <div class="form-group">
                <label for="adduseraddress11">User Address</label>
                <textarea class="ckeditor" id="register_editor" rows="4" cols="100" name="add_admin_address"></textarea>
			</div>			
			  <input class="btn btn-lg btn-success btn-block" type="submit" value="Add" name="adduserbtn" >
			</form>
			</div>
		</div>
		<?php } ?>
		<!---add user form Ends-->
		<!---Display user Start-->		
		<p></p>
		<?php
		$num_rec_per_page=10;
		if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }; 
		$start_from = ($page-1) * $num_rec_per_page; 
		$view_users_query="select * from user_data LIMIT $start_from, $num_rec_per_page";//select query for viewing users. 
		$run=mysqli_query($db_conn,$view_users_query);//here run the sql query. 
		?>
		<form name="alluserslistingform" method="post" action="">
		<div class="row">
		<div class="table-responsive"><!--this is used for responsive display in mobile and other devices-->  
	  
	  
	    <table id="example" class="table table-bordered table-hover table-striped" style="table-layout: fixed">  
	        <thead>
	        <tr> 	  
							
	            <th class="col-md-1 col-sm-1">Check all<?php echo (mysqli_num_rows($run)>0)?"<input type='checkbox' id='checkAll'/>":"";?></th>  
	            <th class="col-md-1 col-sm-1">User Name</th>  
	            <th class="col-md-2 col-sm-2">User E-mail</th> 
	            <th class="col-md-1 col-sm-1">Gender</th> 
	            <th class="col-md-2 col-sm-2">Image</th>  
	            <th class="col-md-1 col-sm-1">Country</th>  
				<th class="col-md-1 col-sm-1">State</th>  
				<th class="col-md-1 col-sm-1">City</th> 
				<th class="col-md-1 col-sm-1">Age</th> 
				<th class="col-md-1 col-sm-1">Status</th> 				
	            <th class="col-md-2 col-sm-2">Address</th>  
	            <th class="col-md-1">Edit User</th> 
	            <th class="col-md-1">Delete User</th>  
	        </tr>  
	        </thead> 
			<tfoot>
            <tr>   
						
                <th class="col-md-1 col-sm-1"></th>  
                <th class="col-md-1 col-sm-1">User Name</th>  
                <th class="col-md-2 col-sm-2">User E-mail</th> 
                <th class="col-md-1 col-sm-1">Gender</th> 
                <th class="col-md-2 col-sm-2">Image</th> 
                 <th class="col-md-1 col-sm-1">Country</th>  
				<th class="col-md-1 col-sm-1">State</th>  
				<th class="col-md-1 col-sm-1">City</th> 
				<th class="col-md-1 col-sm-1">Age</th> 
				<th class="col-md-1 col-sm-1">Status</th> 
	            <th class="col-md-2 col-sm-2">Address</th>    
                <th class="col-md-1">Edit User</th> 
                <th class="col-md-1">Delete User</th>  
            </tr>  
            </tfoot>  
			<tbody>
	        <?php  
	         
	  		if(mysqli_num_rows($run)>0){
			//$user_id = 0;						
				
	        while($row=mysqli_fetch_array($run))//while look to fetch the result and store in a array $row.  
	        {  	//$user_id++;
	            $user_id=$row[0];  
	            $user_name=$row[1];  
	            $user_email=$row[2];
				$user_image=$row[4]; 
				$user_birth_date=$row[5]; 
	            $user_gender=$row[6];  
				$user_status=$row[7];
	            
				if(!function_exists('getAge')){
					function getAge($user_birth_date){
					 $adjust = (date("md") >= date("md", strtotime($user_birth_date))) ? 0 : -1; // Si aún no hemos llegado al día y mes en este año restamos 1
					 $years = date("Y") - date("Y", strtotime($user_birth_date)); // Calculamos el número de años 
					 return $years + $adjust; // Sumamos la diferencia de años más el ajuste
					}
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
				
            ?>  
	  
	        <tr>  
	            <!--here showing results in the table -->  
	            <td class="col-md-1 col-sm-1"><input name="users[]" type="checkbox" id="users" value="<? echo $user_id;?>"></td> 
				 
	            <td class="col-md-1 col-sm-1"><?php echo $user_name;  ?></td>  
	            <td class="col-md-2 col-sm-2"><?php echo $user_email;  ?></td>  
	            <td class="col-md-1 col-sm-1"><?php echo $user_gender;  ?></td>  
	            <td class="col-md-2 col-sm-2"><img alt="<?php echo $user_name;?>" height="100px" width="100px" src="../uploads/<?php echo $user_image;?>"></td>  
	            <td class="col-md-1 col-sm-1">
                    <?php echo $user_country;  ?>
                </td>  
				<td class="col-md-1 col-sm-1">
                    <?php echo $user_state;  ?>
                </td>  
				<td class="col-md-1 col-sm-1">
                    <?php echo $user_city;  ?>
                </td>  
                <td class="col-md-2 col-sm-2"><?php echo getAge($user_birth_date);  ?></td>  
				<td><i data="<?php echo $user_id;?>" class="status_checks btn

				  <?php echo ($user_status)?'btn-success': 'btn-danger'?>"><?php echo ($user_status)? 'Active' : 'Inactive'?>

				</i></td>
				<td class="col-md-1 col-sm-1">
                    <?php echo $user_address;  ?>
                </td>  
	            <td class="col-md-1">
	            	<form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' method="post">
      				<input type="hidden" name="edituserid" value="<?php echo $user_id ?>">
      				<input type="submit" class="btn btn-success" name="edituser" value="Edit">
      				</form>
	            </td> <!--btn btn-danger is a bootstrap button to show danger-->	             
	            <td class="col-md-1">
	            	
      				<!--<a class="btn btn-danger delete" href="#" id="<?php echo $user_id; ?>">Delete</a>-->
      				<input type="submit" class="btn btn-danger delete" id="<?php echo $user_id; ?>" name="deleteuser" value="Delete">
	            </td> <!--btn btn-danger is a bootstrap button to show danger-->  
	            
	        </tr>  
			
	        <?php } ?>
			<tr class="listheader">
				<td colspan="13"><input type="button" name="delete" value="Delete"  onClick="setDeleteAction();" /></td>
			</tr>
	        <?php } else {
				echo "<tr><td colspan='13'><h3 class='text-center'>No Records Found</h3></tr></td>";
			}
	        
	        ?>  			
	        </tbody>
	    </table>
	    <?php 
		$paginationsql = "SELECT * FROM user_data"; 
		$pagination_result = mysqli_query($db_conn,$paginationsql); //run the query
		$total_records = mysqli_num_rows($pagination_result);  //count number of records
		$total_pages = ceil($total_records / $num_rec_per_page); 
		
		echo "<a href='view_users.php?page=1'>".'|<'."</a> "; // Goto 1st page  

		for ($i=1; $i<=$total_pages; $i++) { 
		    echo "<a href='view_users.php?page=".$i."'>".$i."</a> "; 
		}; 
		echo "<a href='view_users.php?page=$total_pages'>".'>|'."</a> "; // Goto last page
		?> 
	    </div>  
	    </div>
		</form>
		<!---Display user Ends-->
	</div>
	</div>
</div>
<!---edit user form start-->
<?php
if(isset($_POST['edituser']))//this will tell us what to do if some data has been post through form with button.  
{  
    $edit_id=$_POST['edituserid']; 
    $get_user_query="SELECT * FROM user_data where user_id='$edit_id'";
    $run_getuserquery=mysqli_query($db_conn,$get_user_query);
    $user=mysqli_fetch_row($run_getuserquery); 
    ?>
    <div class="container">
    	<div class="row">
	    <h2>Edit Users</h2>
		<form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' method="post" enctype="multipart/form-data">
	  <div class="form-group">
	    <label for="editusername11">User Name</label>
	    <input type="text" class="form-control" name="editusername" value="<?php echo $user[1];?>" placeholder="Username" required  autofocus>
	  </div>
	  <div class="form-group">
	    <label for="edituseremail11">Email address</label>
	    <input type="email" class="form-control" name="edituseremail" value="<?php echo $user[2];?>" placeholder="E-mail" autofocus required>
	  </div>
	  <div class="form-group">
	    <label for="edituserpassl11">Password</label>
	    <input type="password" class="form-control" name="edituserpass" placeholder="Password" required>
	  </div> 
	  <div class="form-group">
	    <label for="edituserimage11">User Image</label>
	    <input type="file" name="edituserimage">
	    <img alt="<?php echo $user[1];?>" height="100px" width="100px" src="../uploads/<?php echo $user[4];?>">
	  </div>
	  <div class="form-group">
		<label for="adduserInputbdate">User Birth Date</label>
		<input type="date" class="form-control birth_date" name="edituserbirthdate" value="<?php echo $user[5];?>" placeholder="Birth Date" autofocus required>
	  </div>
	  <div class="form-group">
    		<label for="editusergender11">Gender:</label>
    		<label class="radio-inline"><input type="radio" name="opteditgender" value="Male" <?php if (!empty($user[6]) && $user[6]=="Male") echo "checked";?> required autofocus>Male</label>
			<label class="radio-inline"><input type="radio" name="opteditgender" value="Female" <?php if (!empty($user[6]) && $user[6]=="Female") echo "checked";?>>Female</label>
  	  </div>	  
	  <div class="form-group">
    		<label for="edituserstatus11">Status:</label>
    		<label class="radio-inline"><input type="radio" name="opteditstatus" value="0" <?php if (!empty($user[7]) && $user[7]=="0") echo "checked";?> required autofocus>Inactive</label>
			<label class="radio-inline"><input type="radio" name="opteditstatus" value="1" <?php if (!empty($user[7]) && $user[7]=="1") echo "checked";?>>Active</label>
  	  </div>
	  <div class="form-group">
            <label for="exampleInputeditcountry">Select Country:</label>
            <?php
            $select_country_query="Select * from country";
            $select_country_query_run =mysqli_query($db_conn,$select_country_query);
            echo "<select name='selectadmincountry' id='country-list' onChange='getState(this.value);' required autofocus>";
            echo "<option value='0'>Select Country</option>";
            while ($select_country_query_array = mysqli_fetch_array($select_country_query_run) )
            { ?>
               <option value="<?php echo htmlspecialchars($select_country_query_array['country_Id']);?>" <?php if (!empty($user[8]) && $user[8]==htmlspecialchars($select_country_query_array["country_Id"])) echo "selected";?>><?php echo htmlspecialchars($select_country_query_array['name']); ?></option>
            <?php }
            echo "</select>";
            ?>
      </div>
	  <div class="form-group">
            <label for="exampleInputeditstate">Select State:</label>
            <?php
            $select_state_query="Select * from state";
            $select_state_query_run =mysqli_query($db_conn,$select_state_query);
            echo "<select name='selectadminstate' id='state-list' onChange='getCity(this.value);' required autofocus>";
            echo "<option value='0'>Select State</option>";
            while ($select_state_query_array = mysqli_fetch_array($select_state_query_run) )
            { ?>
               <option value="<?php echo htmlspecialchars($select_state_query_array['state_id']);?>" <?php if (!empty($user[9]) && $user[9]==htmlspecialchars($select_state_query_array["state_id"])) echo "selected";?>><?php echo htmlspecialchars($select_state_query_array['name']); ?></option>
            <?php }
            echo "</select>";
            ?>
      </div>
	  <div class="form-group">
            <label for="exampleInputeditcity">Select City:</label>
            <?php
            $select_city_query="Select * from city";
            $select_city_query_run =mysqli_query($db_conn,$select_city_query);
            echo "<select name='selectadmincity' id='city-list' required autofocus>";
            echo "<option value='0'>Select City</option>";
            while ($select_city_query_array = mysqli_fetch_array($select_city_query_run) )
            { ?>
               <option value="<?php echo htmlspecialchars($select_city_query_array['city_id']);?>" <?php if (!empty($user[10]) && $user[10]==htmlspecialchars($select_city_query_array["city_id"])) echo "selected";?>><?php echo htmlspecialchars($select_city_query_array['city_name']); ?></option>
            <?php }
            echo "</select>";
            ?>
      </div>
      <div class="form-group">
                <label for="edituserdesc11">Address</label>
                <textarea class="ckeditor" id="register_editor" name="edit_admin_address"><?php echo $user[11];?></textarea>
      </div>
	   
	  <input type="hidden" name="updateuserid" value="<?php echo $user[0];?>">
	  <input type="hidden" name="updateuserimage" value="<?php echo $user[4];?>">
	  <input class="btn btn-lg btn-success btn-block" type="submit" value="Save" name="saveuserbtn" >
	</form>
	</div>
</div>
<?php } ?>
<!---edit user form start-->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->    
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="lib/js/bootstrap.min.js"></script>
	<script src="lib/js/bootstrap-datepicker.js"></script>
    
    <script type="text/javascript">
    
    function getState(val) {     
        if (val == 0){
            document.getElementById('state-list').innerHTML='<select name="state" required autofocus>'+
						'<option>Select State</option>'+
				        '</select>';  
			document.getElementById('city-list').innerHTML='<select name="city" required autofocus>'+
						'<option>Select City</option>'+
				        '</select>';  
        }
        if (val > 0){  
		document.getElementById('city-list').innerHTML='<select name="city" required autofocus>'+
						'<option>Select City</option>'+
				        '</select>';  
        
        $.ajax({
        type: "POST",
        url: "get_state.php",
        data:'country_id='+val,
        success: function(data){            
            $("#state-list").html(data);
        }
        });
        }
    }
    
    function getCity(val) {
		
		if (val == 0){		
		document.getElementById('city-list').innerHTML='<select name="city">'+
					'<option>Select City</option>'+
					'</select>';  
        }
        
        if (val > 0){   
        $.ajax({
        type: "POST",
        url: "get_city.php",
        data:'state_id='+val,
        success: function(data){
            $(".city-list-display").show();
            $("#city-list").html(data);
        }
        });
        }
    }
	
    </script>
	<!----for Delete User start---->
	<script type="text/javascript">
	$(function() {
	$(".btn.btn-danger.delete").click(function(){
	var element = $(this);
	var del_id = element.attr("id");
	var info = 'id=' + del_id;
	if(confirm("Are you sure you want to delete this?"))
	{
	 $.ajax({
	   type: "POST",
	   url: "delete.php",
	   data: info,
	   success: function(){
	   	
	 }
	});
      //$(this).parents("tr").animate({backgroundColor: "#003" }, "slow").animate({opacity: "hide"}, "slow").remove();
     // $(this).parents("tr").remove(); 
       	$( this ).parents("tr").hide( 1200, function() {
    	$( this ).remove();
  		});
	 }
	return false;
	});
	});
	</script>
	<!----for Delete User Ends---->
	<!----for Multiple Delete User start---->
	<script type="text/javascript">
	function setDeleteAction() {
			if(confirm("Are you sure want to delete these rows?")) {
			document.alluserslistingform.action = "multi_delete.php";
			document.alluserslistingform.submit();
			}
	}
	</script>
	<!----for Multiple Delete User Ends---->
	<!----for active/inactive script start---->
	<script type="text/javascript">
	$(document).on('click','.status_checks',function(){
		  var status = ($(this).hasClass("btn-success")) ? '0' : '1';
		  var msg = (status=='0')? 'Deactivate' : 'Activate';
		  if(confirm("Are you sure to "+ msg)){
			var current_element = $(this);
			url = "ajax.php";
			$.ajax({
			  url: "active_inactive.php",
			  type:"POST",
			  data: {id:$(current_element).attr('data'),status:status},
			  success: function(data)
			  { 
				location.reload();	
			  }
			});
			
		  }      
		});
	</script>
	<!----for active/inactive script Ends---->
	<!----for Check all User start---->
	<script type="text/javascript">
	$(document).ready(function(){
		$("#checkAll").change(function () {
			$("tbody #users").prop('checked', $(this).prop("checked"));
		});
	});
	</script>
	<!----for Check all User Ends---->
<!----for datepicker start---->
<script>
$(document).ready(function(){
		$('.birth_date').datepicker({
        format: 'yyyy-mm-dd',
        endDate: '+0d',
        autoclose: true
        }).on('changeDate', function (selected) {
            var startDate = new Date(selected.date.valueOf());
            $('.to_date').datepicker('setStartDate', startDate);
        }).on('clearDate', function (selected) {
            $('.to_date').datepicker('setStartDate', null);
        });
});
</script>
<!----for datepicker ends----> 

     
  </body>
</html>
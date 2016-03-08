<?php
session_start();
if(isset($_SESSION['user'])!="")
{
 header("Location: home.php");
}
include_once("database/db_conection.php");
// define variables and set to empty values
$error_flag = false;
$uploadOk = 1;
$target_dir = "uploads/";
//$user_name = $user_pass = $user_email = $user_gender = "";  

if(isset($_POST['registeruserbtn'])){
	$user_name=mysqli_real_escape_string($db_conn,$_POST['name']);//here getting result from the post array after submitting the form. 
	$user_email=mysqli_real_escape_string($db_conn,$_POST['email']);//same 	
    $user_pass=md5(mysqli_real_escape_string($db_conn,$_POST['pass']));//same      
    $user_birthdate=mysqli_real_escape_string($db_conn,$_POST['birthdate']);//same 
	$user_gender = mysqli_real_escape_string($db_conn,$_POST["optgender"]);
	$user_status = mysqli_real_escape_string($db_conn,$_POST["optstatus"]);
	
	$user_country = mysqli_real_escape_string($db_conn,$_POST["country"]);
	$user_state = mysqli_real_escape_string($db_conn,$_POST["state"]);
	$user_city = mysqli_real_escape_string($db_conn,$_POST["city"]);
    
    $user_desc = mysqli_real_escape_string($db_conn,$_POST['add_user_address']);
  
    //here query check weather if user already registered so can't register again.   
    $check_email_query="select * from user_data WHERE user_email='$user_email'"; 
    $result = mysqli_query($db_conn, $check_email_query);   
    if(mysqli_num_rows($result)>0){
    	$error_flag = true;
    	echo "<div role='alert' class='alert alert-warning alert-dismissible fade in'>Email <strong>$user_email</strong> is already exist in our database, Please try another one!</div>";		
	} else {
		$_SESSION['user'] = $user_name;
		$_SESSION['user_email_id'] = $user_email;
	}
	if(is_uploaded_file($_FILES['userfile']['tmp_name'])){			
		
		$target_file = $target_dir . basename($_FILES["userfile"]["name"]);
		
		// Check if image file is a actual image or fake image
		$check = getimagesize($_FILES["userfile"]["tmp_name"]);
		if($check == false) {
        	echo "<div role='alert' class='alert alert-success alert-dismissible fade in'> <strong>File is not an image.</strong></div>";
	        $uploadOk = 0;
	    }
	    // Check file size
		if ($_FILES["userfile"]["size"] > 5242888) {
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
		$finalimagename = $target_dir.$imageFilename.'_'.time().'.'.$imageFileType;
		$queryimage = $imageFilename.'_'.time().'.'.$imageFileType;
			
	} else {
		$finalimagename = $target_dir.'Dummy.jpg';
		$queryimage = 'Dummy.jpg';
	}
	//insert the user into the database.
	if (($error_flag == false) && ($uploadOk == 1)) {   
	move_uploaded_file($_FILES["userfile"]["tmp_name"], $finalimagename);
	$insert_user="insert into user_data (user_name,user_email,user_pass,user_image,user_birth_date,user_gender,user_status,user_country,user_state,user_city,user_address) VALUE ('$user_name','$user_email','$user_pass','$queryimage','$user_birthdate','$user_gender','$user_status','$user_country','$user_state','$user_city','$user_desc')";
	if(mysqli_query($db_conn,$insert_user))  
    { 
        header("Location: home.php"); 
    } 
    } 
    
} 
include_once("header_front.php");
?>
  <body>		
    <div class="container">
    <div class="row">
        <!---<div class="col-md-4 col-md-offset-4">---> <!--comment this if you use ckeditor---> 
            <div class="login-panel panel panel-success">  
                <div class="panel-heading">  
                    <h3 class="panel-title text-center">Registration</h3>  
                </div>  
                <div class="panel-body">  
                    <form enctype="multipart/form-data" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">  
                        <fieldset>  
                            <div class="form-group"> 
                            	<label for="registerusername11">User Name</label> 
                                <input type="text" placeholder="Username" name="name" value="" class="form-control" required autofocus>  
                            </div>  
  
                            <div class="form-group">  
                            	<label for="registeremail11">Email address</label> 
                                <input type="email" placeholder="E-mail" name="email" value="" class="form-control" autofocus required>             
                            </div> 
							<div class="form-group"> 
                            	<label for="registerpass11">Password</label>  
                                <input class="form-control" placeholder="Password" name="pass" type="password" value="" required>  
                            </div>  							
                            <div class="form-group">
						    	<label for="exampleInputFile">Profile Image</label>
						    	<input type="file" name="userfile" id="exampleInputFile">		
						  	</div>
							<div class="form-group">
								<label for="userInputbdate">User Birth Date</label>
								<input type="date" class="form-control birth_date" name="birthdate" value="" placeholder="Birth Date" autofocus required>
							</div>
						  	<div class="form-group">
								<label for="usergender">Gender:</label>
								<label class="radio-inline"><input type="radio" name="optgender" value="Male" required autofocus>Male</label>
								<label class="radio-inline"><input type="radio" name="optgender" value="Female">Female</label>
							</div>
							<div class="form-group">
								<label for="userstatus">Status:</label>
								<label class="radio-inline"><input type="radio" name="optstatus" value="0" required autofocus>Inactive</label>
								<label class="radio-inline"><input type="radio" name="optstatus" value="1">Active</label>
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
								<textarea class="ckeditor" id="register_editor" rows="4" cols="100" name="add_user_address"></textarea>
							</div>	                          
                            
							<input class="btn btn-lg btn-success btn-block" type="submit" value="register" name="registeruserbtn" >							
  
                        </fieldset>  
                    </form>  
                    <center><b>Already registered ?</b> <br><a href="index.php">Login here</a></center><!--for centered text-->  
                </div>  
            </div>  
        <!--</div>--> <!--comment this if you use ckeditor--->  
    </div>  
</div> 

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="admin/lib/js/bootstrap.min.js"></script>
	<script src="admin/lib/js/bootstrap-datepicker.js"></script>
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
        url: "admin/get_state.php",
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
        url: "admin/get_city.php",
        data:'state_id='+val,
        success: function(data){
            $(".city-list-display").show();
            $("#city-list").html(data);
        }
        });
        }
    }
	
    </script>
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

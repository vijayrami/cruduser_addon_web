<?php
session_start();
include_once("../database/db_conection.php");

if(isset($_SESSION['admin_user'])!="")
{
 header("Location: view_users.php");
}
include_once("../header.php");
if(isset($_POST['admin_login']))//this will tell us what to do if some data has been post through form with button.  
{  
    $admin_name=$_POST['admin_name'];  
    $admin_pass=md5($_POST['admin_pass']);  
  
    $admin_query="select * from admin where admin_name='$admin_name' AND admin_pass='$admin_pass'";  
  
    $run_query=mysqli_query($db_conn,$admin_query); 
    $row = mysqli_fetch_array($run_query); 
  
    if(mysqli_num_rows($run_query)>0)  
    {  
    	$_SESSION['admin_user'] = $row['admin_name'];
  		header("Location: view_users.php");  
    }  
    else {    	
		echo "<div role='alert' class='alert alert-warning alert-dismissible fade in'> <button aria-label='Close' data-dismiss='alert' class='close' type='button'><span aria-hidden='true'>×</span></button> <strong>Wrong Details!</strong> Please try another one! </div>";		
    }  
  
}
?>
<body>
<div class="container">  
    <div class="row">  
        <div class="col-md-4 col-md-offset-4">  
            <div class="login-panel panel panel-success">  
				<div class="clearfix text-center">
				
				  <img border="0" title="company name" alt="company name" src="lib/img/logo.jpg">
				
				</div>
                <div class="panel-heading">  
                    <h3 class="panel-title text-center">Sign In</h3>  
                </div>  
                <div class="panel-body">  
                    <form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">  
                        <fieldset>  
                            <div class="form-group"  >  
                                <input class="form-control" placeholder="Name" name="admin_name" type="text" required  autofocus>  
                            </div>  
                            <div class="form-group">  
                                <input class="form-control" placeholder="Password" name="admin_pass" type="password" value="" required  autofocus>  
                            </div>  
                            <input class="btn btn-lg btn-success btn-block" type="submit" value="login" name="admin_login" >    
                        </fieldset>  
                    </form>  
                </div>  
            </div>  
        </div>  
    </div>  
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="lib/js/bootstrap.min.js"></script>
  </body>
</html>
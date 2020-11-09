<?php
include ('header.php');
session_start();
error_reporting(0);
include('dbconnection.php');
if(isset($_POST['login']))
{
	$emailcon=$_POST['emailcont'];
	$password=md5($_POST['password']);
	$query=mysqli_query($con,"select ID from tbluser where  (Email='$emailcon' || MobileNumber='$emailcon') && Password='$password' ");
	$ret=mysqli_fetch_array($query);
	if($ret>0){
		$_SESSION['uid']=$ret['ID'];
		echo "<script > document.location ='dashboard.php'; </script>";
	}else{
		echo "<script>alert('Invalid Details');</script>";
	}}
?>

	<div class="login">

		<div class="main-agileits">
				<div class="form-w3agile">
					<h3>Login</h3>
					<form action="#" method="post">
                        <div class="key">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                            <input  type="text" name="phone" required="" placeholder="Phone Number">
                            <div class="clearfix"></div>
                        </div>
						<div class="key">
							<i class="fa fa-envelope" aria-hidden="true"></i>
							<input  type="text" name="Email" required="" placeholder="Email">
							<div class="clearfix"></div>
						</div>
						<div class="key">
							<i class="fa fa-lock" aria-hidden="true"></i>
							<input  type="password" name="Password" required="" placeholder="Password">
							<div class="clearfix"></div>
						</div>
						<input type="submit" value="Login">
					</form>
				</div>
				<div class="forg">
					<a href="#" class="forg-left">Forgot Password</a>
					<a href="register.php" class="forg-right">Register</a>
				<div class="clearfix"></div>
				</div>
			</div>
		</div>

<?php
include ('footer.php');
?>

<?php
include('dbconnection.php');
include ('header.php');
if(isset($_POST['submit'])) {
	$name = $_POST['Username'];
	$email = $_POST['Email'];
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$phone = $_POST['phone'];
	$cpassword = md5($_POST['cpassword']);
	$password = md5($_POST['Password']);
	$ret = mysqli_query($con, "SELECT UserEmail from users where UserEmail='$email' || UserName='$name'");
	$res = mysqli_fetch_array($ret);
	//Server validation
	if (empty($fname)) {
		$error = "Enter your first name !";
		$code = 1;
	}
	if (empty($fname)) {
		$error = "Enter your fullname !";
		$code = 1;
	} else if (empty($phone)) {
		$error = "Enter your mobile number !";
		$code = 2;
	} else if (!is_numeric($phone)) {
		$error = "Mobile number must be numeric only!";
		$code = 2;
	} else if (strlen($phone) != 10) {
		$error = "Mobile nuber should be 10 digit only!";
		$code = 2;
	} else if (empty($email)) {
		$error = "Enter your email !";
		$code = 3;
	} else if (!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $email)) {
		$error = "Enter valid email id !";
		$code = 3;
	} else if (empty($password)) {
		$error = "Enter your password";
		$code = 4;
	} else if (strlen($password) < 8) {
		$error = "Password must be 8 characters long !";
		$code = 4;
	} else if (empty($cpassword)) {
		$error = "Enter your confirm password";
		$code = 5;
	} else if (strlen($cpassword) < 8) {
		$error = "Confirm Password must be 8 characters long !";
		$code = 5;
	} else if ($cpassword != $password) {
		$error = "Password and Confirm Password doesnot match";
		$code = 5;
	} else {
//Checking emailid and mobile number if already registered
		$ret=mysqli_query($con,"SELECT UserEmail from users where UserEmail='$email' || UserName='$name'");
		$result = mysqli_fetch_array($ret);
		if ($result > 0) {
			echo "<script>alert('This email already associated with another account');</script>";
		} else {
			$query = mysqli_query($con, "insert into users(UserPhone,UserFname,UserLname,UserName, UserEmail,  UserPassword) value('$phone','$lname','$fname','$name',  '$email', '$password' )");
			if ($query) {
				$target_dir = "user/";
				$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
				$uploadOk = 1;
				$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image


				$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
				if ($check !== false) {
					echo "File is an image - " . $check["mime"] . ".";
					$uploadOk = 1;
				} else {
					echo "File is not an image.";
					$uploadOk = 0;
				}

				$to = $email;
				$subject = "My subject";
				$txt = "Hello world!";
				$headers = "From: webmaster@example.com" . "\r\n" .
					"CC: somebodyelse@example.com";

				mail($to, $subject, $txt, $headers);
				echo "<script>alert('Successfully mail sent');</script>";
				echo "<script>window.location.href ='login.php'</script>";


			} else {
				echo "<script>alert('Something went wrong. Please try again.')</script>";
				echo "<script>window.location.href='register.php';</script>";
			}
		}
	}

}
?>

	<div class="login">

		<div class="main-agileits">
				<div class="form-w3agile">
					<h3>Register</h3>
					<form action="#" method="post" enctype="multipart/form-data">
                        <div class="key">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <input  type="text"  name="fname" required=""  placeholder="Firstname">
                            <div class="clearfix"></div>
                        </div>
                            <div class="key">
                                <i class="fa fa-user" aria-hidden="true"></i>
                                <input  type="text"  name="lname" required=""  placeholder="Lastname">
                                <div class="clearfix"></div>
                                </div>

                        <div class="key">
                            Select image to upload:
                            <input type="file" name="fileToUpload" id="fileToUpload" style="margin: 10px;">
                            <input type="submit" value="Upload Image" name="submit">
                        </div>
						<div class="key">
							<i class="fa fa-user" aria-hidden="true"></i>
							<input  type="text"  name="Username" required=""  placeholder="Username">
							<div class="clearfix"></div>
						</div>
                        <div class="key">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                            <input  type="number"  name="phone"  required=""  placeholder="Mobile Number">
                            <div class="clearfix"></div>
                        </div>
						<div class="key">
							<i class="fa fa-envelope" aria-hidden="true"></i>
							<input  type="email"  name="Email"  required=""  placeholder="Email">
							<div class="clearfix"></div>
						</div>
						<div class="key">
							<i class="fa fa-lock" aria-hidden="true"></i>
							<input  type="password"   id="psw" name="psw"
                            pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                            title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"
                            required placeholder="Password">
							<div class="clearfix"></div>
						</div>
                        <div id="message">
                            <h4>Password must contain the following:</h4>
                            <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
                            <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
                            <p id="number" class="invalid">A <b>number</b></p>
                            <p id="length" class="invalid">Minimum <b>8 characters</b></p>
                        </div>
						<div class="key">
							<i class="fa fa-lock" aria-hidden="true"></i>
							<input  type="password" id="con_psw" name="CPassword" required="" placeholder="Confirm Password">
							<div class="clearfix"></div>
						</div>
						<input type="submit" name="submit" value="Register" onclick="return Validate()">
					</form>
				</div>
			</div>
		</div>






<!-- //password validation -->
<script>
    var myInput = document.getElementById("psw");
    var letter = document.getElementById("letter");
    var capital = document.getElementById("capital");
    var number = document.getElementById("number");
    var length = document.getElementById("length");

    // When the user clicks on the password field, show the message box
    myInput.onfocus = function() {
        document.getElementById("message").style.display = "block";
    }

    // When the user clicks outside of the password field, hide the message box
    myInput.onblur = function() {
        document.getElementById("message").style.display = "none";
    }

    // When the user starts to type something inside the password field
    myInput.onkeyup = function() {
        // Validate lowercase letters
        var lowerCaseLetters = /[a-z]/g;
        if(myInput.value.match(lowerCaseLetters)) {
            letter.classList.remove("invalid");
            letter.classList.add("valid");
        } else {
            letter.classList.remove("valid");
            letter.classList.add("invalid");
        }

        // Validate capital letters
        var upperCaseLetters = /[A-Z]/g;
        if(myInput.value.match(upperCaseLetters)) {
            capital.classList.remove("invalid");
            capital.classList.add("valid");
        } else {
            capital.classList.remove("valid");
            capital.classList.add("invalid");
        }

        // Validate numbers
        var numbers = /[0-9]/g;
        if(myInput.value.match(numbers)) {
            number.classList.remove("invalid");
            number.classList.add("valid");
        } else {
            number.classList.remove("valid");
            number.classList.add("invalid");
        }

        // Validate length
        if(myInput.value.length >= 8) {
            length.classList.remove("invalid");
            length.classList.add("valid");
        } else {
            length.classList.remove("valid");
            length.classList.add("invalid");
        }
    }
</script>

<!-- //confirm password validation -->
<script type="text/javascript">
    function Validate() {
        var password = document.getElementById("psw").value;
        var confirmPassword = document.getElementById("con_psw").value;
        if (password != confirmPassword) {
            alert("Passwords do not match.");
            return false;
        }
        return true;
    }
</script>
</body>
</html>




<?php
include('footer.php');
?>
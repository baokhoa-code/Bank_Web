<?php 

	include 'config.php';

	error_reporting(0);

	session_start();

	if (isset($_SESSION['accnum'])) {
	    header("Location: login.php");
	}
	
	if (isset($_POST['submit'])) {
		$accnum = $_POST['accnum'];
		$secpass = $_POST['secpass'];
		$password = $_POST['password'];
		$cpassword = $_POST['cpassword'];
		$type = $_POST['type'];

	 	if($type == "Admin"){
	 		if ($password == $cpassword) {
				$sql = "SELECT * FROM ADMIN_ACCOUNT WHERE acc_num='$accnum' AND ANSWER='$secpass'";
				$result = mysqli_query($conn, $sql);
				if ($result->num_rows > 0) {
					$sql = "UPDATE ADMIN_ACCOUNT SET PASS='$password' WHERE acc_num='$accnum' ";
					$result = mysqli_query($conn, $sql);
					if ($result) {
						echo "<script>alert('Your password has been changed.')</script>";
						$accnum = "";
						$secpass = "";
						$_POST['password'] = "";
						$_POST['cpassword'] = "";
					} else {
						echo "<script>alert('Can not change your password!')</script>";
					}
				} else {
					echo "<script>alert('Woops! Your Account number or Security password is wrong!')</script>";
				}
			} else {
				echo "<script>alert('Password Not Matched.')</script>";
			}
	 	}else{
	 		if ($password == $cpassword) {
				$sql = "SELECT * FROM USER_ACCOUNT WHERE acc_num='$accnum' AND ANSWER='$secpass'";
				$result = mysqli_query($conn, $sql);
				if ($result->num_rows > 0) {
					$sql = "UPDATE USER_ACCOUNT SET PASS='$password' WHERE acc_num='$accnum' ";
					$result = mysqli_query($conn, $sql);
					if ($result) {
						echo "<script>alert('Your password has been changed.')</script>";
						$accnum = "";
						$secpass = "";
						$_POST['password'] = "";
						$_POST['cpassword'] = "";
					} else {
						echo "<script>alert('Can not change your password!')</script>";
					}
				} else {
					echo "<script>alert('Woops! Your Account number or Security password is wrong!')</script>";
				}
			} else {
				echo "<script>alert('Password Not Matched.')</script>";
			}
	 	}
	}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="./css/style_login_regist.css">
	<title>Forgot</title>
</head>
<body>
	<div class="container">
		<form action="" method="POST" class="login-accnum">

            <p class="login-text" style="font-size: 2rem; font-weight: 800;margin-bottom: 50px;">Forgot Password</p>

            <div style="padding-bottom: 25px; font-size: 20px;">
				<input type="radio" placeholder="Type" name="type" id="type" value="Admin" <?php echo ($type== 'Admin') ?  "checked" : "" ;  ?> required>Admin    
                <input type="radio" placeholder="Type" name="type" id="type" value="User" <?php echo ($type== 'User') ?  "checked" : "" ;  ?> required>User
			</div>

			<div class="input-group">
				<input type="text" placeholder="Acount number" name="accnum" value="<?php echo $accnum; ?>" required>
			</div>

			<div class="input-group">
				<input type="password" placeholder="Security Password" name="secpass" value="<?php echo $secpass; ?>" required>
            </div>

			<div class="input-group">
				<input type="password" placeholder="Password" name="password" value="<?php echo $_POST['password']; ?>" required>
            </div>

            <div class="input-group">
				<input type="password" placeholder="Confirm Password" name="cpassword" value="<?php echo $_POST['cpassword']; ?>" required>
			</div>

			<div class="input-group">
				<button name="submit" class="btn">Change Password</button>
			</div>

			<p class="login-register-text">Have an account? <a href="login.php">Login Here!</a></p>

		</form>
	</div>
</body>
</html>
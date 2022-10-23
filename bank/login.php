<?php 

	include 'config.php';

	session_start();

	error_reporting(0);

	if (isset($_SESSION['accnum'])) {
		if(isset($_SESSION['type'])){
			if($_SESSION['type'] == "Admin")
				header("Location: admin_home.php");
			else
				header("Location: user_home.php");
		}else
			 header("Location: index.html");
	}
		
	if (isset($_POST['submit'])) {

	 	$accnum = $_POST['accnum'];
	 	$password = $_POST['password'];
	 	$type = $_POST['type'];
	 	$_SESSION['type'] = $type;

	 	if($type == "Admin"){
	 		$sql = "SELECT * FROM ADMIN_ACCOUNT WHERE acc_num='$accnum' AND pass='$password'";
			$result = mysqli_query($conn, $sql);

			if ($result->num_rows > 0) {
				$_SESSION['accnum'] = $accnum;
				header("Location: admin_home.php");
			} else {
				echo "<script>alert('Woops! Account number or Password is Wrong.')</script>";
			}
	 	}else{

	 		$sql = "SELECT * FROM USER_ACCOUNT WHERE acc_num='$accnum' AND pass='$password'";
			$result = mysqli_query($conn, $sql);

			if ($result->num_rows > 0) {
				$_SESSION['accnum'] = $accnum;
				header("Location: user_home.php");
			} else {
				echo "<script>alert('Woops! Account number or Password is Wrong.')</script>";
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

	<title>Login</title>
</head>
<body>

	<div class="container">
		<form action="" method="POST" class="login-accnum">

			<div style="padding-left: 89px;">
				<a href="./index.html"><img src="./images/logo.ico" width="150px"></a>
			</div>

			<p class="login-text" style="font-size: 2rem; font-weight: 800;">Login</p>

			<div style="margin-bottom: 25px; font-size: 20px;">
				<input type="radio" placeholder="Type" name="type" id="type" value="Admin" <?php echo ($type== 'Admin') ?  "checked" : "" ;  ?> required>Admin 
                <input type="radio" placeholder="Type" name="type" id="type" value="User" <?php echo ($type== 'User') ?  "checked" : "" ;  ?> required>User
			</div>

			<div class="input-group">
				<input type="text" placeholder="Account Number" name="accnum" value="<?php echo $accnum; ?>" required>
			</div>

			<div class="input-group">
				<input type="password" placeholder="Password" name="password" value="<?php echo $_POST['password']; ?>" required>
			</div>

			<div class="input-group">
				<button name="submit" class="btn">Login</button>
			</div>

			<p class="login-register-text">Forgot your password? <a href="forgot.php">Click Here!</a>.</p>

		</form>
	</div>
	
</body>
</html>
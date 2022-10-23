<?php 

    include 'config.php';

    session_start();

    error_reporting(0);

    if (!(isset($_SESSION['accnum']) || $_SESSION['type'] == "User")) {
        header("Location: login.php");
    }

    if (isset($_POST['submit'])) {
        $accnum = $_SESSION['accnum'];
        $old_pass = $_POST['old_pass'];
        $new_pass = $_POST['new_pass'];
        $c_pass = $_POST['c_pass'];
        if ($new_pass == $c_pass) {
            $sql = "SELECT * FROM USER_ACCOUNT WHERE acc_num='$accnum' AND PASS='$old_pass'";
            $result = mysqli_query($conn, $sql);
            if ($result->num_rows > 0) {
                $sql = "UPDATE USER_ACCOUNT SET PASS='$new_pass' WHERE acc_num='$accnum' ";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    echo "<script>alert('Your password has been changed.')</script>";
                    $old_pass = "";
                    $new_pass = "";
                    $c_pass = "";
                    $_POST['old_pass'] = "";
                    $_POST['new_pass'] = "";
                    $_POST['c_pass'] = "";
                    header("Location: user_account_info.php");
                } else {
                    echo "<script>alert('Can not change your password!')</script>";
                }
            } else 
                echo "<script>alert('Woops! Your old password is wrong!')</script>";
        }else 
            echo "<script>alert('Password Not Matched.')</script>";    
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="./css/style_login_regist.css">
    <link rel="stylesheet" type="text/css" href="./css/style_home.css">
    <title>User Account Information Change Password</title>
</head>
<body>
    <div class="container" style="padding-top: 10px;">
        <div style="margin-left: 10px;">
            <a href="user_account_info.php">
                <img width="50px" src="./images/app/back.png">
            </a>
        </div>
        <form id="form" action="" method="POST" class="login-accnum">
        <table class="table" border="0" style="font-size: 30px; border-spacing: 10px;">

            <tr >
                <td align="center" colspan="2" style="padding-bottom: 5px;">
                    <h1 style="color: green;font-size: 30px;">Change Password</h1>
                </td>
            </tr>


            <tr style="font-size:15px">
                <td align="left" style="width: 225px;">
                    Old Password:
                </td>
                <td align="left" style="width: 225px;">
                   <input type="password" id="old_pass" name="old_pass" size="35" value="<?php echo $old_pass; ?>" required>
                </td>
            </tr>

            <tr style="font-size:15px">
                <td align="left" style="width: 225px;">
                    New Password:
                </td>
                <td align="left" style="width: 225px;">
                   <input type="password" id="new_pass" name="new_pass" size="35" value="<?php echo $new_pass; ?>" required>
                </td>
            </tr>

            <tr style="font-size:15px">
                <td align="left" style="width: 225px;">
                    Confirm Password:
                </td>
                <td align="left" style="width: 225px;">
                   <input type="password" id="c_pass" name="c_pass" size="35" value="<?php echo $c_pass; ?>" required>
                </td>
            </tr>

            <tr style="font-size:15px">
                <td align="center" colspan="2" style="padding-top: 9px;">
                    <button type="submit" name="submit" id="submit "class="btn" >Done</button>
                </td>
            </tr>
        
        </table>
        </form>
    </div>
</body>
</html>
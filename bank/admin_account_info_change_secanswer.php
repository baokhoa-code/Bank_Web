<?php 

    include 'config.php';

    session_start();

    error_reporting(0);

    if (!(isset($_SESSION['accnum']) || $_SESSION['type'] == "Admin")) {
        header("Location: login.php");
    }

    if (isset($_POST['submit'])) {
        $accnum = $_SESSION['accnum'];
        $old_ans = $_POST['old_ans'];
        $new_ans = $_POST['new_ans'];
        $c_ans = $_POST['c_ans'];
        if ($new_ans == $c_ans) {
            $sql = "SELECT * FROM ADMIN_ACCOUNT WHERE acc_num='$accnum' AND ANSWER='$old_ans'";
            $result = mysqli_query($conn, $sql);
            if ($result->num_rows > 0) {
                $sql = "UPDATE ADMIN_ACCOUNT SET ANSWER='$new_ans' WHERE acc_num='$accnum' ";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    echo "<script>alert('Your security answer has been changed.')</script>";
                    $old_ans = "";
                    $new_ans = "";
                    $c_ans = "";
                    $_POST['old_ans'] = "";
                    $_POST['new_ans'] = "";
                    $_POST['c_ans'] = "";
                } else {
                    echo "<script>alert('Can not change your security answer!')</script>";
                }
            } else 
                echo "<script>alert('Woops! Your old security answer is wrong!')</script>";
        }else 
            echo "<script>alert('Security answer not Matched.')</script>";
            
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
    <title>Admin Account Information Change Answer</title>
</head>
<body>
    <div class="container" style="padding-top: 10px;">
        <div style="margin-left: 10px;">
            <a href="admin_account_info.php">
                <img width="50px" src="./images/app/back.png">
            </a>
        </div>
        <form id="form" action="" method="POST" class="login-accnum">
        <table class="table" border="0" style="font-size: 30px; border-spacing: 10px;">

            <tr >
                <td align="center" colspan="2" style="padding-bottom: 5px;">
                    <h1 style="color: green;font-size: 30px;">Change Security Answer</h1>
                </td>
            </tr>


            <tr style="font-size:15px">
                <td align="left" style="width: 225px;">
                    Old Answer:
                </td>
                <td align="left" style="width: 225px;">
                   <input type="text" id="old_ans" name="old_ans" size="35" value="<?php echo $old_ans; ?>" required>
                </td>
            </tr>

            <tr style="font-size:15px">
                <td align="left" style="width: 225px;">
                    New Answer:
                </td>
                <td align="left" style="width: 225px;">
                   <input type="text" id="new_ans" name="new_ans" size="35" value="<?php echo $new_ans; ?>" required>
                </td>
            </tr>

            <tr style="font-size:15px">
                <td align="left" style="width: 225px;">
                    Confirm Answer:
                </td>
                <td align="left" style="width: 225px;">
                   <input type="text" id="c_ans" name="c_ans" size="35" value="<?php echo $c_ans; ?>" required>
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
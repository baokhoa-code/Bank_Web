<?php 

    include 'config.php';

    session_start();

    error_reporting(0);

    if (!(isset($_SESSION['accnum']) || $_SESSION['type'] == "Admin")) {
        header("Location: login.php");
    }

    $accnum = $_SESSION['accnum'];
    $sql = "SELECT * FROM ADMIN_ACCOUNT A INNER JOIN ADMIN B ON A.ADMIN=B.A_ID WHERE acc_num='$accnum'";
    $result = mysqli_query($conn, $sql);
    $row = $result->fetch_assoc();
    $accnum = $row["ACC_NUM"];
    $adname = $row["FULL_NAME"];
    $pass = $row["PASS"];
    $secanswer = $row["ANSWER"];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="./css/style_home.css">
    <title>Admin Account Information</title>
</head>
<body>
    <div class="container" style="padding-top: 10px;">
        <div style="margin-left: 10px;">
            <a href="admin_home.php">
                <img width="50px" src="./images/app/back.png">
            </a>
        </div>
        <table class="table" border="0" style="font-size: 20px; border-spacing: 10px;">

            <tr >
                <td align="center" colspan="2" style="padding-bottom: 5px;">
                    <h1 style="color: orange;font-size: 30px;">ACCOUNT INFORMATION</h1>
                </td>
            </tr>

            <tr>
                <td align="center" colspan="2">
                       <img  width="100px"  style="border-style: solid;" src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row["AVATAR"]); ?>" />
                </td>
            </tr>

            <tr style="font-size:15px">
                <td align="left" style="width: 225px;">
                    Account Number:
                </td>
                <td align="right" style="width: 225px;">
                   <span id="accnum"><?php echo $accnum; ?></span>
                </td>
            </tr>

            <tr style="font-size:15px"style="width: 225px;">
                <td align="left" style="width: 225px;">
                    Admin Name:
                </td>
                <td align="right" style="width: 225px;">
                   <span id="adname"><?php echo $adname; ?></span>
                </td>
            </tr>

            <tr style="font-size:15px">
                <td align="left" style="width: 225px;">
                    Password:
                </td>
                <td align="right" style="width: 225px;">
                    <span id="pass"><?php echo $pass; ?></span>
                </td>
            </tr>

            <tr style="font-size:15px">
                <td align="left" style="width: 225px;">
                    Security Answer:
                </td>
                <td align="right" style="width: 225px;">
                    <span id="secanswer"><?php echo $secanswer; ?></span>
                </td>
            </tr>

            <tr style="font-size:15px">
                <td align="center" style="width: 225px;">
                    <a href="admin_account_info_change_pass.php">
                        <img width="50px" src="./images/app/edit.png">
                    </a>
                    <div>Change your</div>
                    <div>password</div>
                </td>
                <td align="center" style="width: 225px;">
                    <a href="admin_account_info_change_secanswer.php">
                        <img width="50px" src="./images/app/edit.png">
                    </a>
                    <div>Change security</div>
                    <div>answer</div>
                </td>
            </tr>
        
        </table>
    </div>
    
</body>
</html>
<?php 

    include 'config.php';

    session_start();

    error_reporting(0);

    if (!(isset($_SESSION['accnum']) || $_SESSION['type'] == "User")) {
        header("Location: login.php");
    }

    $accnum = $_SESSION['accnum'];
    $sql = "SELECT * FROM USER_ACCOUNT A INNER JOIN USER B ON A.USER=B.U_ID WHERE acc_num='$accnum'";
    $result = mysqli_query($conn, $sql);
    $row = $result->fetch_assoc();
    $fullname = $row["FULL_NAME"];
    $id = $row["U_ID"];
    $email = $row["EMAIL"];
    $sex = $row["SEX"];
    $dob = $row["D_O_B"];
    $phone = $row["PHONE"];
    $address = $row["ADDRESS"];

    if (isset($_POST['submit'])) {
        $email = $_POST['email'];
        $address = $_POST['address'];

        $sql = "UPDATE USER SET EMAIL='$email', ADDRESS='$address' WHERE U_ID='$id' ";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            echo "<script>alert('Your password has been changed.')</script>";
            header("Location: user_personal_info.php");
            
        }else
            echo "<script>alert('Woops! Something is wrong!')</script>";
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="./css/style_home.css">
    <script type="text/javascript" src="./js/user_personal_info_change.js"></script>
    <title>User Personal Information Change</title>
</head>
<body>
    <div class="container" style="padding-top: 10px;">
        <div style="margin-left: 10px;">
            <a href="admin_home.php">
                <img width="50px" src="./images/app/back.png">
            </a>
        </div>
        <form onsubmit="return validate();" id="form" action="" method="POST" class="login-accnum">
            <table class="table" border="0" >

                <tr >
                    <td align="center" colspan="2" style="padding-bottom: 5px;">
                        <h1 style="color: green;font-size: 30px;">PERSONAL INFORMATION</h1>
                    </td>
                </tr>

                <tr>
                    <td align="center" colspan="2">
                           <img  width="100px"  style="border-style: solid;" src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row["AVATAR"]); ?>" />
                    </td>
                </tr>

                <tr >
                    <td align="left" colspan="2" style="border-style:  solid none solid none;padding-top: 10px;padding-bottom: 10px;">
                        <h1 style="color: blue;font-size: 20px;font-style: italic;">Identification information</h1>
                    </td>
                </tr>

                <tr style="font-size:15px">
                    <td align="left">
                        Full name:
                    </td>
                    <td align="right" >
                       <span id="fullname"><?php echo $fullname; ?></span>
                    </td>
                </tr>

                <tr style="font-size:15px">
                    <td align="left">
                        ID/Passport:
                    </td>
                    <td align="right">
                       <span id="id"><?php echo $id; ?></span>
                    </td>
                </tr>

                <tr >
                    <td align="left" colspan="2" style="border-style:  solid none solid none;padding-top: 10px;padding-bottom: 10px;">
                        <h1 style="color: blue;font-size: 20px;font-style: italic;">Additional information</h1>
                    </td>
                </tr>

                <tr style="font-size:15px">
                    <td align="left">
                        Email:
                    </td>
                    <td align="right" >
                        <input type="text" placeholder="Email" id="email" name="email" value="<?php echo $email; ?>" required>
                    </td>
                </tr>

                <tr style="font-size:15px">
                    <td align="left">
                        Sex:
                    </td>
                    <td align="right">
                        <span id="sex"><?php echo $sex; ?></span>
                    </td>
                </tr>

                <tr style="font-size:15px">
                    <td align="left">
                        Day of birth:
                    </td>
                    <td align="right">
                        <span id="dob"><?php echo $dob; ?></span>
                    </td>
                </tr>

                <tr style="font-size:15px">
                    <td align="left">
                        Phone:
                    </td>
                    <td align="right">
                        <span id="phone"><?php echo $phone; ?></span>
                    </td>
                </tr>

                <tr style="font-size:15px">
                    <td align="left">
                        Address:
                    </td>
                    <td align="right">
                        <input type="text" placeholder="Address" id="address" name="address" value="<?php echo $address; ?>" required>
                    </td>
                </tr>

                <tr style="font-size:15px">
                    <td align="center" colspan="2" style="border-style:  none none solid none;padding-bottom: 5px;"></td>
                </tr>

                <tr style="font-size:15px">
                    <td align="center" colspan="2" style="padding-top: 15px;">
                        <button type="submit" name="submit" id="submit "class="btn" >Done</button>
                    </td>
                </tr>
            
            </table>
            
        </form>
    </div>
    
</body>
</html>
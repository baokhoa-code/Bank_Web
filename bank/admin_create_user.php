<?php 
    //DECLARE AND PREPARE 
    include 'config.php';
    session_start();
    error_reporting(0);
    if (!(isset($_SESSION['accnum']) || $_SESSION['type'] == "Admin")) {
        header("Location: login.php");
    }

    $ad_accnum = $_SESSION['accnum'];

    if (isset($_POST['submit'])) {
        $u_id = $_POST['u_id'];
        
        $code = "SELECT *
                FROM USER
                WHERE U_ID='$u_id'";
        $result = mysqli_query($conn, $code);
        $row = $result->fetch_assoc()["FULL_NAME"];

        if ($row) {
            $u_id = '';
            echo "
                <script>alert('ID you input existed!')</script>
            ";
        }
        else {
            $u_id = $_POST['u_id'];
            $fullname = $_POST['fullname'];
            $sex = $_POST['sex'];
            $phone = $_POST['phone'];
            $email = $_POST['email'];
            $address = $_POST['address'];
            $time = strtotime($_POST['dob']);
            $dob = date('d-m-Y', $time);
            $sql = "INSERT INTO USER VALUE('$u_id','$fullname',STR_TO_DATE('$dob','%d-%m-%Y'),'$sex','$address','$phone','$email') ";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                echo "<script>alert('Create user success!.')</script>";
                $sql = "INSERT INTO ADMIN_TRANSACTION(T_TIME,WHO,TYPE,MESSAGE) VALUE (" . "current_timestamp()," . "'$ad_accnum','CREATE USER','USER ID: $u_id') ";
                $result = mysqli_query($conn, $sql);
                $u_id = '';
                $fullname = '';
                $sex = '';
                $phone = '';
                $email = '';
                $address = '';
                $dob = '';
            } else {
                echo "<script>alert('Can not create user!')</script>";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="./css/style_home.css">
    <script type="text/javascript" src="./js/admin_create_user.js"></script>
    <title>Admin Create User</title>
</head>
<body>
    <div class="container" style="padding-top: 10px;">
        <div style="margin-left: 10px;">
            <a href="admin_home.php">
                <img width="50px" src="./images/app/back.png">
            </a>
        </div>
        <form onsubmit="return validate();" action="" method="POST" class="login-accnum" >
            <table class="table" border="0" style="font-size: 20px; border-spacing: 15px;">

                <!--------------------------------------  Header -------------------------------------->

                <tr >
                    <td align="center" colspan="2" style="padding-bottom: 15px;">
                        <h1 style="color: blue;font-size: 30px;">CREATE USER</h1>
                    </td>
                </tr>


                <!--------------------------------------  UID -------------------------------------->

                <tr>
                    <td align="left" style="width: 225px;padding-left: 40px;">
                        ID/Passport:
                    </td>
                    <td align="left" style="width: 225px;">
                        <input type="text" id="u_id" name="u_id" value="<?php echo $u_id; ?>">
                    </td>
                </tr>

                <!--------------------------------------  Name -------------------------------------->

                <tr>
                    <td align="left" style="width: 225px;padding-left: 40px;">
                        Full name:
                    </td>
                    <td align="left" style="width: 225px;">
                        <input type="text" id="fullname" name="fullname" value="<?php echo $fullname; ?>">
                    </td>
                </tr>

                <!--------------------------------------  Sex -------------------------------------->

                <tr>
                    <td align="left" style="width: 225px;padding-left: 40px;">
                        Sex:
                    </td>
                    <td align="left" style="width: 225px;font-size: 15px;">
                        <input type="radio"  name="sex" value="Male" <?php echo ($sex== 'Male') ?  "checked" : "" ;  ?>>Male    
                        <input type="radio"  name="sex" value="Female" <?php echo ($sex== 'Female') ?  "checked" : "" ;  ?>>Female
                    </td>
                </tr>

                <!--------------------------------------  DOB -------------------------------------->

                <tr>
                    <td align="left" style="width: 225px;padding-left: 40px;">
                        Day of birth:
                    </td>
                    <td align="left" style="width: 225px;">
                        <input type="date" id="dob" name="dob" value="<?php echo $dob; ?>">
                    </td>
                </tr>

                <!--------------------------------------  Phone -------------------------------------->

                <tr>
                    <td align="left" style="width: 225px;padding-left: 40px;">
                        Phone:
                    </td>
                    <td align="left" style="width: 225px;">
                        <input type="text" id="phone" name="phone" value="<?php echo $phone; ?>">
                    </td>
                </tr>

                <!--------------------------------------  Email -------------------------------------->

                <tr>
                    <td align="left" style="width: 225px;padding-left: 40px;">
                        Email:
                    </td>
                    <td align="left" style="width: 225px;">
                        <input type="text" id="email" name="email" value="<?php echo $email; ?>">
                    </td>
                </tr>

                <!--------------------------------------  Address -------------------------------------->

                <tr>
                    <td align="left" style="width: 225px;padding-left: 40px;">
                        Address:
                    </td>
                    <td align="left" style="width: 225px;">
                        <input type="text" id="address" name="address" value="<?php echo $address; ?>">
                    </td>
                </tr>
                
                <!--------------------------------------  Button -------------------------------------->

                <tr style="font-size:15px">
                    <td align="center" colspan="2" style="padding-top: 25px;">
                        <button type="submit" name="submit" id="submit "class="btn" >Done</button>
                    </td>
                </tr>
            
            </table>
        </form>
    </div>

</body>
</html>
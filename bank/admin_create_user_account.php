<?php 
    //DECLARE AND PREPARE 
    include 'config.php';
    session_start();
    error_reporting(0);
    if (!(isset($_SESSION['accnum']) || $_SESSION['type'] == "Admin")) {
        header("Location: login.php");
    }
    $accnum = $_SESSION['accnum'];
    $u_accnum;
    $u_pass;
    $ad_accnum = $_SESSION['accnum'];

    //FUNCTIONS TO GET RANDOM USER ID, USER ACOUNT NUMBER AND PASSWORD
    function generateRandomString_UA() {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = 'UA';
        for ($i = 0; $i < 10; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    function generateRandomString_PASS() {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 6; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    //FIND VALID UID, ACCNUM AND PASSWORD, CHECK IF RANDOM USER ID AND USER ACCOUNT NUMBER EXIST IN DATABASE
    do{
        $randomString = generateRandomString_UA();
        $sql = "SELECT * FROM USER_ACCOUNT WHERE ACC_NUM='$randomString'";
        $result = mysqli_query($conn, $sql);
        $u_accnum = $randomString;
    }while($result->num_rows > 0);
    $u_pass = generateRandomString_PASS();

    //SUBMIT HANDLING
    if (isset($_POST['submit'])) {
        $balance = $_POST['balance'];
        $secanswer = $_POST['secanswer'];
        $u_id = $_POST['u_id'];
        $sql = "INSERT INTO USER_ACCOUNT(ACC_NUM,USER,PASS,CREATE_DATE,BALANCE,ANSWER) VALUE('$u_accnum','$u_id','$u_pass'," . "current_timestamp()" . ",$balance,'$secanswer') ";
        $result = mysqli_query($conn, $sql);
        if ($result) {

            echo "<script>alert('Create user account: " . $u_accnum . " success!. Here is user\'s password: " . $u_pass . "')</script>";
            $sql = "INSERT INTO ADMIN_TRANSACTION(T_TIME,WHO,TYPE,MESSAGE) VALUE(" . "current_timestamp()," . "'$ad_accnum','CREATE USER ACCOUNT','ACCOUNT NUMBER: $u_accnum') ";
            $result = mysqli_query($conn, $sql);
            
            $image = addslashes(file_get_contents($_FILES['upfile']['tmp_name']));
            $conn->query("UPDATE USER_ACCOUNT SET AVATAR = '$image' WHERE acc_num='$u_accnum' ")
                                or die("Cannot insert image into DB: " . $conn->connect_error);

            $balance = '';
            $secanswer = '';
            $u_id = '';
            $_POST['u_id']='0';
            do{
                $randomString = generateRandomString_UA();
                $sql = "SELECT * FROM USER_ACCOUNT WHERE ACC_NUM='$randomString'";
                $result = mysqli_query($conn, $sql);
                $u_accnum = $randomString;
            }while($result->num_rows > 0);
            $u_pass = generateRandomString_PASS();
            
        } else {
            echo "<script>alert('Can not create user account!')</script>";
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
    <script type="text/javascript" src="./js/admin_create_user_account.js"></script>
    <title>Admin Create User</title>
</head>
<body>
    <div class="container" style="padding-top: 10px;">
        <div style="margin-left: 10px;">
            <a href="admin_home.php">
                <img width="50px" src="./images/app/back.png">
            </a>
        </div>
        <form onsubmit="return validate();" id="form" action="" method="POST" class="login-accnum" enctype="multipart/form-data">
            <table class="table" border="0" style="font-size: 20px; border-spacing: 25px;">

                <!--------------------------------------  Header -------------------------------------->

                <tr >
                    <td align="center" colspan="2" style="padding-bottom: 15px;">
                        <h1 style="color: blue;font-size: 30px;">CREATE USER ACCOUNT</h1>
                    </td>
                </tr>

                <!--------------------------------------  Avatar -------------------------------------->

                <tr>
                    <td align="left" style="width: 225px;padding-left: 40px;">
                        <input type="file"  accept="image/*" name="upfile" id="upfile"  onchange="loadFile(event)" style="display: none;">
                        <label for="upfile" style="cursor: pointer;">Upload Avatar:</label>
                        <script>
                            var loadFile = function(event) {
                                var image = document.getElementById('output');
                                image.src = URL.createObjectURL(event.target.files[0]);
                            };
                        </script>
                    </td>
                    <td align="left" style="width: 225px;">
                        <img id="output" width="100px" />
                    </td>
                </tr>

                <!--------------------------------------  AccNum -------------------------------------->

                <tr>
                    <td align="left" style="width: 225px;padding-left: 40px;">
                        Account Number:
                    </td>
                    <td align="left" style="width: 225px;">
                        <span ><?php echo $u_accnum; ?></span>
                    </td>
                </tr>

                <!--------------------------------------  UID -------------------------------------->

                <tr>
                    <td align="left" style="width: 225px;padding-left: 40px;">
                        ID/Passport:
                    </td>
                    <td align="left" style="width: 225px;">
                       <select id="u_id" name="u_id" style="font-size: 15px;">
                            <option value="0">Select User ID</option>
                            <?php
                                
                                $sql = "SELECT U_ID FROM USER";
                                $result = mysqli_query($conn, $sql);
                                while($row = $result->fetch_assoc()){
                                    echo "<option value=\"" . $row['U_ID'] . "\" >" . $row['U_ID'] . "</option>";
                                }

                            ?>
                        </select>
                    </td>
                </tr>


                <!--------------------------------------  Balance -------------------------------------->

                <tr>
                    <td align="left" style="width: 225px;padding-left: 40px;">
                        Balance:
                    </td>
                    <td align="left" style="width: 225px;">
                        <input type="number" min="100" id="balance" name="balance" value="<?php echo $balance; ?>" style="font-size: 15px;">
                    </td>
                </tr>
              
                <!--------------------------------------  SecAnswer -------------------------------------->

                <tr>
                    <td align="center" colspan="2">
                        <h4 style="color:red">What is your favorite integer?</h4>
                    </td>
                </tr>

                <tr>
                    <td align="left" style="width: 225px;padding-left: 40px;">
                        Security Answer:
                    </td>
                    <td align="left" style="width: 225px;">
                        <input type="number" id="secanswer" name="secanswer" value="<?php echo $secanswer; ?>" style="font-size: 15px;">
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
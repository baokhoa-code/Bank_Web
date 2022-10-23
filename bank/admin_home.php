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
    $username = $row["FULL_NAME"];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="./css/style_home.css">
    <title>Admin Home</title>
</head>
<body>
    <div class="container">
        <form action="" method="POST" class="login-accnum">
            <table class="table" border="0">

                <tr>
                    <td align="center" style="width: 225px;">
                           <img  width="100px" src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row["AVATAR"]); ?>" />
                    </td>
                    <td align="center" style="width: 225px;">
                           <div style="display: inline;">
                               <h1 style="display: inline;padding-bottom: 60px;" class="hi"><?php echo "<span style=\"color: red;\">Hi,</span><span style=\"color: purple;\"> ADMIN </span>"; ?></h1>
                               <h1 style="display: inline;padding-bottom: 60px;" class="hi"><?php echo "<div style=\"color: purple;\"> " . $username . "</dive>"; ?></h1>
                               <script type="text/javascript" charset="utf-8">
                                    let a;
                                    let dateTime;
                                    setInterval(() => {
                                        a = new Date();
                                        var date = a.getFullYear()+'-'+(a.getMonth()+1)+'-'+a.getDate();
                                        var time = a.getHours() + ":" + a.getMinutes() + ":" + a.getSeconds();
                                        dateTime = date+' '+time;
                                        document.getElementById('curdate').innerHTML = dateTime;
                                    }, 1000);
                              </script>
                              <h3 style="align-items: right;" class="hi"><span id="curdate"></span></h3>
                           </div>
                    </td>
                </tr>

                <tr>
                    <td align="center" style="width: 225px;">
                        <a href="admin_personal_info.php">
                            <img width="80px" src="./images/admin/personal_information.png">
                        </a>
                        <div>Personal Information</div>
                    </td>
                    <td align="center" style="width: 225px;">
                        <a href="admin_account_info.php">
                            <img width="80px" src="./images/admin/admin_information.png">
                        </a>
                        <div>Account Information</div>
                    </td>
                </tr>

                <tr>
                    <td align="center" style="width: 225px;">
                        <a href="admin_transaction.php?page=1">
                            <img width="80px" src="./images/admin/transaction.png">
                        </a>
                        <div>Transaction</div>
                    </td>
                    <td align="center" style="width: 225px;">
                        <a href="admin_show_all_user.php?page=1">
                            <img width="80px" src="./images/admin/show_all_users.png">
                        </a>
                        <div>Show all users</div>
                    </td>
                </tr>

                <tr>
                    <td align="center" style="width: 225px;">
                        <a href="admin_create_user.php">
                            <img width="80px" src="./images/admin/create_user.png">
                        </a>
                        <div>Create user</div>
                    </td>
                    <td align="center" style="width: 225px;">
                        <a href="admin_create_user_account.php">
                            <img width="80px" src="./images/admin/create_user.png">
                        </a>
                        <div>Create user account</div>
                    </td>
                </tr>

                <tr>
                    <td align="center" style="width: 225px;">
                        <a href="admin_check_user.php">
                            <img width="80px" src="./images/admin/check_user.png">
                        </a>
                        <div>Check user</div>
                    </td>
                    <td align="center" style="width: 225px;">
                        <a href="logout.php">
                            <img width="70px" src="./images/admin/logout.png">
                        </a>
                        <div>Log out</div>
                    </td>
                </tr>
            
            </table>
              
        </form>
        
    </div>
    
</body>
</html>
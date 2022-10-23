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
    $username = $row["FULL_NAME"];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="./css/style_home.css">
    <title>User Home</title>
</head>
<body>
    <div class="container">
        <form action="" method="POST" class="login-accnum">
            <table class="table" border="0">

                <tr>
                    <td align="center" style="width: 225px;">
                           <img  width="100px" src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['AVATAR']); ?>" />
                    </td>
                    <td align="center" style="width: 225px;">
                           <div style="display: inline;">
                               <h1 style="display: inline;padding-bottom: 60px;" class="hi"><?php echo "<span style=\"color: red;\">Hi,</span><span style=\"color: purple;\"> USER </span>"; ?></h1>
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
                        <a href="user_personal_info.php">
                            <img width="80px" src="./images/user/personal_information.png">
                        </a>
                        <div>Personal Information</div>
                    </td>
                    <td align="center" style="width: 225px;">
                        <a href="user_account_info.php">
                            <img width="80px" src="./images/user/account_information.png">
                        </a>
                        <div>Account Information</div>
                    </td>
                </tr>

                <tr>
                    <td align="center" style="width: 225px;">
                        <a href="user_transaction.php?page=1">
                            <img width="80px" src="./images/user/transaction.png">
                        </a>
                        <div>Transaction</div>
                    </td>
                    <td align="center" style="width: 225px;">
                        <a href="user_withdrawal.php">
                            <img width="80px" src="./images/user/withdrawal.png">
                        </a>
                        <div>Withdrawal</div>
                    </td>
                </tr>

                <tr>
                    <td align="center" style="width: 225px;">
                        <a href="user_recharge.php">
                            <img width="80px" src="./images/user/recharge.png">
                        </a>
                        <div>Recharge</div>
                    </td>
                    <td align="center" style="width: 225px;">
                        <a href="user_transfer.php">
                            <img width="80px" src="./images/user/transfer.png">
                        </a>
                        <div>Transfer</div>
                    </td>
                </tr>

                <tr>
                    <td colspan="2" align="center">
                        <a href="logout.php">
                            <img width="70px" src="./images/user/logout.png">
                        </a>
                        <div>Log out</div>
                    </td>
                </tr>
            
            </table>
             
        </form>
        
    </div>
    
</body>
</html>
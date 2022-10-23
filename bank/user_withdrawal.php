<?php
    include 'config.php';

    session_start();

    error_reporting(0);

    if (!(isset($_SESSION['accnum']) || $_SESSION['type'] == "User")) {
        header("Location: login.php");
    }

    $accnum = $_SESSION['accnum'];

    if (isset($_POST['submit'])) {
        $code = "SELECT BALANCE
                FROM USER_ACCOUNT
                WHERE ACC_NUM='$accnum'";
        $result = mysqli_query($conn, $code);
        $row = $result->fetch_assoc();
        $money = $row["BALANCE"];

        $moneyminus = $_POST["data"];
        
        if (!is_numeric($moneyminus)) {
            echo "
                <script>
                    alert('Money you input invalid! Input again.');
                    header('Location: user_withdrawal.php')
                </script>
            ";
        }
        else if ($moneyminus <= 0) {
            echo "
                <script>
                    alert('Money you input must greater than 0!');
                    header('Location: user_withdrawal.php')
                </script>
            ";
        }
        else if ($moneyminus > $money) {
            echo "
                <script>
                    alert('Money you input must less than current balance! Current balance is $$money.');
                    header('Location: user_withdrawal.php')
                </script>
            ";
        }
        else {
            $moneytotal = $money - $moneyminus;
            $code = "UPDATE USER_ACCOUNT 
                    SET BALANCE='$moneytotal'
                    WHERE ACC_NUM='$accnum'";
            $result = mysqli_query($conn, $code);

            if ($result) {
                $code = "INSERT INTO USER_TRANSACTION(T_TIME,WHO,TYPE,MESSAGE) 
                VALUE 
                (" . "current_timestamp()," . " '$accnum','WITHDRAWAL','- $$moneyminus')";
                $result = mysqli_query($conn, $code);
                echo "
                    <script>
                        alert('You have withdrawal successfully with money is $$moneyminus. Current balance is $$moneytotal.');
                        header('Location: recharge.php')
                    </script>
                ";
            }
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="./css/style_login_regist.css">
    <link rel="stylesheet" type="text/css" href="./css/style_home.css">
    <title>Withdrawal</title>
</head>
<body>
    <div class="container">
        <div style="margin-left: 10px;">
                <a href="user_home.php">
                    <img width="50px" src="./images/app/back.png">
                </a>
        </div>

        <h1 style="color: red; font-size: 30px; text-align: center;">
            WITHDRAWAL<br><br>
        </h1>

        <form action="" method="POST" class="login-accnum">
            <br><br><br><br>
            <div class="input-group">
                <input type="text" placeholder="Enter money to recharge" name="data" required style="font-size: 20px; margin-left: auto; margin-right: auto">
            </div>

            <br><br><br><br>

            <div class="input-group">
                <button name="submit" class="btn" style="width: 50%; margin-left: auto; margin-right: auto;">
                    Withdrawal
                </button>
            </div>
        </form>
    </div>
</body>
</html>
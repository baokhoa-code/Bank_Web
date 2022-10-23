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
        $money_current1 = $result->fetch_assoc()["BALANCE"];
        
        $account_to = strtoupper($_POST["to"]);

        $code = "SELECT UA.BALANCE, U.FULL_NAME
                FROM USER_ACCOUNT UA JOIN USER U ON UA.USER = U.U_ID
                WHERE UA.ACC_NUM='$account_to'";
        $result = mysqli_query($conn, $code);
        $row = $result->fetch_assoc();
        $money_current2 = $row["BALANCE"];
        $fullname_to = $row["FULL_NAME"];

        if ($fullname_to && $account_to != strtoupper($accnum)) {
            $moneytransfer = $_POST['data'];

            if (!is_numeric($moneytransfer)) {
                echo "
                    <script>
                        alert('Money you input invalid! Input again.');
                        header('Location: user_transfer.php')
                    </script>
                ";
            }
            else if ($moneytransfer <= 0) {
                echo "
                    <script>
                        alert('Money you input must greater than 0!');
                        header('Location: user_transfer.php')
                    </script>
                ";
            }
            else if ($moneytransfer > $money_current1) {
                echo "
                    <script>
                        alert('Money you input must less than current balance! Current balance is $$money_current1.');
                        header('Location: user_transfer.php')
                    </script>
                ";
            }
            else {
                $money_total1 = $money_current1 - $moneytransfer;
                $money_total2 = $money_current2 + $moneytransfer;

                $code = "UPDATE USER_ACCOUNT 
                        SET BALANCE='$money_total1'
                        WHERE ACC_NUM='$accnum'";
                $result = mysqli_query($conn, $code);

                if ($result) {
                    $code = "UPDATE USER_ACCOUNT SET BALANCE='$money_total2'
                            WHERE ACC_NUM='$account_to'";
                    $result = mysqli_query($conn, $code);
                    if ($result) {
                        $message = $_POST['message'];
                        $code = "INSERT INTO USER_TRANSACTION(T_TIME,WHO,TYPE,MESSAGE) 
                                VALUE 
                                (" . "current_timestamp()," . " '$accnum','TRANSFER','to 
                                    $account_to - $$moneytransfer PS: $message')";
                        $result = mysqli_query($conn, $code);

                        $code = "INSERT INTO USER_TRANSACTION(T_TIME,WHO,TYPE,MESSAGE) 
                                VALUE 
                                (" . "current_timestamp()," . " '$account_to','RECEIVE',' from $accnum + $$moneytransfer PS: $message')";
                        $result = mysqli_query($conn, $code);
                        echo "
                            <script>
                                alert('You have transfered to $account_to ($fullname_to) successfully with money is $$moneytransfer. Current balance is $$money_total1.');
                                header('Location: user_transfer.php')
                            </script>
                        ";
                    }
                    else {
                        $code = "UPDATE ON USER_ACCOUNT SET BALANCE='$money_current1'
                                WHERE ACC_NUM='$accnum";
                        $result = mysqli_query($conn, $code);

                        $code = "UPDATE ON USER_ACCOUNT SET BALANCE='$money_current2'
                                WHERE ACC_NUM='$account_to";
                        $result = mysqli_query($conn, $code);
                        echo "
                                <script>
                                    alert('Transaction failed!');
                                    header('Location: user_transfer.php')
                                </script>
                            ";
                    }
                }
                else {
                    $code = "UPDATE ON USER_ACCOUNT SET BALANCE='$money_current1'
                        WHERE ACC_NUM='$accnum";
                    $result = mysqli_query($conn, $code);

                    $code = "UPDATE ON USER_ACCOUNT SET BALANCE='$money_current2'
                            WHERE ACC_NUM='$account_to";
                    $result = mysqli_query($conn, $code);

                    echo "
                        <script>
                            alert('Transaction failed!');
                            header('Location: user_transfer.php')
                        </script>
                    ";
                }
            }
        }
        else {
            echo "
                <script>
                    alert('Account number you input invalid! Input again.');
                    header('Location: user_transfer.php')
                </script>
            ";
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
	<title>Transfer</title>
</head>

<body>
	<div class="container">
		<div style="margin-left: 10px;">
                <a href="user_home.php">
                    <img width="50px" src="./images/app/back.png">
                </a>
        </div>

        <h1 style="color: blue; font-size: 30px; text-align: center;">
            TRANSFER<br><br>
        </h1>

		<form action="" method="POST" class="login-accnum">
			<br>

            <div class="input-group">
                <input type="text" placeholder="Enter account number you want to transfer" name="to" required style="font-size: 20px;">
            </div>

            <br>

            <div class="input-group">
                <input type="text" placeholder="Enter money to transfer" name="data" required style="font-size: 20px; margin-left: auto; margin-right: auto">
            </div>

            <br>

            <div class="input-group">
                <input type="text" placeholder="Enter message" name="message" required style="font-size: 20px; margin-left: auto; margin-right: auto">
            </div>

            <br>

            <div class="input-group">
                <button name="submit" class="btn" style="width: 50%; margin-left: auto; margin-right: auto;">
                    Transfer
                </button>
            </div>
		</form>

	</div>
</body>
</html>
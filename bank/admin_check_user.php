<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="./css/style_login_regist.css">
        <link rel="stylesheet" type="text/css" href="./css/style_home.css">

    	<title>Check user</title>
    </head>

    <body>
    	<div class="container" style="padding-top: 10px;">
            <div style="margin-left: 10px;">
                <a href="admin_home.php">
                    <img width="50px" src="./images/app/back.png">
                </a>
            </div>

            <font face="Georgia" style="align-items: center;">
                <h1 style="color: red; font-size: 30px; text-align: center;">
                    CHECK USER<br><br>
                </h1>
            </font>

            <form action="" method="POST" class="login-accnum">
            	<div class="input-group">
                    <input type="text" placeholder="Account Number or ID" name="id" required>
                </div>

                <br>

                <div class="input-group">
                    <button name="submit" class="btn" style="width: 50%; margin-left: auto; margin-right: auto;">
                        Check
                    </button>
                </div>
            </form>

            <br>
            <table class="content-table" style="font-size:12px; height: auto;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Full name</th>
                        <th>Account number</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        include 'config.php';
                        
                        if (isset($_POST['submit'])) {
                            $data = $_POST['id'];

                            $code_useraccount = "SELECT BALANCE FROM USER_ACCOUNT
                                    WHERE ACC_NUM='$data'";

                            $result_useraccount = mysqli_query($conn, $code_useraccount);

                            $code_user = "SELECT FULL_NAME FROM USER
                                    WHERE U_ID='$data'";

                            $result_user = mysqli_query($conn, $code_user);

                            if ($result_useraccount->num_rows == 0 && $result_user->num_rows == 0) {
                                echo "
                                    <tr>
                                        <td colspan=3>Not found</td>
                                    </tr>
                                ";
                            }

                            else if ($result_useraccount->num_rows > 0) {
                                $code = "SELECT U.U_ID, U.FULL_NAME, UA.ACC_NUM
                                        FROM USER_ACCOUNT UA JOIN USER U ON UA.USER = U.U_ID
                                        WHERE UA.ACC_NUM='$data'";
                                $result = mysqli_query($conn, $code);
                                $row = $result->fetch_assoc();

                                echo "
                                    <tr>
                                        <th>" . $row['U_ID'] . "</th>
                                        <th>" . $row['FULL_NAME'] . "</th>
                                        <th>" . $row['ACC_NUM'] . "</th>
                                    </tr>
                                ";
                            }
                            else if ($result_user->num_rows > 0){
                                $code = "SELECT UA.ACC_NUM, U.FULL_NAME, U.U_ID
                                        FROM USER_ACCOUNT UA JOIN USER U ON UA.USER = U.U_ID
                                        WHERE U.U_ID='$data'";
                                $result = mysqli_query($conn, $code);
                                
                                while ($row = $result->fetch_assoc()) {
                                    echo "
                                        <tr>
                                            <th>" . $row["U_ID"] . "</th>
                                            <th>" . $row['FULL_NAME'] . "</th>
                                            <th>" . $row["ACC_NUM"] . "</th>
                                        </tr>
                                    ";
                                }
                            }
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </body>
</html>
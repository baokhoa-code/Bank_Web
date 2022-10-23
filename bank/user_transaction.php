<?php 

    include 'config.php';

    session_start();

    error_reporting(0);

    if (!(isset($_SESSION['accnum']) || $_SESSION['type'] == "User")) {
        header("Location: login.php");
    }

    $accnum = $_SESSION['accnum'];
    

?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="./css/style_home.css">
        <title>User Transaction</title>
    </head>

    <body>

        <div class="container" style="padding-top: 20px">
            <div style="margin-left: 10px;margin-top: 0px;">
                <a href="user_home.php">
                    <img width="45px" src="./images/app/back.png">
                </a>
            </div>
            <div><h1 style="color: orange;font-size: 30px;text-align: center;padding: 20px 20px 40px;">ACCOUNT TRANSACTION</h1></div>
            <table class="content-table" style="font-size:12px;height: auto;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>TIME</th>
                        <th>TYPE</th>
                        <th>MESSAGE</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        include './config.php';

                        // DEFINE NUMBER OF RECORD APPEAR
                        $results_per_page = 5;

                        // FIND NUMBER RECORD
                        $sql="SELECT COUNT(*) FROM USER_TRANSACTION WHERE WHO='$accnum'";

                        $result = mysqli_query($conn, $sql);
                        $row = $result->fetch_row();
                        $number_of_results = $row[0];

                        // CALCULATE NUMBER OF PAGE
                        $number_of_pages = ceil($number_of_results/$results_per_page);
                        $temp;

                        // FIND CUURENT PAGE
                        if (!isset($_GET['page'])) {
                            $page = 1;
                        } else {
                            $page = $_GET['page'];
                            $temp = $_GET['page'];
                        }

                        // CALCULATE LIMIT STARTING NUMBER FOR CURRENT PAGE
                        $this_page_first_result = ($page-1)*$results_per_page;

                        // // QUERY CONTENT (NUMBER OF RECORDS) WILL APPEAR IN CUURENT PAGE
                        $sql="SELECT * FROM USER_TRANSACTION WHERE WHO='$accnum' LIMIT " . $this_page_first_result . ',' .  $results_per_page;
                        $result = mysqli_query($conn, $sql);

                        while($row = mysqli_fetch_array($result)) {
                            echo "<tr> <td>" . $row['T_ID'] . "</td><td>" . $row['T_TIME'] . "</td><td>" . $row['TYPE'] . "</td><td>" . $row['MESSAGE'] . "</td>";
                        }

                    ?>
                     <tr>
                        <td colspan="4" align="center">
                            <?php
                                if($page != '1')
                                    echo '<a href="user_transaction.php?page=' . $temp - 1 . '">Previous </a> ';
                                for ($page=1;$page<=$number_of_pages;$page++) {
                                    echo '<a href="user_transaction.php?page=' . $page . '"> ' . $page . ' </a> ';
                                }
                                echo '<a href="user_transaction.php?page=' . $temp + 1 . '"> Next</a> ';
                            ?>
                        </td>
                    </tr> 
                </tbody>
            </table>
        </div>

    </body>

</html>
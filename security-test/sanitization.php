<?php

$nameError ="";
$passwordError ="";
$attempt = 0;

if(isset($_POST['submit'])) {

    $attempt = $_POST['hidden'];

    if ($attempt < 3) {

        if (!empty($_POST['name']) ||
            !empty($_POST['password'])){

            require_once 'database.php';
            try {
                $sQuery = $db->prepare('SELECT * FROM user WHERE name = :sName AND password = :sPassword');

                $sQuery->bindValue(':sName', $_POST['name']);
                $sQuery->bindValue(':sPassword', hash("sha256", $_POST['password']));
                $sQuery->execute();
                $aUsers = $sQuery->fetchAll();

                if ($sQuery->rowCount()) {
                    echo '<h2>Login Success</h2>';
                    exit;
                } else {
                    $attempt++;
                    echo '<h2>Login Error, number of attempts is ' . $attempt . '</h2>';


                    $ip = $_SERVER["REMOTE_ADDR"];
                    $sQueryAttempt = $db->prepare("insert into ip (id, address) values (null, '$ip')");
                    $sQueryAttempt->execute();

                    if( $sQueryAttempt->rowCount() ) {

                        $sQueryAttempt = $db->prepare("SELECT COUNT(*) FROM ip WHERE address LIKE '$ip'");
                        $sQueryAttempt->fetchAll();

//                        $result = mysqli_query($db, $sQueryAttempt) or die( mysqli_error($db));
//
//                        $count = mysqli_fetch_array($result, MYSQLI_NUM);
//
//                        if ($count[0] > 3) {
//                            echo "Your are allowed 3 attempts in 10 minutes";
//                        }
                    }

                }




















            } catch (PDOException $exception) {
                echo '{"status":0, "message":"exception cannot login"}';
            }
        }

        if ($attempt == 3) {
            echo '<h2>Login limit exceed</h2>';
        }


    }

    if ($_POST['name'] != "") {
        $_POST['name'] = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        $nameError = "<span class='valid'>" . $_POST['name'] . "</span> is Sanitized an Valid Name.";

        if ($_POST['name'] == "") {
            $nameError = "<span class='invalid'>Please enter a valid name.</span>";
        }
    } else {
        $nameError = "<span class='invalid'>Please enter your name.</span>";
    }


    if ($_POST['password'] != "") {
        $_POST['password'] = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
        !(strlen($_POST['password']) >= 6 && strlen($_POST['password']) <= 20);
        $passwordError = "<span class='valid'>" . $_POST['password'] . "</span> is Sanitized an Valid Password.";

        if ($_POST['password'] == "") {
            $passwordError = "<span class='invalid'>Please enter a valid password.</span>";
        }
    } else {
        $passwordError = "<span class='invalid'>Please enter your password.</span>";
    }
}







?>



<!DOCTYPE html>
<html>
<head>
    <title>Form Sanitization and Validation</title>
    <meta content="noindex, nofollow" name="robots">
    <link href="style.css" rel="stylesheet">
</head>
<body>
<div class="maindiv">
    <div class="form_div">
        <div class="title">
            <h2>Form Sanitization and Validation</h2>
        </div>
        <form action="sanitization.php" method="post">

            <p>* Required Fields</p>

            <?php
            echo "<input type='hidden' name='hidden' value='".$attempt."'>" ;
            ?>

            Name: <span class="invalid">*</span>
            <input class="input" name="name" type="text" value="">
            <p><?php echo $nameError;?></p>

            Password: <span class="invalid">*</span>
            <input class="input" name="password" type="text" value="">
            <p><?php echo $passwordError;?></p>

            <input class="submit" name="submit" type="submit" value="Submit" <?php if($attempt==3){?> disabled="disabled" <?php }?>>
        </form>
    </div>
</div> <!-- HTML Ends Here -->
</body>
</html>
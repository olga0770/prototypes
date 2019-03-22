<?php


if(isset($_POST['submit'])) {

    if (!empty($_POST['username']) ||
        !empty($_POST['password']) ||
        filter_var($_POST['username'], FILTER_SANITIZE_STRING) )
    {
        $userName = $_POST['username'];

        require_once 'database.php';
        try {

            // begin trans

            // first reset the lock if applicable
            $sQueryAttempt = $db->prepare('UPDATE user
                      SET timeOfAccountLock = null,
                          numberOfFailedAttempts = 0
                      WHERE name = :sUserName and timeOfAccountLock is not null 
                        and now() > timeOfAccountLock + INTERVAL 5 MINUTE');

            $sQueryAttempt->bindValue(':sUserName', $userName);
            $sQueryAttempt->execute();

            // select non-blocked user
            $sQuery = $db->prepare('SELECT * FROM user WHERE name = :sUserName 
                     AND password = :sPassword and (timeOfAccountLock is null or now() > timeOfAccountLock + INTERVAL 5 MINUTE)' );

            $sQuery->bindValue(':sUserName', $userName);
            $sQuery->bindValue(':sPassword', hash("sha256", $_POST['password']));
            $sQuery->execute();
            $sQuery->fetchAll();

            if ($sQuery->rowCount()) {
                // we got one non-blocked, existing user with correct password
                echo '<h2>Login Success</h2>';
            } else {
                // invalid for any reason: username wrong, pwd wrong, blocked account
                echo '<h2>Error - user name or password is wrong and I won\'t tell you which of them was wrong</h2>';

                $sQueryAttempt = $db->prepare('UPDATE user 
                      SET timeOfAccountLock = if(numberOfFailedAttempts < 2, null, now()),
                          numberOfFailedAttempts = numberOfFailedAttempts + 1
                      WHERE name = :sUserName and timeOfAccountLock is null');

                $sQueryAttempt->bindValue(':sUserName', $userName);
                $sQueryAttempt->execute();
                echo '{"status":1, "ok"}';
            }


            $sQueryLock = $db->prepare('select * from user where numberOfFailedAttempts = 3');
            $sQueryLock->execute();
            $sQueryLock->fetchAll();
            if ($sQueryLock->rowCount()){
                echo '<h1>You have to wait for 5 min for the next login attempt</h1>';
            }


            // commit trans

        } catch (PDOException $exception) {
            echo '{"status":0, "message":"exception cannot login"}';
        }
    }
}

// $oldPassword_123456 = "8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92";


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <title>Form Sanitization and Validation</title>
    <meta content="noindex, nofollow" name="robots">
    <link href="style.css" rel="stylesheet">
</head>
<body>

        <form action="sanitization2.php" method="post">

            <p>* Required Fields</p>



            <label>Name:
                <input class="input" name="username" type="text" value=""></label>
            <br><br>

            <label>Password:
                <input class="input" name="password" type="text" value="">
            </label>

            <input class="submit" name="submit" type="submit" value="Submit">
        </form>

</body>
</html>
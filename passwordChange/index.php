<!DOCTYPE html>
<html lang="en">

<head>
    <title>Change your password</title>
    
    <?php
        //Importing header tags
        include("../components/headerparamsForm.php");
    ?>
</head>

<body>
    <div class="container" id="container">
        <div class="form-container sign-in-container">

            <form action="index.php" method="post">

                <h1>Change Password</h1>

                <div class="errors-block">
                    <span class="password-error">Password must contain at least 8 characters <br> (1 special, 1  uppercase letter, 1 number).</span>
                    <span class="password-error old-new">New password can not be the same as the old one.</span>
                    <span class="password-error similiarity">Provided passwords are not the same.</span>
                </div>

                <input type="password" placeholder="Your current password" name="password" required style="margin-top: 10px;"/>
                <input type="password" placeholder="Your new password" name="newpassword" required style="margin-top: 10px;"/>
                <input type="password" placeholder="Confirm new password" name="newpassword" required style="margin-top: 10px;"/>
                <button type="submit">Submit</button>
            </form>

        </div>

        <div class="overlay-container">

            <div class="overlay">

                <div class="overlay-panel overlay-right">
                    <h1>Hello, Friend!</h1>
                    <p>It looks like you want to change your password. Enter your current and new password.</p>
                    <a href="../userProfile/"><button class="ghost">Back to your profile</button></a>
                </div>

            </div>
            
        </div>
    </div>

    <!--Internal Scripts Import-->
    <script src="./script.js"></script>

    <?php

        try
        {
            //Checking if user is logged in, otherwise redirecting to login form
            if(!isset($_SESSION['userID']))
            {
                FailureMessage("You have to be logged in to change your password here. You can recover it using 'Forgot your password' through login form.", "../loginForm/");
                die;
            }

            //Checking if user used form
            if(isset($_POST['newpassword']))
            {
                $currpassword = $_POST['password'];

                //Fetching for user current password
                $stmt = $conn->prepare("SELECT h_password FROM user WHERE user_id = :userID");
                $stmt->bindParam(':userID', $_SESSION['userID']);
                $stmt->execute();
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                //Checking if provided old password is correct
                if(!password_verify($currpassword, $user['h_password']))
                {
                    FailureMessage("Provided password is incorrect. Please try again or use 'Forgot your password' option through login form.", "index.php");
                }
                else
                {
                    //Hashing new, given password
                    $password = $_POST['newpassword'];
                    $password = password_hash($password, PASSWORD_DEFAULT);

                    //Updating user's password in database
                    $stmt = $conn->prepare("UPDATE user SET h_password = :password WHERE user_id = :userID");
                    $stmt->bindParam(':password', $password);
                    $stmt->bindParam(':userID', $_SESSION['userID']);
                    $stmt->execute();

                    SuccessMessage("You password has been successfully changed. Now you can use it.", "../main/");
                }
            }
        }
        catch(PDOException $e) 
        {
            ?>
            <script>window.location.replace("../errors/uncaught.php?errorCode=<?php echo $e->getMessage(); ?>");</script>
            <?php
        }
        
    ?>

</body>
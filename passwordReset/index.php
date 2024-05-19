<!DOCTYPE html>
<html lang="en">

<head>
    <title>Recover Password</title>

    <?php
        //Importing header tags
        include("../components/headerparamsForm.php");
    ?>
</head>

<body>
    <div class="container" id="container">
        <div class="form-container sign-in-container">
            <form action="index.php" method="post">

                <?php
                    if(isset($_GET['token']))
                    {
                        ?>
                        <h1>Change Password</h1>
                        <span class="password-error">Password must contain at least 8 characters <br> (1 special, 1  uppercase letter, 1 number).</span><br/>
                        <input type="password" placeholder="Your new password" name="password" required style="margin-top: 10px;"/>
                        <input type="text" name="token" value = <?php echo $_GET['token'] ?> hidden required/>
                        <?php
                    }
                    else
                    {
                        ?>
                        <h1>Reset password</h1>
                        <span>Enter your mail below to, and we will send you link to reset password.</span>
                        <input type="email" placeholder="Email" name="mail" required style="margin-top: 10px;"/>
                        
                        <?php
                    }
                ?>

                <button type="submit">Submit</button>
            </form>
        </div>

        <div class="overlay-container">
            <div class="overlay">

                <div class="overlay-panel overlay-right">
                    <h1>Hello, Friend!</h1>
                    <?php
                        if(isset($_GET['token']))
                        {
                            ?>
                            <p>After entering password recovery link from your mail you can now change your password.</p>
                            <?php
                        }
                        else
                        {
                            ?>
                            <p>It looks like you forgot your password. Don't worry! Enter your mail and we will help you recover it.</p>
                            <a href="../loginForm"><button class="ghost">Back to login</button></a>
                            <?php
                        }
                    ?>
                </div>

            </div>
        </div>
    </div>
    
    <?php
            //TryCatch block
            try 
            {
                //Checking if user isn't logged in already
                if(isset($_SESSION['userID']))
                {
                    FailureMessage("You're already logged in. What are you looking for?", "../main/");
                    die;
                }

                //Deleting expired records in the database
                $currDate = new DateTimeImmutable();
                $currDate = $currDate->format('Y-m-d H:i:s');
                $stmt = $conn->prepare("DELETE FROM password_reset WHERE expire_time <= :currDate");
                $stmt->bindParam(':currDate', $currDate);
                $stmt->execute();

                //Checking which form should be used with e-mail to send link or password change
                if(isset($_GET['token']))
                {
                    $token = $_GET['token'];

                    //Checking occurrence of password reset record with provided token
                    $stmt = $conn->prepare("SELECT * FROM password_reset WHERE token = :token");
                    $stmt->bindParam(':token', $token);
                    $stmt->execute();
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    //Checking if provided token isn't expired
                    if(!$result)
                    {
                        FailureMessage("Provided token is expired or wrong.", "index.php");
                        die();
                    }
                    //Checking if provided token isn't used
                    elseif($result[0]['is_used'] == "1")
                    {
                        FailureMessage("Provided token has already been used.", "index.php");
                        die();
                    } 
                }
                elseif(isset($_POST['token']))
                {
                    $token = $_POST['token'];

                    //Fetching user whose password should be changed
                    $stmt = $conn->prepare("SELECT user_id FROM password_reset WHERE token = :token");
                    $stmt->bindParam(':token', $token);
                    $stmt->execute();
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    $userID = $result[0]['user_id'];
                    $password = $_POST['password'];
                    $password = password_hash($password, PASSWORD_DEFAULT);

                    //Updating state of token in password_reset table
                    $stmt = $conn->prepare("UPDATE password_reset SET is_used = 1 WHERE token = :token");
                    $stmt->bindParam(':token', $token);
                    $stmt->execute();

                    //Updating user password in user table
                    $stmt = $conn->prepare("UPDATE user SET h_password  = :password WHERE user_id = :userID");
                    $stmt->bindParam(':password', $password);
                    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
                    $stmt->execute();

                    //Showing apropriate success message
                    SuccessMessage("Your password was successfully changed. Now you can log in with it.", "../loginForm/");
                }
                elseif(isset($_POST['mail']))
                {
                    $formMail = $_POST['mail'];
                    
                    //Checking occurrence of profile with the provided mail
                    $stmt = $conn->prepare("SELECT * FROM user JOIN user_register_option USING(user_register_option_id) WHERE mail = :mail");
                    $stmt->bindParam(':mail', $formMail);
                    $stmt->execute();
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if(!$result)
                    {
                        // If the user with the provided mail does not exist
                        FailureMessage("User with the provided mail does not exist.", "index.php");
                        die();
                    }
                    elseif($result[0]['user_register_option_id'] != 4)
                    {
                        // If the user with the provided mail register through other option than website form
                        FailureMessage("You can not reset your password here because you used other option than our website form to register. In your case <b>".$result['0']['name']."</b>.", "index.php");
                        die();
                    }
                    else
                    {
                        //Token generation and expiration time
                        $userID = $result[0]['user_id'];
                        $token = substr(md5(rand()), 0, 20);

                        //Assigning user mail
                        $userMail = $result[0]['mail'];

                        $expireTime = new DateTimeImmutable();
                        $expireTime = $expireTime->modify('+45 minutes');
                        $expireTime = $expireTime->format('Y-m-d H:i:s');

                        //Checking if certain user has already requested to reset his/her password within last 30 minutes
                        $stmt = $conn->prepare("SELECT * FROM password_reset JOIN user USING(user_id) WHERE mail = :mail");
                        $stmt->bindParam(':mail', $formMail);
                        $stmt->execute();
                        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        if(!$result)
                        {
                            //If not sending email with the link to set a new password and inserting record to password_reset table in database
                            //Importing password reset mail sending script
                            include("../components/Mails/PasswordResetMail.php");

                            //Checking if email has been sent successfully
                            if (SendPasswordResetMail($token, $userMail)) 
                            {
                                //If so, inserting record to password_reset table in database
                                $stmt = $conn->prepare("INSERT INTO password_reset (user_id, token, expire_time) VALUES (:userID, :token, :expireTime)");
                                $stmt->bindParam(':userID', $userID);
                                $stmt->bindParam(':token', $token);
                                $stmt->bindParam(':expireTime', $expireTime);
                                $stmt->execute();

                                //Showing apropriate success message
                                SuccessMessage("Check your e-mail box. We've sent you link, which will expire after 30 minutes, to recover your password!", "index.php");
                            } 
                            else 
                            {
                                //Otherwise showing apropriate error message
                                FailureMessage("Error occured while we trying to send you an e-mail, please try again later.", "index.php");
                            }
                        }
                        else
                        {
                            //Otherwise showing apropriate error message
                            FailureMessage("It looks like you've already requested a password change within the last 30 minutes. Please check your e-mail box and follow instructions there.", "index.php");
                        }
                    }
                }
            } 
            catch(PDOException $e) 
            {
                ?>
                    <script>window.location.replace("../errors/uncaught.php?errorCode=<?php echo $e->getMessage(); ?>");</script>
                <?php
            }
            catch (Exception $e)
            {
                ?>
                    <script>window.location.replace("../errors/uncaught.php?errorCode=<?php echo ('Error occurred while we was trying to send you an email.') ?>");</script>
                <?php
            }
    ?>

    <!--Internal Scripts Import-->
    <script src="./script.js"></script>
</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login & Register</title>

    <?php
        //Importing header tags
        include("../components/headerparamsForm.php");
    ?>
</head>

<body>
    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form action="index.php" method="post">
                <h1>Create Account</h1>

                <div class="social-container">
                    <a href="https://www.facebook.com/dialog/oauth?client_id=936773258081992&redirect_uri=http%3A%2F%2Flocalhost%2FSelene.io%2Fcomponents%2FLoginRegister%2FfacebookOAuthProcess.php%3Faction%3Dregister&response_type=code&scope=email" 
                    class="social"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://accounts.google.com/o/oauth2/auth?response_type=code&client_id=454901055738-qa6bkdfav4o0pcq9hdah2vctb6palgl9.apps.googleusercontent.com&redirect_uri=http%3A%2F%2Flocalhost%2FSelene.io%2Fcomponents%2FLoginRegister%2FgoogleOAuthProcess.php%3Faction%3Dregister&scope=https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.email+https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.profile&access_type=offline&prompt=consent"
                    class="social"><i class="fab fa-google-plus-g"></i></a>
                    <a href="https://discord.com/oauth2/authorize?client_id=1214571914677198898&response_type=code&redirect_uri=http%3A%2F%2Flocalhost%2FSelene.io%2Fcomponents%2FLoginRegister%2FdiscordOAuthProcess.php%3Faction%3Dregister&scope=identify+email"
                    class="social"><i class="fab fa-discord"></i></a>
                </div>
                <span>or use your email for registration</span>

                <input type="text" placeholder="Nickname" name="nick" required style="margin-top: 10px;"/>
                <input type="email" placeholder="Email" name="mail" required/>
                <input type="password" placeholder="Password" name="password" required/>
                <span class="password-error">Password must contain at least 8 characters <br> (1 special, 1  uppercase letter, 1 number).</span><br />
                <input type="hidden" value="sign_up" name="form_type"/>

                <button type="submit">Sign Up</button>
            </form>

        </div>

        <div class="form-container sign-in-container">
            <form action="index.php" method="post">
                <h1>Sign in</h1>

                <div class="social-container">
                    <a href="https://www.facebook.com/dialog/oauth?client_id=936773258081992&redirect_uri=http%3A%2F%2Flocalhost%2FSelene.io%2Fcomponents%2FLoginRegister%2FfacebookOAuthProcess.php%3Faction%3Dlogin&response_type=code&scope=email" 
                    class="social"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://accounts.google.com/o/oauth2/auth?response_type=code&client_id=454901055738-qa6bkdfav4o0pcq9hdah2vctb6palgl9.apps.googleusercontent.com&redirect_uri=http%3A%2F%2Flocalhost%2FSelene.io%2Fcomponents%2FLoginRegister%2FgoogleOAuthProcess.php%3Faction%3Dlogin&scope=https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.email+https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.profile&access_type=offline&prompt=consent"
                    class="social"><i class="fab fa-google-plus-g"></i></a>
                    <a href="https://discord.com/oauth2/authorize?client_id=1214571914677198898&response_type=code&redirect_uri=http%3A%2F%2Flocalhost%2FSelene.io%2Fcomponents%2FLoginRegister%2FdiscordOAuthProcess.php%3Faction%3Dlogin&scope=identify+email" 
                    class="social"><i class="fab fa-discord"></i></a>
                </div>
                <span>or use your account</span>

                <input type="email" placeholder="Email" name="mail" required style="margin-top: 10px;"/>
                <input type="password" placeholder="Password" name="password" required/>
                <input type="hidden" value="sign_in" name="form_type"/>
                <a href="../passwordReset/" class="Forgotten">Forgot your password?</a>

                <button type="submit">Sign In</button>
            </form>
        </div>

        <div class="overlay-container">
            <div class="overlay">

                <div class="overlay-panel overlay-left">
                    <h1>Welcome Back!</h1>
                    <p>To keep connected with us please log in with your personal info</p>
                    <button class="ghost" id="signIn">Sign In</button>
                </div>

                <div class="overlay-panel overlay-right">
                    <h1>Hello, Friend!</h1>
                    <p>Enter your personal details and start journey with us</p>
                    <button class="ghost" id="signUp">Sign Up</button>
                </div>

            </div>
        </div>
    </div>

    <!--Internal Scripts Import-->
    <script src="./script.js"></script>

    <?php
            //TryCatch block
            try 
            {
                //Checking if user isn't logged in already
                if(isset($_SESSION['userID']))
                {
                    FailureMessage("You're already logged in. What are you looking for?", "../main/");
                }

                //Checking if user used mail verification link
                if(isset($_GET['token']))
                {
                    //Checking if request with provided token is active for provided user
                    $stmt = $conn->prepare("SELECT * FROM mail_verify JOIN user USING(user_id) WHERE token = :token AND mail = :mail");
                    $stmt->bindParam(':token', $_GET['token']);
                    $stmt->bindParam(':mail', $_GET['mail']);
                    $stmt->execute();
                    $request = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    //If verification request is wrong
                    if(!$request)
                    {
                        FailureMessage("Provided verification request is wrong. Please check the correctness of request or contact our support..", "index.php");
                        die();
                    }
                    
                    //Updating verification flag in user table in database
                    $stmt = $conn->prepare("UPDATE user SET verified = 1 WHERE mail = :mail");
                    $stmt->bindParam(':mail', $_GET['mail']);
                    $stmt->execute();

                    //Showing apropriate success message
                    SuccessMessage("Congratulations! Your account has been successfully verified. You can now log in and start exploring our shop!", "index.php");
                }

                //Checking if user used any of forms
                if(isset($_POST['form_type']))
                {
                    //Checking which form was used signUP/signIN
                    if($_POST['form_type'] == 'sign_up')
                    {
                        $nick = $_POST['nick'];
                        $mail = $_POST['mail'];
                        $password = $_POST['password'];

                        //Checking if provided nick isn't taken
                        $stmt = $conn->prepare("SELECT * FROM user WHERE nickname = :nick");
                        $stmt->bindParam(':nick', $nick);
                        $stmt->execute();
                        $duplicates = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        if($duplicates)
                        {
                            FailureMessage("The provided nickname is already associated with another account. Please use a different nickname.", "index.php");
                            die();
                        }

                        //Checking if provided mail isn't taken
                        $stmt = $conn->prepare("SELECT * FROM user WHERE mail = :mail");
                        $stmt->bindParam(':mail', $mail);
                        $stmt->execute();
                        $duplicates = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        if($duplicates)
                        {
                            FailureMessage("The provided email is already associated with another account. Please use a different email address.", "index.php");
                            die();
                        }

                        //Sending email with confirmation link to the user
                        //Importing password confirmation mail sending script
                        include("../components/Mails/AccountVerificationMail.php");

                        //Generating token
                        $token = substr(md5(rand()), 0, 20);
                         
                        //Checking if email has been sent successfully
                        if (SendAccountVerificationMail($token, $mail)) 
                        {
                            //Hashing given password
                            $password = password_hash($password, PASSWORD_DEFAULT);

                            //Inserting new record into user table in database
                            $stmt = $conn->prepare("INSERT INTO user (nickname, mail, h_password) VALUES (:nick, :mail, :password)");
                            $stmt->bindParam(":password", $password);
                            $stmt->bindParam(':mail', $mail);
                            $stmt->bindParam(':nick', $nick);
                            $stmt->execute();

                            //Fetching new user id
                            $stmt = $conn->prepare("SELECT MAX(user_id) as userID FROM user");
                            $stmt->execute();
                            $result = $stmt->fetch(PDO::FETCH_ASSOC);

                            //Inserting new record into mail_verify table in database
                            $stmt = $conn->prepare("INSERT INTO mail_verify (user_id, token) VALUES (:userID, :token)");
                            $stmt->bindParam(":userID", $result['userID'], PDO::PARAM_INT);
                            $stmt->bindParam(':token', $token);
                            $stmt->execute();

                            //Showing apropriate success message
                            SuccessMessage("Your account has been created successfully! Please check your email to activate your account before logging in.", "index.php");
                        } 
                        else 
                        {
                            //Otherwise showing apropriate error message
                            FailureMessage("An error occurred while attempting to send you an email. Please contact our support team for further assistance..", "index.php");
                        }

                    }

                    //Checking which form was used signUP/signIN
                    elseif($_POST['form_type'] == 'sign_in')
                    {
                        $mail = $_POST['mail'];
                        $password = $_POST['password'];

                        $stmt = $conn->prepare("SELECT * FROM user WHERE mail = :mail");
                        $stmt->bindParam(':mail', $mail);
                        $stmt->execute();
                        $user = $stmt->fetch(PDO::FETCH_ASSOC);

                        //Checking occurrence of user with provided mail and password
                        if (!$user || !password_verify($password, $user['h_password'])) 
                        {
                            FailureMessage("Invalid email or password. Please try again", "index.php");
                            die();
                        }
                        elseif($user['verified'] == 0)
                        {
                            //Otherwise showing apropriate error message
                            FailureMessage("Your account has not been verified yet. Please verify your email address before logging in. If you haven't received a verification email, please check your spam folder or contact our support team for assistance.", "index.php");                     
                        }
                        else
                        {
                            //Starting session if login is successfull
                            $_SESSION['userID'] = $user['user_id'];
                            $_SESSION['nickname'] = $user['nickname'];
                            $_SESSION['mail'] = $mail;
                            $_SESSION['joinDate'] = $user['join_date'];
                            $_SESSION['profilePicture'] = $user['profile_picture'];
                            $_SESSION['admin'] = $user['admin'];
                            
                            //Showing apropriate success message
                            SuccessMessage("Login successful. Welcome <b>{$_SESSION['nickname']}</b>!", "../main/");
                            die();
                        } 
                    }
                }
            } 
            catch(PDOException $e) 
            {
                ?>
                    <script>window.location.replace("../errors/uncaught.php?errorCode=<?php echo $e->getMessage(); ?>");</script>
                <?php
            } catch (Exception $e)
            {
                ?>
                    <script>window.location.replace("../errors/uncaught.php?errorCode=<?php echo ('Error occurred while we was trying to send you an email.') ?>");</script>
                <?php
            }
    ?>

</body>

</html>

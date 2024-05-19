<?php

    // Importing database connection configuration
    include('../../components/databaseConn.php');


    //GETTING TOKEN

    try
    {
        //Checking if code provided by Facebook exists
        if(!isset($_GET['code']))
        {
            header("Location: ../../main/");
            die;
        }
        
        //Setting payload details
        $facebookCode = $_GET['code'];

        //Checking if user trying to sign in or sign up
        if($_GET['action'] == "register")
        {
            $payload = [
            'code' =>  $facebookCode, 
            'client_id' => '936773258081992',
            'client_secret' => '3fd98cae1b3f41eeb9c4dfce8d3447af',
            'redirect_uri' =>  'http://localhost/Selene.io/components/LoginRegister/facebookOAuthProcess.php?action=register',
            ];
        }
        else
        {
            $payload = [
            'code' =>  $facebookCode, 
            'client_id' => '936773258081992',
            'client_secret' => '3fd98cae1b3f41eeb9c4dfce8d3447af',
            'redirect_uri' =>  'http://localhost/Selene.io/components/LoginRegister/facebookOAuthProcess.php?action=login',
            ];
        }

        $payload_string = http_build_query($payload);

        //Setting Facebook URL to send query there
        $facebook_url = "https://graph.facebook.com/oauth/access_token";

        //Setting new Curl session and HTTP request
        $curlConn = curl_init();

        curl_setopt($curlConn, CURLOPT_URL, $facebook_url);
        curl_setopt($curlConn, CURLOPT_POST, true);
        curl_setopt($curlConn, CURLOPT_POSTFIELDS, $payload_string);
        curl_setopt($curlConn, CURLOPT_RETURNTRANSFER, true);

        //Making the request
        $curlResult = curl_exec($curlConn);

        //Decoding results provided by Facebook API
        $curlResult = json_decode($curlResult, true);

        //Error if we didn't get access token
        if(!isset($curlResult['access_token']) || empty($curlResult['access_token']))
        {
            header("Location: ../../main/?failure=Error ocurred while we trying to login you via Facebook.&link=index.php");
            die;
        }

        //Getting Facebook token
        $accessToken = $curlResult['access_token'];



        //GETTING INFO ABOUT USER

        //Setting new Facebook URL to get info about user
        $facebook_url = 'https://graph.facebook.com/v19.0/me?fields=name,email,picture';
        $header = array("Authorization: Bearer $accessToken");

        //Setting new Curl session and HTTP request
        $curlConn = curl_init();

        curl_setopt($curlConn, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curlConn, CURLOPT_URL, $facebook_url);
        curl_setopt($curlConn, CURLOPT_POST, false);
        curl_setopt($curlConn, CURLOPT_RETURNTRANSFER, true);

        //Making the request
        $curlResult = curl_exec($curlConn);

        //Decoding results provided by Facebook API
        $curlResult = json_decode($curlResult, true);

        //Getting user data from result
        $nick = $curlResult['name'];
        $mail = $curlResult['email'];
        $password = $curlResult['id'];
        $profilePicture = $curlResult['picture']['data']['url'];


        //Checking if user should be logged in or registered
        if($_GET['action'] == 'register')
        {

            //Checking if provided mail isn't taken
            $stmt = $conn->prepare("SELECT * FROM user WHERE mail = :mail");
            $stmt->bindParam(':mail', $mail);
            $stmt->execute();
            $duplicates = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if($duplicates)
            {
                header("Location: ../../loginForm/?failure=Sorry, the email associated with your Facebook account is already in use. Please choose a different mail or try logging in with your existing account using the same login method that you used when registering your account.&link=index.php");
                die();
            }

            //Checking if provided nick isn't taken
            $stmt = $conn->prepare("SELECT * FROM user WHERE nickname = :nick");
            $stmt->bindParam(':nick', $nick);
            $stmt->execute();
            $duplicates = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if($duplicates)
            {
                header("Location: ../../loginForm/?failure=Sorry, the name associated with your Facebook account is already in use. Please choose a different nickname or try logging in with your existing account using the same login method that you used when registering your account.&link=index.php");
                die();
            }

            //Hashing given password
            $password = password_hash($password, PASSWORD_DEFAULT);

            //Inserting new record into user table in database
            $stmt = $conn->prepare("INSERT INTO user (nickname, mail, h_password, user_register_option_id, verified) VALUES (:nick, :mail, :password, 3, 1)");
            $stmt->bindParam(":password", $password);
            $stmt->bindParam(':mail', $mail);
            $stmt->bindParam(':nick', $nick);
            $stmt->execute();

            //Fetching all information about new user
            $stmt = $conn->prepare("SELECT * FROM user WHERE mail = :mail");
            $stmt->bindParam(':mail', $mail);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            //Starting session
            $_SESSION['userID'] = $user['user_id'];
            $_SESSION['nickname'] = $user['nickname'];
            $_SESSION['mail'] = $mail;
            $_SESSION['joinDate'] = $user['join_date'];
            $_SESSION['profilePicture'] = $user['profile_picture'];
            $_SESSION['admin'] = $user['admin'];

            //Showing apropriate success message
            header("Location: ../../main?success=Congratulations! Your account has been successfully created via Facebook and you are now logged in.&link=index.php");
        }
        else
        {
            $stmt = $conn->prepare("SELECT * FROM user JOIN user_register_option USING(user_register_option_id) WHERE mail = :mail AND nickname = :nick");
            $stmt->bindParam(':mail', $mail);
            $stmt->bindParam(':nick', $nick);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            //Checking if account with provided parameters exists
            if(!$user)
            {
                header("Location: ../../loginForm/?failure=Sorry, we couldn't find an account with email and username provided by Facebook. If you don't have an account yet, you can register now. Need help? Contact <b>support@selene.io.net<b/>&link=index.php");
            }
            //Checking correctness of password
            elseif(!password_verify($password, $user['h_password']))
            {
                header("Location: ../../loginForm/?failure=Oops! It looks like there's an account associated with the email and nickname provided by your Facebook account, but the password doesn't match. Please double-check your credentials or ensure you're using the same login method that you used when registering your account (in your case {$user['name']}).&link=index.php");
            }
            else
            {
                //Starting session
                $_SESSION['userID'] = $user['user_id'];
                $_SESSION['nickname'] = $user['nickname'];
                $_SESSION['mail'] = $mail;
                $_SESSION['joinDate'] = $user['join_date'];
                $_SESSION['profilePicture'] = $user['profile_picture'];
                $_SESSION['admin'] = $user['admin'];

                //Showing apropriate success message
                header("Location: ../../main?success=Congratulations! You have successfully logged in with your Facebook account. Welcome back!&link=index.php");
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
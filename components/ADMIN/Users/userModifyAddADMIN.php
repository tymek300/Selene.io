<?php
    try
    {
        include('../../../components/databaseConn.php');

        //Checking if profile should be added or modified
        if($_POST['type'] == 'modify')
        {

            //Checkin if new nickname is the same as the old one
            if($_POST['hiddenNick'] != $_POST['nickname'])
            {
                //Fetching for users with given nickname
                $stmt = $conn->prepare("SELECT * FROM user WHERE nickname = :nickname");
                $stmt->bindParam(':nickname', $_POST['nickname']);
                $stmt->execute();
                $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

                //Error if nickname is taken
                if($users)
                {
                    header('Location: ../../../admin_dashboard/users.php?failure=User with provided nickname already exists.&link=users.php');
                    die;
                }
            }

            //Checkin if new mail is the same as the old one
            if($_POST['hiddenMail'] != $_POST['mail'])
            {
                //Fetching for users with given mail
                $stmt = $conn->prepare("SELECT * FROM user WHERE mail = :mail");
                $stmt->bindParam(':mail', $_POST['mail']);
                $stmt->execute();
                $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

                //Error if mail is taken
                if($users)
                {
                    header('Location: ../../../admin_dashboard/users.php?failure=User with provided mail already exists.&link=users.php');
                    die;
                }

            }

            //Updating information about certain user
            $stmt = $conn->prepare("UPDATE user SET nickname = :nickname, mail = :mail, admin = :admin WHERE user_id = :userID");
            $stmt->bindParam(':userID', $_POST['userID']);
            $stmt->bindParam(':nickname', $_POST['nickname']);
            $stmt->bindParam(':mail', $_POST['mail']);
            $stmt->bindParam(':admin', $_POST['admin']);
            $stmt->execute();

            header('Location: ../../../admin_dashboard/users.php?success='.$_POST['nickname'].'\'s profile has been modified successfully!&link=users.php');
        }
        else
        {
            //Fetching for users with given nickname
            $stmt = $conn->prepare("SELECT * FROM user WHERE nickname = :nickname");
            $stmt->bindParam(':nickname', $_POST['nickname']);
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            //Error if nickname is taken
            if($users)
            {
                header('Location: ../../../admin_dashboard/users.php?failure=User with provided nickname already exists.&link=users.php');
                die;
            }

            //Fetching for users with given mail
            $stmt = $conn->prepare("SELECT * FROM user WHERE mail = :mail");
            $stmt->bindParam(':mail', $_POST['mail']);
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            //Error if mail is taken
            if($users)
            {
                header('Location: ../../../admin_dashboard/users.php?failure=User with provided mail already exists.&link=users.php');
                die;
            }

            //Adding new user to user table
            $stmt = $conn->prepare("INSERT INTO user (nickname, mail, h_password, admin) VALUES (:nickname, :mail, :password, :admin)");
            $stmt->bindParam(':nickname', $_POST['nickname']);
            $stmt->bindParam(':mail', $_POST['mail']);
            $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $stmt->bindParam(':password', $password_hash);
            $stmt->bindParam(':admin', $_POST['admin']);
            $stmt->execute();

            header('Location: ../../../admin_dashboard/users.php?success='.$_POST['nickname'].'\'s profile has been created successfully!&link=users.php');
        }
        
    }
    catch(PDOException $e) 
    {
        ?>
            <script>window.location.replace("../../../errors/uncaught.php?errorCode=<?php echo $e->getMessage(); ?>");</script>
        <?php
    }
?>
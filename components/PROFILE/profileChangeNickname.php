<?php
    try
    {
        include('../../components/databaseConn.php');

        if (isset($_POST['newNickname'])) 
        {
            $newNickname = $_POST['newNickname'];

            // Check if the new nickname already exists in the database
            $stmt = $conn->prepare("SELECT nickname FROM user WHERE nickname = :nickname");
            $stmt->bindParam(':nickname', $newNickname);
            $stmt->execute();
            $result = $stmt->fetch();

            if ($result) 
            {
                header("Location: ../../userProfile/?failure=Nickname is already taken.&link=index.php");
            } 
            else 
            {
                // Update the nickname in the database
                $stmt = $conn->prepare("UPDATE user SET nickname = :newNickname WHERE user_id = :userID");
                $stmt->bindParam(':newNickname', $newNickname);
                $stmt->bindParam(':userID', $_SESSION['userID']);
                $stmt->execute();

                // Update the nickname in the session
                $_SESSION['nickname'] = $newNickname; 

                // Redirect to the user profile page
                header("Location: ../../userProfile/?success=Nickname changed successfully.&link=index.php");
            }
        }
    }
    catch(PDOException $e) 
    {
        ?>
        <script>window.location.replace("../../errors/uncaught.php?errorCode=<?php echo $e->getMessage(); ?>");</script>
        <?php
    }

?>
<?php
    try
    {
        //Importing database connection
        include('../../components/databaseConn.php');

        //Setting tmpName and final path of photo
        $tmpName = $_FILES['profilePicture']['tmp_name'];
        $path = '../../photos/profilePictures/'.$_FILES['profilePicture']['name'];

        //Checking if photo with same name doesn't exist already
        if(file_exists($path))
        {
            $path = '../../photos/profilePictures/'.time().$_FILES['profilePicture']['name'];
        }

        //Setting allowed extensions
        $extensions = array("png", "jpeg", "jpg");
        $array = explode('.', $_FILES['profilePicture']['name']);
        $file_ext = strtolower(end($array));

        //Checking if provided photo has got right extension
        if(!in_array($file_ext, $extensions))
        {
            header('Location: ../../userProfile/?failure=Provided photo has got wrong extension. Allowed are: png, jpeg, jpg. Try again with other photo.&link=index.php');
        }
        //Checking if provided photo is not too large
        elseif($_FILES['profilePicture']['size'] > 5000000)
        {
            header('Location: ../../userProfile/?failure=Provided photo is too large. Maximum size of photo is 5MB. Try again with other photo.&link=index.php');
        }
        else
        {
            //If photo is OK changing its path in the server directory
            move_uploaded_file($tmpName, $path);

            //Updating path in database
            $path = substr($path, 3);

            //Updating record in user table in database
            $stmt = $conn->prepare("UPDATE user SET profile_picture = :path WHERE user_id = :userID");
            $stmt->bindParam(':userID', $_SESSION['userID'], PDO::PARAM_INT);
            $stmt->bindParam(':path', $path);
            $stmt->execute();

            //Updating current sessions data
            $_SESSION['profilePicture'] = $path;
            
            //Redirecting back to user profile with apropriate success message
            header('Location: ../../userProfile/?success=Profile picture has benn successfully changed.&link=index.php');
        }
    }
    catch(PDOException $e) 
    {
        ?>
        <script>window.location.replace("../../errors/uncaught.php?errorCode=<?php echo $e->getMessage(); ?>");</script>
        <?php
    }
?>
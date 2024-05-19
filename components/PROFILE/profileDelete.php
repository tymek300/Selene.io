<?php
    try
    {
        include('../../components/databaseConn.php');

        //Profile delete for admins from dashboard
        $stmt = $conn->prepare("DELETE FROM user WHERE user_id = :userID");
        if(isset($_POST['admin']))
        {
            $stmt->bindParam(':userID', $_POST['userID']);
            $stmt->execute();

            header('Location: ../../admin_dashboard/users.php?success=Account has been deleted successfully!&link=users.php');
        }
        //Profile delete for users from profile page
        else
        {
            $stmt->bindParam(':userID', $_GET['userID']);
            $stmt->execute();
            
            header('Location: ../../components/logout.php?success=');
        }

    }
    catch(PDOException $e) 
    {
        ?>
        <script>window.location.replace("../../errors/uncaught.php?errorCode=<?php echo $e->getMessage(); ?>");</script>
        <?php
    }

?>
<?php
    try
    {
        //Destroyig session and all data
        session_start();
        session_unset();
        session_destroy();
        session_write_close();

        if(isset($_GET['communicate']))
        {
            header('Location: ../main/?success=Your profile has been deleted successfully!&link=index.php');
        }
        else
        {
            header('Location: ../main/?success=You have been logged out successfully!&link=index.php');
        }
    }
    catch(PDOException $e) 
    {
        ?>
            <script>window.location.replace("../errors/uncaught.php?errorCode=<?php echo $e->getMessage(); ?>");</script>
        <?php
    }   
?>
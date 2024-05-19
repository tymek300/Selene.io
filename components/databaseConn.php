<?php
try
{
    //Starting session if it is not active
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    //Creting variable which holds databe connection
    $conn = new PDO("mysql:host=localhost;dbname=selene", 'root', '');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) 
{
    ?>
    <script>window.location.replace("../errors/uncaught.php?errorCode=<?php echo $e->getMessage(); ?>");</script>
    <?php
}
?>
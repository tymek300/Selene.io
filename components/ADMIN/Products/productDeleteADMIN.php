<?php
    try
    {
        include('../../../components/databaseConn.php');

        //Function to delete folders/files
        function delTree($dir): bool
        {
            $files = array_diff(scandir($dir), array('.','..'));

            foreach ($files as $file) 
            {
                (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
            }

            return rmdir($dir);
        }

        //Deleting certain product folder
        $path = "../../../photos/productPhotos/".$_POST['hiddenName'];
        delTree($path);
        
        //Deleting product from database
        $stmt = $conn->prepare("DELETE FROM product WHERE name = :name");
        $stmt->bindParam(':name', $_POST['hiddenName']);
        $stmt->execute();

        header('Location: ../../../admin_dashboard/products.php?success=Product has been deleted successfully!&link=products.php');
    }
    catch(PDOException $e) 
    {
        ?>
        <script>window.location.replace("../../../errors/uncaught.php?errorCode=<?php echo $e->getMessage(); ?>");</script>
        <?php
    }

?>
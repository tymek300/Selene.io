<?php
    try
    {
        include('../../../components/databaseConn.php');

        //Updating information about product main photo
        $stmt = $conn->prepare("UPDATE product_photos SET main = 0 WHERE product_id = :productID AND main = 1");
        $stmt->bindParam(':productID', $_POST['productID'], PDO::PARAM_INT);
        $stmt->execute();

        $stmt = $conn->prepare("UPDATE product_photos SET main = 1 WHERE photo_id = :photoID");
        $stmt->bindParam(':photoID', $_POST['photoID'], PDO::PARAM_INT);
        $stmt->execute();

        //Fetching for product name
        $stmt = $conn->prepare("SELECT * FROM product WHERE product_id = :productID");
        $stmt->bindParam(':productID', $_POST['productID'], PDO::PARAM_INT);
        $stmt->execute();
        $product = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        header('Location: ../../../admin_dashboard/product_photos.php?productID='.$_POST['productID'].'&success=Photo has been successfully set as <b>'.$product[0]['name'].'</b> main photo!&link=product_photos.php?productID='.$_POST['productID']);
    }
    catch(PDOException $e) 
    {
        ?>
        <script>window.location.replace("../../../errors/uncaught.php?errorCode=<?php echo $e->getMessage(); ?>");</script>
        <?php
    }

?>
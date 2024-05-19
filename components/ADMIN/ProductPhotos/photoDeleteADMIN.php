<?php
    try
    {
        include('../../../components/databaseConn.php');

        //Checking if provided photo is main photo of product
        $stmt = $conn->prepare("SELECT * FROM product_photos WHERE photo_id = :photoID");
        $stmt->bindParam(':photoID', $_POST['ID'], PDO::PARAM_INT);
        $stmt->execute();
        $photo = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $filePath = "../../".$photo[0]['path'];

        if($photo[0]['main'] == 1)
        {
            //Checking if provided product has got any other photos
            $stmt = $conn->prepare("SELECT * FROM product_photos WHERE product_id = :productID");
            $stmt->bindParam(':productID', $photo[0]['product_id'], PDO::PARAM_INT);
            $stmt->execute();
            $photo = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if(count($photo) == 1)
            {
                header('Location: ../../../admin_dashboard/product_photos.php?productID='.$photo[0]['product_id'].'&failure=The product whose photo you want to delete does not has any other photos. Please first add at least one photo to this product!&link=product_photos.php?productID='.$photo[0]['product_id']);
            }
            else
            {
                //Deleting photo from product folder
                unlink($filePath);

                //Deleting photo record from table in database
                $stmt = $conn->prepare("DELETE FROM product_photos WHERE photo_id = :photoID");
                $stmt->bindParam(':photoID', $_POST['ID'], PDO::PARAM_INT);
                $stmt->execute();

                //Setting other photo as product main photo
                $stmt = $conn->prepare("SELECT * FROM product_photos WHERE product_id = :productID");
                $stmt->bindParam(':productID', $photo[0]['product_id'], PDO::PARAM_INT);
                $stmt->execute();
                $photo = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $stmt = $conn->prepare("UPDATE product_photos SET main = 1 WHERE photo_id = :photoID");
                $stmt->bindParam(':photoID', $photo[0]['photo_id'], PDO::PARAM_INT);
                $stmt->execute();

                header('Location: ../../../admin_dashboard/product_photos.php?productID='.$photo[0]['product_id'].'&success=Photo deleted successfully. <b>Notice:</b> Product main photo has been changed successfully!&link=product_photos.php?productID='.$photo[0]['product_id']);
            }
        }
        else
        {
            //Deleting photo from product folder
            unlink($filePath);

            //Deleting photo record from table in database
            $stmt = $conn->prepare("DELETE FROM product_photos WHERE photo_id = :photoID");
            $stmt->bindParam(':photoID', $_POST['ID'], PDO::PARAM_INT);
            $stmt->execute();

            header('Location: ../../../admin_dashboard/product_photos.php?productID='.$photo[0]['product_id'].'&success=Photo deleted successfully!&link=product_photos.php?productID='.$photo[0]['product_id']);
        }
        die;

    }
    catch(PDOException $e) 
    {
        ?>
        <script>window.location.replace("../../../errors/uncaught.php?errorCode=<?php echo $e->getMessage(); ?>");</script>
        <?php
    }

?>
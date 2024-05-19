<?php
    try
    {
        include('../../../components/databaseConn.php');

        //PHOTOS UPLOADING
        //Getting uploaded photos
        $productPhotos = $_FILES['productPhotos'];

        //Setting allowed extensions
        $extensions = array("png", "jpeg", "jpg");

        //Validating files
        foreach($productPhotos['name'] as $key => $name) 
        {

            //Getting file extension
            $array = explode('.', $productPhotos['name'][$key]);
            $file_ext = strtolower(end($array));

            //Checking if provided photo has got right extension
            if(!in_array($file_ext, $extensions))
            {
                header('Location: ../../../admin_dashboard/product_photos.php?productID='.$_POST['ID'].'&failure=One of the provided photos has got wrong extension. Allowed are: png, jpeg, jpg. Try again with other photos.&link=product_photos.php?productID='.$_POST['ID']);
                die;
            }
            //Checking if provided photo is not too large
            elseif($productPhotos['size'][$key] > 5000000)
            {
                header('Location: ../../../admin_dashboard/product_photos.php?productID='.$_POST['ID'].'&failure=One of the provided photos is too large. Maximum size of photo is 5MB. Try again with other photos.&link=product_photos.php?productID='.$_POST['ID']);
                die;
            }
        }

        //Fetching name of product with provided ID
        $stmt = $conn->prepare("SELECT * FROM product WHERE product_id = :productID");
        $stmt->bindParam(':productID', $_POST['ID'], PDO::PARAM_INT);
        $stmt->execute();
        $product = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //Setting path for photos
        $productFolderPath = "../photos/productPhotos/".$product[0]['name'];

        //Uploading photoes
        foreach($productPhotos['name'] as $key => $name)
        {
            $tmpName = $productPhotos['tmp_name'][$key];
            $photoPath = $productFolderPath."/".$productPhotos['name'][$key];

            //Checking if file with the same name as uploaded exists in certain location
            if(file_exists("../../".$photoPath))
            {
                $photoPath = $productFolderPath."/".time().$productPhotos['name'][$key];
            }

            //Moving uploaded file to product directory
            move_uploaded_file($tmpName, "../../".$photoPath);

            //Inserting record to product_photos table in database
            $stmt = $conn->prepare("INSERT INTO product_photos (product_id, path, main) VALUES (:productID, :path, 0)");
            $stmt->bindParam(':productID', $_POST['ID']);
            $stmt->bindParam(':path', $photoPath);
            $stmt->execute();
        }

        header('Location: ../../../admin_dashboard/product_photos.php?productID='.$_POST['ID'].'&success=Photos have been successfully added to <b>'.$product[0]['name'].'</b> product!&link=product_photos.php?productID='.$_POST['ID']);
    }
    
    catch(PDOException $e) 
    {
        ?>
        <script>window.location.replace("../../../errors/uncaught.php?errorCode=<?php echo $e->getMessage(); ?>");</script>
        <?php
    }

?>
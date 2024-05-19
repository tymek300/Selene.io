<?php
    try
    {
        include('../../../components/databaseConn.php');

        //Checking if product should be added or modified
        if($_POST['type'] == 'modify')
        {
            //Checking if new name is the same as the old one
            if($_POST['hiddenName'] != $_POST['productName'])
            {
                //Fetching for products with given new name
                $stmt = $conn->prepare("SELECT * FROM product WHERE name = :name");
                $stmt->bindParam(':name', $_POST['productName']);
                $stmt->execute();
                $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

                //Error if product with given name already exists
                if($products)
                {
                    header('Location: ../../../admin_dashboard/products.php?failure=Product with provided name already exists.&link=products.php');
                    die;
                }

                //Renaming folder with product photos
                $oldFolderName = "../photos/productPhotos/".$_POST['hiddenName'];
                $newFolderName = "../photos/productPhotos/".$_POST['productName'];

                if(!rename("../../".$oldFolderName, "../../".$newFolderName))
                {
                    header('Location: ../../admin_dashboard/products.php?failure=Provided product name is wrong. Please try again with other name.&link=products.php');
                    die;
                }
                
                //Getting all records with certain productID from product_photos table and changing path to photos
                $stmt = $conn->prepare("SELECT * FROM product_photos WHERE product_id = :productID");
                $stmt->bindParam(':productID', $_POST['productID'], PDO::PARAM_INT);
                $stmt->execute();
                $productPhotos = $stmt->fetchAll(PDO::FETCH_ASSOC);

                //Modifying provided records
                foreach($productPhotos as $photo)
                {
                    //Proper modifying of paths
                    $newPath = explode("/", $photo['path']);
                    $newPath[3] = $_POST['productName'];
                    $newPath = implode("/", $newPath);

                    //Inserting new paths
                    $stmt = $conn->prepare("UPDATE product_photos SET path = :newPath WHERE photo_id = :photoID");
                    $stmt->bindParam(':newPath', $newPath);
                    $stmt->bindParam(':photoID', $photo['photo_id'], PDO::PARAM_INT);
                    $stmt->execute();
                }
            }

            //Fetching for product which is modyfying
            $stmt = $conn->prepare("SELECT * FROM product WHERE product_id = :productID");
            $stmt->bindParam(':productID', $_POST['productID'], PDO::PARAM_INT);
            $stmt->execute();
            $product = $stmt->fetchAll(PDO::FETCH_ASSOC);

            //If lowest price from last 30 days is bigger than provided new price, updating it.
            if($product[0]['lowest_price_30d'] > $_POST['productPrice'])
            {
                $stmt = $conn->prepare("UPDATE product SET lowest_price_30d = :productPrice WHERE product_id = :productID");
                $stmt->bindParam(':productPrice', $_POST['productPrice']);
                $stmt->bindParam(':productID', $_POST['productID'], PDO::PARAM_INT);
                $stmt->execute();
            }

            //Updating information about certain product
            $stmt = $conn->prepare("UPDATE product SET name = :productName, price = :productPrice, quantity_available = :productQAvailable, quantity_sold = :productQSold, description = :productDescription, average_rating = :productRating WHERE product_id = :productID");
            $stmt->bindParam(':productID', $_POST['productID'], PDO::PARAM_INT);
            $stmt->bindParam(':productName', $_POST['productName']);
            $stmt->bindParam(':productPrice', $_POST['productPrice']);
            $stmt->bindParam(':productQAvailable', $_POST['productQAvailable'], PDO::PARAM_INT);
            $stmt->bindParam(':productQSold', $_POST['productQSold'], PDO::PARAM_INT);
            $stmt->bindParam(':productDescription', $_POST['productDescription']);
            $stmt->bindParam(':productRating', $_POST['productRating'], PDO::PARAM_INT);
            $stmt->execute();

            header('Location: ../../../admin_dashboard/products.php?success=Information about <b>'.$_POST['productName'].'</b> product has been modified successfully!&link=products.php');

        }
        else
        {
            //Fetching for products with given name
            $stmt = $conn->prepare("SELECT * FROM product WHERE name = :name");
            $stmt->bindParam(':name', $_POST['productName']);
            $stmt->execute();
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

            //Error if product with given name already exists
            if($products)
            {
                header('Location: ../../../admin_dashboard/products.php?failure=Product with provided name already exists.&link=products.php');
                die;
            }

            //Adding new product to database
            $stmt = $conn->prepare("INSERT INTO product (name, price, lowest_price_30d, quantity_available, quantity_sold, description, average_rating) VALUES (:productName, :productPrice, :productPrice, :productQAvailable, :productQSold, :productDescription, :productRating)");
            $stmt->bindParam(':productName', $_POST['productName']);
            $stmt->bindParam(':productPrice', $_POST['productPrice']);
            $stmt->bindParam(':productQAvailable', $_POST['productQAvailable'], PDO::PARAM_INT);
            $stmt->bindParam(':productQSold', $_POST['productQSold'], PDO::PARAM_INT);
            $stmt->bindParam(':productDescription', $_POST['productDescription']);
            $stmt->bindParam(':productRating', $_POST['productRating'], PDO::PARAM_INT);
            $stmt->execute();

            //Getting ID of new added product
            $productID = $conn->lastInsertId();

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
                    //Deleting record from product table if uploading went wrong
                    $stmt = $conn->prepare("DELETE FROM product WHERE product_id = :productID");
                    $stmt->bindParam(':productID', $productID);
                    $stmt->execute();

                    header('Location: ../../../admin_dashboard/products.php?failure=One of provided photoes has got wrong extension. Allowed are: png, jpeg, jpg. Try again with other photo.&link=products.php');
                    die;
                }
                //Checking if provided photo is not too large
                elseif($productPhotos['size'][$key] > 5000000)
                {
                    //Deleting record from product table if uploading went wrong
                    $stmt = $conn->prepare("DELETE FROM product WHERE product_id = :productID");
                    $stmt->bindParam(':productID', $productID);
                    $stmt->execute();

                    header('Location: ../../../admin_dashboard/products.php?failure=Provided photo is too large. Maximum size of photo is 5MB. Try again with other photo.&link=products.php');
                    die;
                }
            }

            //If all photos are right creating directory for it with name of product
            $productFolderPath = "../photos/productPhotos/".$_POST['productName'];

            if(!mkdir("../../".$productFolderPath))
            {
                header('Location: ../../../admin_dashboard/products.php?failure=Provided product name is wrong. Please try again with other name.&link=products.php');
                die;
            }

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

                //Checking if photo should be flagged as main
                if($key == 0)
                {
                    //Inserting record to product_photos table in database
                    $stmt = $conn->prepare("INSERT INTO product_photos (product_id, path, main) VALUES (:productID, :path, 1)");
                }
                else
                {
                    //Inserting record to product_photos table in database
                    $stmt = $conn->prepare("INSERT INTO product_photos (product_id, path, main) VALUES (:productID, :path, 0)");
                }
                $stmt->bindParam(':productID', $productID);
                $stmt->bindParam(':path', $photoPath);
                $stmt->execute();

            }

            //Adding product to certain category
            $stmt = $conn->prepare("INSERT INTO product_categories (product_id, subcategory_id) VALUES (:productID, :subcategoryID)");
            $stmt->bindParam(':productID', $productID, PDO::PARAM_INT);
            $stmt->bindParam(':subcategoryID', $_POST['subcategoryID']);
            $stmt->execute();

            header('Location: ../../../admin_dashboard/products.php?success=Product named <b>'.$_POST['productName'].'</b> has been added successfully!&link=products.php');
        }
    }
    catch(PDOException $e) 
    {
        ?>
            <script>window.location.replace("../../../errors/uncaught.php?errorCode=<?php echo $e->getMessage(); ?>");</script>
        <?php
    }
?>
<?php
    try
    {
        include('../../../components/databaseConn.php');

        
        if($_POST['type'] == 'add')
        {
            //Adding product to certain category
            $stmt = $conn->prepare("INSERT INTO product_categories (product_id, subcategory_id) VALUES (:productID, :subcategoryID)");
            $stmt->bindParam(':productID', $_POST['productID'], PDO::PARAM_INT);
            $stmt->bindParam(':subcategoryID', $_POST['subcategoryID']);
            $stmt->execute();

            //Fetching neccessary data
            $stmt = $conn->prepare("SELECT * FROM subcategory WHERE subcategory_id = :subcategoryID");
            $stmt->bindParam(':subcategoryID', $_POST['subcategoryID'], PDO::PARAM_INT);
            $stmt->execute();
            $subcategory = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $stmt = $conn->prepare("SELECT * FROM product WHERE product_id = :productID");
            $stmt->bindParam(':productID', $_POST['productID'], PDO::PARAM_INT);
            $stmt->execute();
            $product = $stmt->fetchAll(PDO::FETCH_ASSOC);

            header('Location: ../../../admin_dashboard/products.php?success=Product named <b>'.$product[0]['name'].'</b> has been added to <b>'.$subcategory[0]['name'].'</b> category successfully!&link=products.php');
        }
        else
        {
            //Deleting product from certain category
            $stmt = $conn->prepare("DELETE FROM product_categories WHERE product_id = :productID AND subcategory_id = :subcategoryID");
            $stmt->bindParam(':productID', $_POST['productID'], PDO::PARAM_INT);
            $stmt->bindParam(':subcategoryID', $_POST['subcategoryID']);
            $stmt->execute();

            //Fetching neccessary data
            $stmt = $conn->prepare("SELECT * FROM subcategory WHERE subcategory_id = :subcategoryID");
            $stmt->bindParam(':subcategoryID', $_POST['subcategoryID'], PDO::PARAM_INT);
            $stmt->execute();
            $subcategory = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $stmt = $conn->prepare("SELECT * FROM product WHERE product_id = :productID");
            $stmt->bindParam(':productID', $_POST['productID'], PDO::PARAM_INT);
            $stmt->execute();
            $product = $stmt->fetchAll(PDO::FETCH_ASSOC);

            header('Location: ../../../admin_dashboard/products.php?success=Product named <b>'.$product[0]['name'].'</b> has been deleted successfully from <b>'.$subcategory[0]['name'].'</b> category!&link=products.php');
        }

        
    }
    catch(PDOException $e) 
    {
        ?>
            <script>window.location.replace("../../../errors/uncaught.php?errorCode=<?php echo $e->getMessage(); ?>");</script>
        <?php
    }

?>
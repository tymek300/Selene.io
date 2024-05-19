<?php
    try
    {
        //Importing database connection
        include('../../components/databaseConn.php');

        //Checking if user is logged in
        if(!isset($_SESSION['userID']))
        {
            header('Location: ../../main/index.php?failure=You have to be logged in to add product to your favorites!&link=index.php');
        }

        //Fetching for provided product name
        $stmt = $conn -> prepare("SELECT * FROM product WHERE product_id = :productID");
        $stmt->bindParam(":productID", $_GET['productID'], PDO::PARAM_INT);
        $stmt->execute();
        $product = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if($_GET['mode'] == 'add')
        {
            $stmt = $conn -> prepare("INSERT INTO favourite_product (user_id, product_id) VALUES (:userID, :productID)");
            $stmt->bindParam(":productID", $_GET['productID'], PDO::PARAM_INT);
            $stmt->bindParam(":userID", $_SESSION['userID'], PDO::PARAM_INT);
            $stmt->execute();

            //Checking where user should be redirected
            if(isset($_GET['site']))
            {
                header('Location: ../../main/index.php?success=<b>'.$product[0]['name'].'</b> has been successfully added to favourite products!&link=index.php');
                die;
            }

            header('Location: ../../productPage/index.php?productID='.$_GET['productID'].'&success=<b>'.$product[0]['name'].'</b> has been successfully added to favourite products!&link=index.php?productID='.$_GET['productID']);
        }
        else
        {
            $stmt = $conn -> prepare("DELETE FROM favourite_product WHERE user_id = :userID AND product_id = :productID");
            $stmt->bindParam(":productID", $_GET['productID'], PDO::PARAM_INT);
            $stmt->bindParam(":userID", $_SESSION['userID'], PDO::PARAM_INT);
            $stmt->execute();

            if(isset($_GET['site']))
            {
                header('Location: ../../userProfile/index.php?productID='.$_GET['productID'].'&success=<b>'.$product[0]['name'].'</b> has been successfully deleted from favourite products!&link=index.php?productID='.$_GET['productID']);
                die;
            }

            header('Location: ../../productPage/index.php?productID='.$_GET['productID'].'&success=<b>'.$product[0]['name'].'</b> has been successfully deleted from favourite products!&link=index.php?productID='.$_GET['productID']);
        }
        die;

    }
    catch(PDOException $e) 
    {
        ?>
            <script>window.location.replace("../../errors/uncaught.php?errorCode=<?php echo $e->getMessage(); ?>");</script>
        <?php
    }
?>
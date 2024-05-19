<?php
try
    {
        //Importing database connection
        include('../../components/databaseConn.php');

        //Checking if user was logged in while trying to add to cart
        if(!isset($_SESSION['userID']))
        {
            header('Location: ../../main/?failure=You have to be logged in to add product review.&link='.$_SERVER['HTTP_REFERER']);
            die();
        }

        //Inserting new review to product_review table in database
        $stmt = $conn -> prepare("INSERT INTO product_review (user_id, product_id, review_content, rating) VALUES (:userID, :productID, :reviewContent, :rating)");
        $stmt->bindParam(":userID", $_SESSION['userID'], PDO::PARAM_INT);
        $stmt->bindParam(":productID", $_POST['productID'], PDO::PARAM_INT);
        $stmt->bindParam(":reviewContent", $_POST['reviewContent']);
        $stmt->bindParam(":rating", $_POST['rating'], PDO::PARAM_INT);
        $stmt->execute();
        
        //Updating product average rating
        $stmt = $conn -> prepare("SELECT AVG(rating) FROM product_review WHERE product_id = :productID");
        $stmt->bindParam(":productID", $_POST['productID'], PDO::PARAM_INT);
        $stmt->execute();
        $avgRating = $stmt->fetch(PDO::FETCH_ASSOC);
        $avgRating = $avgRating['AVG(rating)'];

        $stmt = $conn -> prepare("UPDATE product SET average_rating = ROUND(:avgRating, 0) WHERE product_id = :productID");
        $stmt->bindParam(":productID", $_POST['productID'], PDO::PARAM_INT);
        $stmt->bindParam(":avgRating", $avgRating);
        $stmt->execute();

        header('Location: ../../productPage/index.php?productID='.$_POST['productID'].'&success=Review about the has been successfully uploaded!&link=index.php?productID='.$_POST['productID']);
        die();
    }
    catch(PDOException $e) 
    {
        ?>
        <script>window.location.replace("../../errors/uncaught.php?errorCode=<?php echo $e->getMessage(); ?>");</script>
        <?php
    }
?>
<?php
try
{
    include('../../components/databaseConn.php');

    //Fetching for user cartID
    $stmt = $conn->prepare("SELECT * FROM cart WHERE user_id = :userID AND is_completed = 0");
    $stmt->bindParam(':userID', $_SESSION['userID'], PDO::PARAM_INT);
    $stmt->execute();
    $cartID = $stmt->fetch(PDO::FETCH_ASSOC);
    $cartID = $cartID['cart_id'];

    //Deleting provided product from provided user's cart
    $stmt = $conn->prepare("DELETE FROM cart_product WHERE cart_id = :cartID AND product_id = :productID");
    $stmt->bindParam(':productID', $_GET['productID'], PDO::PARAM_INT);
    $stmt->bindParam(':cartID', $cartID, PDO::PARAM_INT);
    $stmt->execute();

    //Calculating new cart subtotal
    $stmt = $conn->prepare("SELECT SUM(total_price) AS cartSubtotal FROM cart JOIN cart_product USING(cart_id) WHERE cart_id = :cartID");
    $stmt->bindParam(':cartID', $cartID, PDO::PARAM_INT);
    $stmt->execute();
    $subtotal = $stmt->fetch(PDO::FETCH_ASSOC);
    $subtotal = $subtotal['cartSubtotal'];

    //Updating cart subtotal
    $stmt = $conn->prepare("UPDATE cart SET cart_subtotal = :subtotal WHERE cart_id = :cartID");
    $stmt->bindParam(':cartID', $cartID, PDO::PARAM_INT);
    $stmt->bindParam(':subtotal', $subtotal);
    $stmt->execute();



    header('Location: ../../main/index.php?success=Product has been successfully deleted from cart!&link='.$_SERVER['HTTP_REFERER']);
}
catch(PDOException $e)
{
    ?>
    <script>window.location.replace("../../errors/uncaught.php?errorCode=<?php echo $e->getMessage(); ?>");</script>
    <?php
}

?>
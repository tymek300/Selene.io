<?php
try
{
    //Importing database connection
    include('../../components/databaseConn.php');

    //Checking if user was logged in while trying to add to cart
    if(!isset($_SESSION['userID']))
    {
        header('Location: ../../main/?failure=You have to be logged in to add product to cart.&link='.$_SERVER['HTTP_REFERER']);
        die();
    }

    //Fetching provided products price
    $stmt = $conn -> prepare("SELECT * FROM product WHERE product_id = :productID");
    $stmt->bindParam(":productID", $_GET['productID'], PDO::PARAM_INT);
    $stmt->execute();
    $productData = $stmt->fetch(PDO::FETCH_ASSOC);
    $price = $productData['price'];

    //Checking if user has got cart in database
    $stmt = $conn -> prepare("SELECT * FROM cart WHERE user_id = :userID AND is_completed = 0");
    $stmt->bindParam(":userID", $_SESSION['userID'], PDO::PARAM_INT);
    $stmt->execute();
    $cart = $stmt->fetch(PDO::FETCH_ASSOC);

    //If not creating user cart
    if (!$cart)
    {
        $stmt = $conn -> prepare("INSERT INTO cart (user_id) VALUES (:userID)");
        $stmt->bindParam(":userID", $_SESSION['userID'], PDO::PARAM_INT);
        $stmt->execute();
        $userCartID = $conn -> lastInsertId();
    }
    else
    {
        $stmt = $conn -> prepare("SELECT * FROM cart WHERE user_id = :userID AND is_completed = 0");
        $stmt->bindParam(":userID", $_SESSION['userID'], PDO::PARAM_INT);
        $stmt->execute();
        $userCartID = $stmt->fetch(PDO::FETCH_ASSOC);
        $userCartID = $userCartID['cart_id'];
    }

    //Checking if provided product is already in user's cart
    $stmt = $conn -> prepare("SELECT * FROM cart JOIN cart_product USING(cart_id) WHERE product_id = :productID AND cart_id = :cartID");
    $stmt->bindParam(":cartID", $userCartID, PDO::PARAM_INT);
    $stmt->bindParam(":productID", $_GET['productID'], PDO::PARAM_INT);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    //If provided product is already in cart, increasing quantity
    if($product)
    {
        //Error if user reached maximum available quantity
        if ($productData['quantity_available'] < $_GET['quantity'] + $product['quantity'])
        {
            header('Location: ../../main/?failure=Product cannot be added to cart because you reached maximum quantity available.&link='.$_SERVER['HTTP_REFERER']);
            die();
        }

        //Updating quantity and total price in cart_product table
        $stmt = $conn -> prepare("UPDATE cart JOIN cart_product USING(cart_id) SET quantity = quantity + :quantity, total_price = (quantity + :quantity) * :price WHERE cart_id = :cartID AND product_id = :productID");
        $stmt->bindParam(":cartID", $userCartID, PDO::PARAM_INT);
        $stmt->bindParam(":productID", $_GET['productID'], PDO::PARAM_INT);
        $stmt->bindParam(":quantity", $_GET['quantity'], PDO::PARAM_INT);
        $stmt->bindParam(":price", $price);
        $stmt->execute();

        //Calculating new cart subtotal
        $stmt = $conn->prepare("SELECT SUM(total_price) AS cartSubtotal FROM cart JOIN cart_product USING(cart_id) WHERE cart_id = :cartID");
        $stmt->bindParam(':cartID', $userCartID, PDO::PARAM_INT);
        $stmt->execute();
        $subtotal = $stmt->fetch(PDO::FETCH_ASSOC);
        $subtotal = $subtotal['cartSubtotal'];

        //Updating cart subtotal
        $stmt = $conn->prepare("UPDATE cart SET cart_subtotal = :subtotal WHERE cart_id = :cartID");
        $stmt->bindParam(':cartID', $userCartID, PDO::PARAM_INT);
        $stmt->bindParam(':subtotal', $subtotal);
        $stmt->execute();

        header('Location: ../../main/?success=Product was already in cart and its quantity has increased by <b>'.$_GET['quantity'].'</b>.&link='.$_SERVER['HTTP_REFERER']);
        die();
    }
    //If not adding product to users cart
    else
    {
        //Inserting product to cart_product table
        $stmt = $conn -> prepare("INSERT INTO cart_product (product_id, quantity, total_price, cart_id) VALUES (:productID, :quantity, :price * :quantity, :cartID)");
        $stmt->bindParam(":productID", $_GET['productID'], PDO::PARAM_INT);
        $stmt->bindParam(":quantity", $_GET['quantity'], PDO::PARAM_INT);
        $stmt->bindParam(":price", $price);
        $stmt->bindParam(":cartID", $userCartID, PDO::PARAM_INT);
        $stmt->execute();

        //Calculating new cart subtotal
        $stmt = $conn->prepare("SELECT SUM(total_price) AS cartSubtotal FROM cart JOIN cart_product USING(cart_id) WHERE cart_id = :cartID");
        $stmt->bindParam(':cartID', $userCartID, PDO::PARAM_INT);
        $stmt->execute();
        $subtotal = $stmt->fetch(PDO::FETCH_ASSOC);
        $subtotal = $subtotal['cartSubtotal'];

        //Updating cart subtotal
        $stmt = $conn->prepare("UPDATE cart SET cart_subtotal = :subtotal WHERE cart_id = :cartID");
        $stmt->bindParam(':cartID', $userCartID, PDO::PARAM_INT);
        $stmt->bindParam(':subtotal', $subtotal);
        $stmt->execute();

        header('Location: ../../main/?success=Product has been successfully added to cart.&link='.$_SERVER['HTTP_REFERER']);
        die();
    }
}
catch(PDOException $e)
{
    ?>
    <script>window.location.replace("../../errors/uncaught.php?errorCode=<?php echo $e->getMessage(); ?>");</script>
    <?php
}

?>

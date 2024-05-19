<?php
try
{
    //Importing database connection
    include('../../components/databaseConn.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
    {
        // Getting data from JSON request
        $data = json_decode(file_get_contents('php://input'), true);

        //Checking if provided JSON is correct
        if(isset($data['type']))
        {
            //Fetching provided products price
            $stmt = $conn -> prepare("SELECT * FROM product WHERE product_id = :productID");
            $stmt->bindParam(":productID", $data['productID'], PDO::PARAM_INT);
            $stmt->execute();
            $productData = $stmt->fetch(PDO::FETCH_ASSOC);
            $price = $productData['price'];

            //Fetching users cartID
            $stmt = $conn -> prepare("SELECT * FROM cart WHERE user_id = :userID AND is_completed = 0");
            $stmt->bindParam(":userID", $_SESSION['userID'], PDO::PARAM_INT);
            $stmt->execute();
            $userCartID = $stmt->fetch(PDO::FETCH_ASSOC);
            $userCartID = $userCartID['cart_id'];
        
            //Checking if user wants either increase or decrease quantity
            if($data['type'] == 1)
            {
                //Updating information about users cart in database
                $stmt = $conn -> prepare("UPDATE cart JOIN cart_product USING(cart_id) SET quantity = quantity + 1, total_price = (quantity + 1) * :price WHERE cart_id = :cartID AND product_id = :productID");
                $stmt->bindParam(":cartID", $userCartID, PDO::PARAM_INT);
                $stmt->bindParam(":productID", $data['productID'], PDO::PARAM_INT);
                $stmt->bindParam(":price", $price);
                $stmt->execute();

                $data['currQuantity']++;
            }
            else
            {
                //Updating information about users cart in database
                $stmt = $conn -> prepare("UPDATE cart JOIN cart_product USING(cart_id) SET quantity = quantity - 1, total_price = (quantity - 1) * :price WHERE cart_id = :cartID AND product_id = :productID");
                $stmt->bindParam(":cartID", $userCartID, PDO::PARAM_INT);
                $stmt->bindParam(":productID", $data['productID'], PDO::PARAM_INT);
                $stmt->bindParam(":price", $price);
                $stmt->execute();

                $data['currQuantity']--;
            }

            //Fetching clients new cart total price
            $stmt = $conn -> prepare("SELECT SUM(total_price) as cartSubtotal FROM cart JOIN cart_product USING(cart_id) WHERE cart_id = :cartID");
            $stmt->bindParam(":cartID", $userCartID, PDO::PARAM_INT);
            $stmt->execute();
            $cartSubtotal = $stmt->fetch(PDO::FETCH_ASSOC);
            $cartSubtotal = $cartSubtotal['cartSubtotal'];

            //Fetching clients cart promo code if exists
            $stmt = $conn -> prepare("SELECT * FROM cart JOIN promo_code USING(promo_code_id) WHERE cart_id = :cartID");
            $stmt->bindParam(":cartID", $userCartID, PDO::PARAM_INT);
            $stmt->execute();
            $discount = $stmt->fetch(PDO::FETCH_ASSOC);

            if(isset($discount['discount']))
            {
                $discount = $discount['discount'];
            }
            else
            {
                $discount = "";
            }
            
            //Updating cart subtotal
            $stmt = $conn->prepare("UPDATE cart SET cart_subtotal = :subtotal WHERE cart_id = :cartID");
            $stmt->bindParam(":cartID", $userCartID, PDO::PARAM_INT);
            $stmt->bindParam(':subtotal', $cartSubtotal);
            $stmt->execute();

            //Formatting prices
            $productTotal = number_format($price * $data['currQuantity'], 2, '.', '');
            $cartSubtotal = number_format($cartSubtotal, 2, '.', '');

            //Sending answer back to the users current site
            http_response_code(200);
            echo json_encode([
                "productTotalPrice" => $productTotal,
                "cartSubtotal" => $cartSubtotal,
                "discount" => $discount
            ]);
        }
    }
    else
    {
        http_response_code(500);
    }
}
catch(PDOException $e)
{
    ?>
    <script>window.location.replace("../../errors/uncaught.php?errorCode=<?php echo $e->getMessage(); ?>");</script>
    <?php
}
?>
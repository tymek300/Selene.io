<?php
    try
    {
        //ImportingDatabaseConnection
        include('../../components/databaseConn.php');



        //WORK IN PROGRESS, add here Payment API for ex. PayPal, GooglePay


        //DATABASE MANAGMENT SECTION
        //Checking if user already has adress in databese
        $stmt = $conn -> prepare("SELECT * FROM user_adress WHERE user_id = :userID");
        $stmt->bindParam(":userID", $_SESSION['userID'] , PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$result)
        {
            //Inserting user adress to database
            $stmt = $conn -> prepare("INSERT INTO user_adress (user_id, country, street, house_number, city, postal_code) VALUES (:userID, :country, :street, :houseNumber, :city, :postal_code)");
            $stmt->bindParam(":userID", $_SESSION['userID'] , PDO::PARAM_INT);
            $stmt->bindParam(":country", $_POST['country'] );
            $stmt->bindParam(":street", $_POST['street'] );
            $stmt->bindParam(":houseNumber", $_POST['houseNumber'] );
            $stmt->bindParam(":city", $_POST['city'] );
            $stmt->bindParam(":postal_code", $_POST['postalCode'] );
            $stmt->bindParam(":country", $_POST['country'] );
            $stmt->execute();

            $adressID = $conn->lastInsertId();
        }
        else
        {
            //Updating user adress to database
            $stmt = $conn -> prepare("UPDATE user_adress SET country = :country, street = :street, house_number = :houseNumber, city = :city, postal_code = :postal_code WHERE user_id = :userID");
            $stmt->bindParam(":userID", $_SESSION['userID'] , PDO::PARAM_INT);
            $stmt->bindParam(":country", $_POST['country']);
            $stmt->bindParam(":street", $_POST['street']);
            $stmt->bindParam(":houseNumber", $_POST['houseNumber']);
            $stmt->bindParam(":city", $_POST['city'] );
            $stmt->bindParam(":postal_code", $_POST['postalCode']);
            $stmt->execute();

            $adressID = $result['user_adress_id'];
        }
        
        //Inserting order to database with PAID status
        $stmt = $conn -> prepare("INSERT INTO order_ (cart_id, name, surname, mail, phone_number, user_adress_id, order_status_id, order_total) VALUES (:cartID, :name, :surname, :mail, :phoneNumber, :userAdressID, 2, :orderTotal)");
        $stmt->bindParam(":cartID", $_POST['cartID'], PDO::PARAM_INT);
        $stmt->bindParam(":name", $_POST['name'] );
        $stmt->bindParam(":surname", $_POST['surname'] );
        $stmt->bindParam(":mail", $_POST['mail'] );
        $stmt->bindParam(":phoneNumber", $_POST['phoneNumber'] );
        $stmt->bindParam(":userAdressID", $adressID, PDO::PARAM_INT);
        $stmt->bindParam(":orderTotal", $_POST['totalPrice']);
        $stmt->execute();

        $invoiceOrderID = $conn->lastInsertId();

        //Updating user cart flag to completed
        $stmt = $conn -> prepare("UPDATE cart SET is_completed = 1 WHERE user_id = :userID");
        $stmt->bindParam(":userID", $_SESSION['userID'] , PDO::PARAM_INT);
        $stmt->execute();

        //============================================================================
        //INVOICE SECTION
        //Importing order invoice generating script
        include("InvoiceGenerateCART.php");

        //Generating order invoice
        $invoicePath = GenerateAndSaveInvoice($_POST['cartID'], $_SESSION['userID'], $invoiceOrderID, $_POST['subtotalPrice'], $_POST['totalPrice']);
        

        //============================================================================
        //ORDER MAIL SECTION
        //Importing order mail sending script
        include("../Mails/OrderPaidUnpaidMail.php");

        //Creating variable holding adress
        $adress = $_POST['street']." ".$_POST['houseNumber']." || ".$_POST['city']." ".$_POST['postalCode']." || ".$_POST['country'];

        //Sending order confirmation mail
        SendOrderPaidUnpaidMail($_POST['name'], $_POST['surname'], "Paid", $invoiceOrderID, $_POST['phoneNumber'], $adress, $_POST['totalPrice'], $invoicePath, $_POST['mail']); 
        
        //============================================================================
        //DATABASE MANAGMENT SECTION
        //Fetching product IDs and their quantities from the cart
        $stmt = $conn->prepare("SELECT product_id, quantity FROM cart_product WHERE cart_id = :cartID");
        $stmt->bindParam(":cartID", $_POST['cartID'], PDO::PARAM_INT);
        $stmt->execute();
        $cartProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //Updating the number of available and sold products
        foreach ($cartProducts as $product) {
            //Decreasing the number of available products and increasing number of sold products
            $stmt = $conn->prepare("UPDATE product SET quantity_available = quantity_available - :quantity, quantity_sold = quantity_sold + :quantity WHERE product_id = :productID");
            $stmt->bindParam(":quantity", $product['quantity'], PDO::PARAM_INT);
            $stmt->bindParam(":productID", $product['product_id'], PDO::PARAM_INT);
            $stmt->execute();
        }

        //============================================================================
        //REDIRECTING TO ORDER CONFIRMATION PAGE
        header('Location: ../../orderStatus/?orderID='.$invoiceOrderID.'&confirmation=true');

    }
    catch(PDOException $e) 
    {
        ?>
        <script>window.location.replace("../../errors/uncaught.php?errorCode=<?php echo $e->getMessage(); ?>");</script>
        <?php
    }

?>
?>
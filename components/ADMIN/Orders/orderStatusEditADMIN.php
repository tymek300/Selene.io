<?php
    try
    {
        include('../../../components/databaseConn.php');

        //Checking if order id is provided
        if(!isset($_POST['orderID']) && !empty($_POST['orderID']))
        {
            header('Location: ../../../admin_dashboard/orders.php?failure=Order ID not provided!&link=orders.php');
            die();
        }

        //Checking if new status is the same as old one
        //Fetching order data
        $stmt = $conn->prepare("SELECT * FROM order_ WHERE order_id = :orderID");
        $stmt->bindParam(':orderID', $_POST['orderID']);
        $stmt->execute();
        $orderData = $stmt->fetch(PDO::FETCH_ASSOC);

        // Checking if the new status is the same as the old one
        if ($orderData['order_status_id'] == $_POST['orderStatus']) {
            header('Location: ../../../admin_dashboard/orders.php?failure=New status is the same as the current status.&link=orders.php');
            die();
        }

        //Importing status change mail sending script
        include('../../Mails/orderStatusChangeMail.php');

        //Checking which status was selected and sending mail
        switch($_POST['orderStatus'])
        {
            case '1': // Unpaid
                $success = SendOrderStatusChangeMail($orderData['name'], $orderData['surname'], 'Unpaid', $_POST['orderID'], $orderData['mail']);
                break;
            case '2': // Paid
                $success = SendOrderStatusChangeMail($orderData['name'], $orderData['surname'], 'Paid', $_POST['orderID'], $orderData['mail']);
                break;
            case '3': // Completed
                $success = SendOrderStatusChangeMail($orderData['name'], $orderData['surname'], 'Completed', $_POST['orderID'], $orderData['mail']);
                break;
            case '4': // Cancelled
                $success = SendOrderStatusChangeMail($orderData['name'], $orderData['surname'], 'Cancelled', $_POST['orderID'], $orderData['mail']);
                break;
        }

        if($success == 1)
        {
            //Updating order status in the database
            $stmt = $conn->prepare("UPDATE order_ SET order_status_id = :orderStatus WHERE order_id = :orderID");
            $stmt->bindParam(':orderStatus', $_POST['orderStatus']);
            $stmt->bindParam(':orderID', $_POST['orderID']);
            $stmt->execute();
        }

        header('Location: ../../../admin_dashboard/orders.php?success=Order status changed successfully!&link=orders.php');
        die();

    }
    catch(PDOException $e) 
    {
        ?>
        <script>window.location.replace("../../../errors/uncaught.php?errorCode=<?php echo $e->getMessage(); ?>");</script>
        <?php
    }

?>
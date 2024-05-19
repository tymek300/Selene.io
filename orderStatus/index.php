<!DOCTYPE html>
<html lang="en">

<head>
    <title>Selene.io</title>
    
    <?php
        //Importing header tags
        include("../components/headerparams.php");
    ?>
</head>

<body>

    <?php
        // Importing header
        include('../components/headernav.php');
    ?>

    <section class="main-content-box">

        <?php
            try 
            {
                ?>
                    <div class="order-data-container">
                        <h2 class="title">
                            You can see your order status here
                        </h2>

                        <form class="order-status-form" action="index.php" method="get">
                            <input placeholder="Your order ID" name="orderID" type="number" required>
                            <button>Check order status</button>
                        </form>

                        <?php
                            if(isset($_GET['confirmation']) && !empty($_GET['confirmation']))
                            {
                                //Fetching order informations if user is redirected form order process script
                                $stmt = $conn -> prepare("SELECT * FROM order_ JOIN order_status USING(order_status_id) WHERE order_id = :orderID");
                                $stmt->bindParam(":orderID", $_GET['orderID'], PDO::PARAM_INT);
                                $stmt->execute();
                                $orderInfo = $stmt->fetch(PDO::FETCH_ASSOC);

                                if($orderInfo)
                                {
                                    ?>
                                        <div class="order-status-box">
                                            Your order has been successfully received with ID: <b><?php echo($orderInfo['order_id']) ?></b>. 
                                            <br>
                                            Your current order status is <b><?php echo($orderInfo['status']) ?></b>. Parcel will be delivered in 2-5 days.
                                        </div>
                                    <?php
                                }
                            }
                            elseif(isset($_GET['orderID']) && !empty($_GET['orderID']))
                            {
                                //Fetching order informations if user used form
                                $stmt = $conn -> prepare("SELECT * FROM order_ JOIN order_status USING(order_status_id) WHERE order_id = :orderID");
                                $stmt->bindParam(":orderID", $_GET['orderID'], PDO::PARAM_INT);
                                $stmt->execute();
                                $orderInfo = $stmt->fetch(PDO::FETCH_ASSOC);

                                if($orderInfo)
                                {
                                    if($orderInfo['order_status_id'] == 1 || $orderInfo['order_status_id'] == 2)
                                    {
                                        ?>
                                            <div class="order-status-box">
                                            Your order number is <b><?php echo($orderInfo['order_id']) ?></b>. 
                                            <br>
                                            Your current order status is <b><?php echo($orderInfo['status']) ?></b>. Parcel will be delivered in 2-5 days.
                                        </div>
                                        <?php
                                    }
                                    elseif($orderInfo['order_status_id'] == 3)
                                    {
                                        ?>
                                            <div class="order-status-box">
                                                Your order number is <b><?php echo($orderInfo['order_id']) ?></b>. 
                                                <br>
                                                Your current order status is <b><?php echo($orderInfo['status']) ?></b>. Thank you for choosing us!
                                            </div>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                            <div class="order-status-box">
                                                Your order number is <b><?php echo($orderInfo['order_id']) ?></b>. 
                                                <br>
                                                Your current order status is <b><?php echo($orderInfo['status']) ?></b>. If you want to get more information about your order, please contact our customer support.
                                            </div>
                                        <?php
                                    }
                                }
                                else
                                {
                                    FailureMessage("Order with provided ID does not exist. Check order ID and try again.", "index.php");
                                }
                            }
                        ?>
                        
                    </div>
                <?php
            } 
            catch(PDOException $e) 
            {
                ?>
                    <script>window.location.replace("../errors/uncaught.php?errorCode=<?php echo $e->getMessage(); ?>");</script>
                <?php
            }
        ?>
    </section>

    <?php
        //Importing footer
        include("../components/footer.php");
    ?>
</body>
</html>

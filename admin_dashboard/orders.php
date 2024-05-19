<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        //Importing header tags
        include("../components/headerparams.php");

        //Checking if user is logged in, and if is admin
        if(!isset($_SESSION['userID']) || $_SESSION['admin'] == 0)
        {
            FailureMessage("You have no permissions to see this page.", "../main/");
            echo '<title>No permissions</title>';
            die;
        }
    ?>
    <title>Welcome <?php echo $_SESSION['nickname']?>!</title>
</head>
<body>
    <section class="content">

        <!-- EDITING ORDER STATUS -->
        <div class="body-overlay order-status-form-box">
            <div class="dialog-box">

                <div class="icon">
                        <i class="fa-solid fa-seal-question" style="color: #8240d4;"></i>
                </div>

                <div class="message">
                    You can edit the status of an order below.
                </div>

                <form action="../components/ADMIN/Orders/orderStatusEditADMIN.php" method="post" class="orderStatusForm">
                            
                    <input type="number" min="1" class="idInput" name="orderID" hidden required>

                    <label>
                        <span>Status: </span>
                        <select name="orderStatus"> 
                            <?php

                            //Fetching for order statuses
                            $stmt = $conn->prepare("SELECT * FROM order_status");
                            $stmt->execute();
                            $orderStatuses = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            foreach($orderStatuses as $orderStatus)
                            {
                                ?>
                                    <option value="<?php echo $orderStatus['order_status_id'] ?>"><?php echo $orderStatus['status'] ?></option>
                                <?php
                            }
                            
                            ?>
                            
                        </select>
                    </label>

                    <div>
                        <button class="close-btn" style="background-color: #32de84">Submit</button> &nbsp;
                        <button class="close-btn" type="button" style="background-color: #654ab8" onclick="closeDialog('orders.php')">Close</button>
                    </div>
                </form>
            </div>
        </div>

        <?php
            //Importing baner
            include("../components/ADMIN/sideNavbarADMIN.php");
            RenderSideNavbar(2);
        ?>

        <section class="main">

            <?php
                //Importing baner
                include("../components/ADMIN/banerADMIN.php")
            ?>

            <div class="filter-bar">

                <form class="filter-form" method="get">

                    <div class="form-inputs">

                        <div class="input-box">
                            <label for="codeName">Order ID: </label>
                            <input type="number" min="1" name="orderID">
                        </div>

                        <div class="input-box">
                            <label for="productCategory">Order status: </label>
                            <select name="orderStatus"> 
                                <option value="0" disabled selected>Choose option</option>
                                <?php

                                //Fetching for categories
                                $stmt = $conn->prepare("SELECT * FROM order_status");
                                $stmt->execute();
                                $orderStatuses = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                foreach($orderStatuses as $orderStatus)
                                {
                                    ?>
                                        <option value="<?php echo($orderStatus['order_status_id']) ?>"><?php echo($orderStatus['status']) ?></option>
                                    <?php
                                }
                                
                                ?>
                            </select>
                        </div>

                        <div class="input-box">
                            <label for="customerMail">Customer Mail: </label>
                            <input type="email" name="mail">
                        </div>

                    </div>

                    <div class="filter-actions">
                        <button>
                            Filter Orders
                        </button>
                    </div>
                    
                </form>
            </div>

            <?php

            //Creating varabiable to hold possible conditions
            $condition = "";

            //If user marks desirable order ID
            if(!empty($_GET['orderID']))
            {
                $condition .= "AND order_id LIKE '%{$_GET['orderID']}%'";
            }

            //If user marks desirable order status
            if(!empty($_GET['orderStatus']) && $_GET['orderStatus'] != "0") 
            {
                $condition .= " AND order_status_id = {$_GET['orderStatus']}";
            }

            //If user marks desirable order customer mail
            if(!empty($_GET['customerMail'])) 
            {
                $condition .= " AND mail LIKE '%{$_GET['mail']}%'";
            }

            //Fetching for categories with certain parameters
            $stmt = $conn->prepare("SELECT * FROM order_ JOIN order_status USING(order_status_id) WHERE 1 $condition");
            $stmt->execute();
            $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach($orders as $order)
            {
                ?>
                    <section class="order-bar">
                        <div class="order-informations">
                            <div class="order-id">
                                <?php echo $order['order_id'] ?>
                            </div>
                            <hr>
                            <div class="order-customer-name">
                                <?php echo $order['name']." ".$order['surname'] ?>
                            </div>
                            <hr>
                            <div class="order-customer-mail">
                                <?php echo $order['mail'] ?>
                            </div>
                            <hr>
                            <div class="order-creation-time">
                                <?php echo substr($order['creation_time'], 0, 10) ?>
                            </div>
                            <hr>
                            <div class="order-status">
                                <?php echo $order['status'] ?>
                            </div>
                        </div>
                        <div class="user-actions">
                            <a href="../companyFiles/invoices/INV<?php echo($order['order_id']) ?>.pdf">
                                Show order invoice
                            </a>
                            <a onclick="ChangeOrderStatus(<?php echo $order['order_id'] ?>)" style="background-color: #FFAC1C;">
                                Change order status
                            </a>
                        </div>
                    </section>
                <?php
            }
            ?>
            
        </section>
    </section>
    <!--Internal Scripts Import-->
    <script src="./script.js"></script>
</body>
</html>
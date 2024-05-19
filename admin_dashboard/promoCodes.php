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

        <!-- PROMO CODE MODIFICATION -->
        <div class="body-overlay promo-code-modification-form-box">
            <div class="dialog-box">

                <div class="icon">
                        <i class="fa-solid fa-seal-question" style="color: #8240d4;"></i>
                </div>

                <div class="message">
                    You can modify promo code details below.
                </div>

                <form action="../components/ADMIN/PromoCodes/promoCodeModificationAddDeleteADMIN.php" method="post" class="promoCodeModificationForm">
                    <legend>Edit details: </legend>

                    <input type="text" class="idInput" name="ID" required hidden>
                    <input type="text" class="idInput" name="oldName" required hidden>

                    <input type="text" class="typeInput" name="type" value="modify" required hidden>

                    <label>
                        <span>Name: </span>
                        <input type="text" class="formTextInput" name="newName" required>
                    </label>

                    <label>
                        <span>Discount: </span>
                        <input type="text" class="formTextInput" name="newDiscount" required>
                    </label>
                    
                    <div>
                        <button class="close-btn" style="background-color: #32de84">Submit</button> &nbsp;
                        <button class="close-btn" type="button" style="background-color: #654ab8" onclick="closeDialog('promoCodes.php')">Close</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- DELETE PROMO CODE -->
        <div class="body-overlay promo-code-delete-form-box">
            <div class="dialog-box">

                <div class="icon">
                        <i class="fa-solid fa-seal-question" style="color: #8240d4;"></i>
                </div>

                <div class="message">
                    Are you sure you want to delete this promo code?
                    <br>
                    <b>Warning: </b> This may affect users carts.
                </div>

                <form action="../components/ADMIN/PromoCodes/promoCodeModificationAddDeleteADMIN.php" method="post" class="promoCodeDeleteForm">
                    <input type="text" class="idInput" name="ID" required hidden>
                    <input type="text" class="typeInput" name="type" value="delete" required hidden>
                    <div>
                        <button class="close-btn" style="background-color: #E32636">Submit</button> &nbsp;
                        <button class="close-btn" type="button" style="background-color: #654ab8" onclick="closeDialog('promoCodes.php')">Close</button>
                    </div>
                </form>
            </div>
        </div>


        <!-- PROMO CODE ADDING -->
        <div class="body-overlay promo-code-add-form-box">
            <div class="dialog-box">

                <div class="icon">
                    <i class="fa-solid fa-seal-question" style="color: #8240d4;"></i>
                </div>

                <div class="message">
                    You can add promo code below.
                </div>

                <form action="../components/ADMIN/PromoCodes/promoCodeModificationAddDeleteADMIN.php" method="post" class="promoCodeAddForm">
                    <legend>Set promo code details: </legend>

                    <input type="text" class="typeInput" name="type" value="add" required hidden>

                    <label>
                        <span>Name: </span>
                        <input type="text" class="formTextInput" name="newName" required>
                    </label>

                    <label>
                        <span>Discount: </span>
                        <input type="number" step="0.01" min="0.1" max="0.5" class="formTextInput" name="newDiscount" required>
                    </label>

                    <div>
                        <button class="close-btn" style="background-color: #32de84">Submit</button> &nbsp;
                        <button class="close-btn" type="button" style="background-color: #654ab8" onclick="closeDialog('promoCodes.php')">Close</button>
                    </div>
                </form>
            </div>
        </div>

        <?php
            //Importing baner
            include("../components/ADMIN/sideNavbarADMIN.php");
            RenderSideNavbar(4);
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
                            <label for="codeName">Code name: </label>
                            <input type="text" name="codeName">
                        </div>
                    </div>

                    <div class="filter-actions">
                        <button>
                            Filter Promo Codes
                        </button>
                        <a onclick="AddPromoCode()" style="background-color: #32de84"> 
                            Add new Promo Code
                        </a>
                    </div>
                    
                </form>
            </div>

            <?php

            //Creating varabiable to hold possible conditions
            $condition = "";

            //If user marks desirable code name
            if(!empty($_GET['codeName']))
            {
                $condition .= "AND code LIKE '%{$_GET['codeName']}%'";
            }

                //Fetching for categories with certain parameters
                $stmt = $conn->prepare("SELECT * FROM promo_code WHERE 1 $condition");
                $stmt->execute();
                $promoCodes = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach($promoCodes as $promoCode)
                {
                    ?>
                        <section class="promo-code-bar">
                            <div class="promo-code-informations">
                                <div class="promo-code-name">
                                    <?php echo $promoCode['code'] ?>
                                </div>
                                <hr>
                                <div class="promo-code-discount">
                                    <?php echo(($promoCode['discount'] * 100)."%") ?>
                                </div>
                            </div>
                            <div class="user-actions">
                                <a onclick="ModifyPromoCode(<?php echo $promoCode['promo_code_id']. ', \''. $promoCode['code']. '\''. ', \''. $promoCode['discount']. '\'' ?>)">
                                    Modify code details
                                </a>
                                <a onclick="DeletePromoCode(<?php echo $promoCode['promo_code_id']?>)" style="background-color: #fd5c63;">
                                    Delete code
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
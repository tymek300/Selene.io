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

        //Checking if user chosen product to see its photos
        if(!isset($_GET['productID']))
        {
            FailureMessage("<b>Error:</b> You have to choose product which photos should be displayed.", "products.php");
            echo '<title>No product chosen</title>';
            die;
        }
        else
        {
            //Fetching for product whose photos should be displayed
            $stmt = $conn->prepare("SELECT * FROM product WHERE product_id = :productID");
            $stmt->bindParam(':productID', $_GET['productID'], PDO::PARAM_INT);
            $stmt->execute();
            $product = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    ?>
    <title>Welcome <?php echo $_SESSION['nickname']?>!</title>
</head>
<body>
    <section class="content">

    <!-- PRODUCT PHOTO ADDING -->
    <div class="body-overlay photo-add-form-box">
        <div class="dialog-box">

            <div class="icon">
                    <i class="fa-solid fa-seal-question" style="color: #8240d4;"></i>
            </div>

            <div class="message">
                You can add product photos below:
            </div>

            <form action="../components/ADMIN/ProductPhotos/photoAddADMIN.php" enctype="multipart/form-data" method="post" class="photoAddForm">
                <input type="text" class="idInput" name="ID" required hidden>

                <label>
                    <span>Photos: </span>
                    <input type="file" name="productPhotos[]" multiple accept=".jpg,.png,.jpeg" required>
                </label>

                <div>
                    <button class="close-btn" style="background-color: #32de84">Submit</button> &nbsp;
                    <button class="close-btn" type="button" style="background-color: #654ab8" onclick="closeDialog('product_photos.php?productID=<?php echo $_GET['productID'] ?>')">Close</button>
                </div>
            </form>
        </div>
    </div>

    <!-- PRODUCT PHOTO DELETING -->
    <div class="body-overlay photo-delete-form-box">
        <div class="dialog-box">

            <div class="icon">
                    <i class="fa-solid fa-seal-question" style="color: #8240d4;"></i>
            </div>

            <div class="message">
                Are you sure you want to delete this photo?
                <div class="warning"> 
                    <b>Warning: </b> This photo is main photo of <b> <?php echo $product[0]['name'] ?> </b> product which you are editing. It means that it is displayed on store's home site. 
                </div>
            </div>

            <form action="../components/ADMIN/ProductPhotos/photoDeleteADMIN.php" method="post" class="photoDeleteForm">
                <input type="text" class="idInput" name="ID" required hidden>

                <div>
                    <button class="close-btn" style="background-color: #E32636">Submit</button> &nbsp;
                    <button class="close-btn" type="button" style="background-color: #654ab8" onclick="closeDialog('product_photos.php?productID=<?php echo $_GET['productID'] ?>')">Close</button>
                </div>
            </form>
        </div>
    </div>

    <!-- SET PHOTO MAIN -->
    <div class="body-overlay photo-main-form-box">
        <div class="dialog-box">

            <div class="icon">
                    <i class="fa-solid fa-seal-question" style="color: #8240d4;"></i>
            </div>

            <div class="message">
                Are you sure you want to set this photo as main photo of the product.
                <div> 
                    <b>Notice: </b> Product main photo is displayed on the store's home page.
                </div>
            </div>

            <form action="../components/ADMIN/ProductPhotos/photoSetMainADMIN.php" method="post" class="photoMainForm">
                <input type="text" class="idInput" name="photoID" required hidden>
                <input type="text" class="idInput" name="productID" required hidden>

                <div>
                    <button class="close-btn" style="background-color: #32de84">Submit</button> &nbsp;
                    <button class="close-btn" type="button" style="background-color: #654ab8" onclick="closeDialog('product_photos.php?productID=<?php echo $_GET['productID'] ?>')">Close</button>
                </div>
            </form>
        </div>
    </div>


    <?php
        //Importing baner
        include("../components/ADMIN/sideNavbarADMIN.php");
        RenderSideNavbar(1);
    ?>

    <section class="main">

        <?php
            //Importing baner
            include("../components/ADMIN/banerADMIN.php")
        ?>

        <section class="product-title-photos">
            <span></span>
            <h2>
                <?php 
                    echo $product[0]['name'];
                ?>
            </h2>
            <div class="filter-actions">
                <a onclick="AddPhoto(<?php echo $_GET['productID'] ?>)" style="background-color: #32de84"> 
                    Add new photos
                </a>
            </div>
        </section>

        <section class="product-photos-gallery">
            <?php

                //Fetching for product main photo
                $stmt = $conn->prepare("SELECT * FROM product_photos WHERE product_id = :productID AND main = 1");
                $stmt->bindParam(':productID', $_GET['productID'], PDO::PARAM_INT);
                $stmt->execute();
                $photo = $stmt->fetchAll(PDO::FETCH_ASSOC);

            ?>
                <div class="product-photo-gallery">
                    <img src="<?php echo $photo[0]['path'] ?>" alt="ProductPhoto">

                    <div class="main-icon">
                        <i class="fa-solid fa-house" style="color: #696cff;"></i>
                    </div>
                    <div class="photo-actions-box">
                        <a class="delete-button" style="width: 100%" onclick="DeletePhoto(<?php echo $photo[0]['photo_id']. ', '. $photo[0]['main'] ?>)">
                            Delete
                        </a>
                    </div>
                </div>

            <?php

                //Fetching for product other photos
                $stmt = $conn->prepare("SELECT * FROM product_photos WHERE product_id = :productID AND main = 0");
                $stmt->bindParam(':productID', $_GET['productID'], PDO::PARAM_INT);
                $stmt->execute();
                $photos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
                foreach($photos as $photo)
                {
                    ?>
                    <div class="product-photo-gallery">
                        <img src="<?php echo $photo['path'] ?>" alt="ProductPhoto">

                        <div class="photo-actions-box">
                            <a class="delete-button" onclick="DeletePhoto(<?php echo $photo['photo_id']. ', '. $photo['main'] ?>)">
                                Delete
                            </a>
                            <a onclick="PhotoMain(<?php echo $photo['photo_id']. ', '. $photo['product_id'] ?>)" class="set-main">
                                Set photo as main
                            </a>
                        </div>
                    </div>
                    <?php
                }
            ?>
            
        </section>
    </section>

    <!--Internal Scripts Import-->
    <script src="./script.js"></script>
</body>
</html>
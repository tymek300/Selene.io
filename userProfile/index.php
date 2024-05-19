<!DOCTYPE html>
<html lang="en">

<head>
    <?php
        //Importing header tags
        include("../components/headerparams.php");

        try
        {
            //Checking if user is logged in, otherwise redirecting to log in form
            if(!isset($_SESSION['userID']))
            {
                FailureMessage("You have to be logged in to see user profile page.", "../loginForm/");
                echo '<title>Unknown</title>';

                die;
            }
            else
            {
                $userID = $_SESSION['userID'];
                $nickname = $_SESSION['nickname'];
                $profilePicture = $_SESSION['profilePicture'];
                $mail = $_SESSION['mail'];
                $joinDate = $_SESSION['joinDate'];
                $admin = $_SESSION['admin'];

            }
            
            //Checking if user want to see other user's profile
            if(isset($_GET['userID']) && $_GET['userID'] != $_SESSION['userID'])
            {
                $userID = $_GET['userID'];

                $stmt = $conn -> prepare("SELECT * FROM user WHERE user_id = :userID");
                $stmt->bindParam(":userID", $userID, PDO::PARAM_INT);
                $stmt->execute();
                $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $nickname = $user[0]['nickname'];
                $profilePicture = $user[0]['profile_picture'];
                $mail = $user[0]['mail'];
                $joinDate = $user[0]['join_date'];
                $admin = $user[0]['admin'];
            }
    ?>

    <title><?php echo $nickname?>'s Profile</title>
</head>

<body>

    <?php
        // Importing header
        include('../components/headernav.php');
    ?>

    
    <!-- PROFILE PICTURE -->
    <div class="body-overlay custom-dialog profile-picture">
        <div class="dialog-box">

        <div class="icon">
                <i class="fa-solid fa-seal-question" style="color: #8240d4;"></i>
        </div>

        <div class="message">
            Upload new picture that you want to use as your profile picture.
        </div>

        <form action="../components/PROFILE/profilePictureChange.php" method="post" enctype="multipart/form-data" class="profilePictureForm">
            <label for="profilePicture">
                <span>Select new image:</span>
                <input type="file" class="custom-file-upload" name="profilePicture" accept=".jpg,.png,.jpeg" required >
            </label>
            
            <div>
                <button class="close-btn" style="background-color: #32de84">Submit</button> &nbsp;
                <button class="close-btn" type="button" style="background-color: #654ab8" onclick="closeDialog('index.php')">Close</button>
            </div>
        </form>

        </div>
    </div>

    <!-- NICKNAME CHANGE -->
    <div class="body-overlay custom-dialog nickname-change">
        <div class="dialog-box">

        <div class="icon">
                <i class="fa-solid fa-seal-question" style="color: #8240d4;"></i>
        </div>

        <div class="message">
            Change your nickname. Enter new nickname below.
        </div>

        <form action="../components/PROFILE/profileChangeNickname.php" method="post">
            <label for="profilePicture">
                <span>Set new nickname:</span>
                <input type="text" class="formTextInput" name="newNickname" required>
            </label>
            
            <div>
                <button class="close-btn" style="background-color: #32de84">Submit</button> &nbsp;
                <button class="close-btn" type="button" style="background-color: #654ab8" onclick="closeDialog('index.php')">Close</button>
            </div>
        </form>

        </div>
    </div>

    <!-- PROFILE DELETING -->
    <div class="body-overlay custom-dialog delete-profile">
        <div class="dialog-box">

            <div class="icon">
                <i class="fa-solid fa-seal-question" style="color: #8240d4;"></i>
            </div>

            <div class="message">
                Are you sure you want to delete your profile?
                <br>
                <b>Warning: </b> You will not be able to recover it after that.
            </div>

            <button style="background-color: #E32636" class="close-btn" onclick="closeDialog('../components/PROFILE/profileDelete.php?userID=<?php echo $_SESSION['userID']; ?>')">Delete</button>  &nbsp;
            <button class="close-btn" onclick="closeDialog('index.php')">Close</button>
        </div>
    </div>

    <section class="profile-info-section">

        <article class="profile-picture-box">
            <img src="<?php echo $profilePicture; ?>" alt="ProfilePicture">
        </article>

        <article class="profile-informations-box">

            <h2>User Info</h2>

            <ul>
                <li>
                    <div>
                        <i class="fa-regular fa-signature fa-lg"></i>
                        <span>Nickname</span>
                    </div>
                    <div>
                        <span><?php echo $nickname; ?></span>
                    </div>
                </li>

                <li>
                    <div>
                        <i class="fa-regular fa-address-card fa-lg"></i>
                        <span>User ID</span>
                    </div>
                    <div>
                        <span><?php echo $userID; ?></span>
                    </div>
                </li>

                <li>
                    <div>
                        <i class="fa-regular fa-calendar-check fa-lg"></i>
                        <span>Registered</span>
                    </div>
                    <div>
                        <span><?php echo $joinDate; ?></span>
                    </div>
                </li>

                <li>
                    <div>
                        <i class="fa-regular fa-at fa-lg"></i>
                        <span>E-Mail</span>
                    </div>
                    <div>
                        <span><?php echo $mail; ?></span>
                    </div>
                </li>

                <?php

                //Displaying information if user is admin
                if($admin == 1)
                {
                    ?>
                        <li>
                            <div>
                                <i class="fa-regular fa-user-crown fa-lg"></i>
                                <span>User status</span>
                            </div>
                            <div>
                                <span>Admin status</span>
                            </div>
                        </li>
                    <?php
                }
                else
                {
                    //Fetching user register method
                    $stmt = $conn -> prepare("SELECT name FROM user JOIN user_register_option USING(user_register_option_id) WHERE user_id = :userID");
                    $stmt->bindParam(":userID", $userID, PDO::PARAM_INT);
                    $stmt->execute();
                    $registerOption = $stmt->fetch(PDO::FETCH_ASSOC);


                    switch($registerOption['name'])
                    {
                        case 'Discord': ?>
                            <li>
                                <div>
                                    <i class="fa-brands fa-discord fa-lg"></i>
                                    <span>Registered Via: </span>
                                </div>
                                <div>
                                    <span>Discord</span>
                                </div>
                            </li>
                        <?php break;
                        case 'Google': ?>
                            <li>
                                <div>
                                    <i class="fa-brands fa-google fa-lg"></i>
                                    <span>Registered Via: </span>
                                </div>
                                <div>
                                    <span>Google</span>
                                </div>
                            </li>
                        <?php break;
                        case 'Facebook': ?>
                            <li>
                                <div>
                                    <i class="fa-brands fa-facebook fa-lg"></i>
                                    <span>Registered Via: </span>
                                </div>
                                <div>
                                    <span>Facebook</span>
                                </div>
                            </li>
                        <?php break;
                        case 'Website Form': ?>
                            <li>
                                <div>
                                    <i class="fa-solid fa-file-alt fa-lg"></i>
                                    <span>Registered Via: </span>
                                </div>
                                <div>
                                    <span>Website Form</span>
                                </div>
                            </li>
                        <?php break;
                        default:
                            echo 'Unknown registration option';

                    }
                }

                ?>
            </ul>

        </article>

        <?php

            //Checking if user visiting own profile or other user's profile
            if((isset($_GET['userID']) && $_GET['userID'] == $_SESSION['userID']) || !isset($_GET['userID']))
            {
                ?>
                    <article class="profile-actions-box">

                        <h2>Actions</h2>

                        <ul>
                            <li>
                                <button style="background-color: #32de84;" onclick="Display(0)">Change profile picture</button>
                            </li>
                            <?php

                                //Enabling to access admin panel if user is administrator
                                if($admin == 1)
                                {
                                    ?>
                                        <li>
                                            <a href="../admin_dashboard/users.php"><button style="background-color: #7e5be7;">Admin dashboard</button></a>
                                        </li>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                        <li>
                                            <button style="background-color: #7e5be7;" onclick="Display(1)">Change nickname</button>
                                        </li>
                                    <?php
                                }
                            ?>
                            
                            <li>
                                <a href="../passwordChange/"><button style="background-color: #FFBF00;">Change password</button></a>
                            </li>
                            <li>
                                <button style="background-color: #C70039;" onclick="Display(2)">Delete profile</button>
                            </li>
                        </ul>

                    </article>
                <?php
            }
        ?>

    </section>

    <section class="user-data-select">
        <div>
            <button id="ReviewButton">
                Reviews 
                <i class="fa-regular fa-user-magnifying-glass"></i>
            </button>
            <button id="FavoriteButton">
                Favorite products
                <i class="fa-regular fa-heart"></i>
            </button>
        </div>
        <div>
            <span id="DotPointer"></span>
            <span id="DotPointer"></span>
            <span id="DotPointer" class="purple"></span>
        </div>
    </section>

    <section class="user-review-section">
        <h2><?php echo $nickname ?>'s Recent Reviews</h2>

        <?php
            //Fetching reviews posted by provided user
            $stmt = $conn -> prepare("SELECT * FROM product_review JOIN user USING(user_id) JOIN product USING(product_id) WHERE user_id = :userID");
            $stmt->bindParam(":userID", $userID, PDO::PARAM_INT);
            $stmt->execute();
            $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach($reviews as $review)
            {
                ?>
                    <div class="review-box">
                        <a class="review-profile-picture">
                            <img src="<?php echo $review['profile_picture'] ?>" alt="ProfilePicture">
                            <p><?php echo $review['nickname'] ?></p>
                        </a>
                        <div class="review-data">
                            <h2 class="product-title">
                                <?php echo $review['name'] ?>
                            </h2>
                            <p class="review-content">
                                <?php echo $review['review_content'] ?>
                            </p>
                        </div>
                        
                        <div class="review-rate-date" id="ReviewData">
                            <span>
                                <?php
                                    //RATINGS HANDLING

                                    //Drawing stars
                                    $stars = $review['rating'];
                                    for($i = $stars; $i > 0; $i--)
                                    {
                                        ?>
                                            <i class="fa-solid fa-star" style="color: #ffd700;"></i>                
                                        <?php
                                    }

                                    //Drawing gray(empty) stars
                                    $emptyStars = 5-$review['rating'];
                                    for($i = $emptyStars; $i > 0; $i--)
                                    {
                                        ?>
                                            <i class="fa-solid fa-star" style="color: #808080;"></i>                
                                        <?php
                                    }
                                ?>
                            </span>  
                            <p class="text-gray-700"><?php echo $review['date_added'] ?></p>
                        </div>
                    </div>
                <?php
            }

            if(!$reviews)
            {
                ?>
                    <div style="width:100%; height:125px; text-align:center;">
                        <span style="color:gray; font-size:24px;">No reviews yet.</span>
                    </div>
                <?php
            }
        ?>
    </section>

    <section class="user-favourite-products">
        <h2><?php echo $nickname ?>'s Favourite products</h2>

        <?php

            //Fetching for user's favourite products
            $stmt = $conn->prepare("SELECT * FROM favourite_product JOIN product USING(product_id) WHERE user_id = :userID");
            $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
            $stmt->execute();
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach($products as $product)
            {
                ?>
        <section class="product-bar">

            <?php

                //Fetching for products photo
                $stmt = $conn->prepare("SELECT * FROM product_photos WHERE product_id = :productID AND main = 1");
                $stmt->bindParam(':productID', $product['product_id'], PDO::PARAM_INT);
                $stmt->execute();
                $photo = $stmt->fetchAll(PDO::FETCH_ASSOC);

            ?>

            <div class="product-section">

                <div class="product-photo">
                    <a href="../productPage/?productID=<?php echo $product['product_id'] ?>">
                        <img src="<?php echo $photo[0]['path'] ?>" alt="ProductPhoto">
                    </a>
                </div>

                <div class="product-details">
                    <div class="product-title">
                        <a href="../productPage/?productID=<?php echo $product['product_id'] ?>"><?php echo $product['name'] ?></a>
                    </div>
                    <div class="product-data">
                        <p><?php echo $product['quantity_sold'] ?> sold items || <?php echo $product['quantity_available'] ?> available items</p>
                        <p>Lowest price from last 30 days: <?php echo str_replace(".", ",", strval($product['lowest_price_30d'])) ?> $</p>
                        <span>
                            <?php echo $product['description'] ?>
                        </span>
                        <h4>
                            <?php echo str_replace(".", ",", strval($product['price'])) ?> $
                        </h4>
                        <div>
                            <p>Average user rating: </p>
                            <span class="product-rating">
                                <?php
                                    //RATINGS HANDLING

                                    //Drawing stars
                                    $stars = $product['average_rating'];
                                    for($i = $stars; $i > 0; $i--)
                                    {
                                        ?>
                                            <i class="fa-solid fa-star" style="color: #ffd700;"></i>                
                                        <?php
                                    }

                                    //Drawing gray(empty) stars
                                    $emptyStars = 5-$product['average_rating'];
                                    for($i = $emptyStars; $i > 0; $i--)
                                    {
                                        ?>
                                            <i class="fa-solid fa-star" style="color: #808080;"></i>                
                                        <?php
                                    }
                                ?>                                                          
                            </span>
                        </div>
                    </div>
                </div>

                <div class="product-categories">
                        <div class="category-title">
                            Categories
                        </div>

                        <?php
                            //Fetching product categories
                            $stmt = $conn->prepare("SELECT DISTINCT c.name, c.icon, c.category_id FROM product_categories JOIN subcategory USING(subcategory_id) JOIN category c USING(category_id) WHERE product_id = :productID");
                            $stmt->bindParam(':productID', $product['product_id'], PDO::PARAM_INT);
                            $stmt->execute();
                            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            foreach($categories as $category)
                            {
                                ?>
                                    <div class="category-box" onclick="Reveal(this)" id="Category">
                                        <div class="category-box-header">
                                            <div class="header-title">
                                                <?php echo $category['icon'] ?>
                                                <span><?php echo $category['name'] ?></span>
                                            </div> 
                                            <div class="arrow"></div>
                                        </div>
                                        <ul class="product-subcategories">
                                            <?php
                                                //Fetching product subcategories
                                                $stmt = $conn->prepare("SELECT s.name, s.subcategory_id FROM product_categories JOIN subcategory s USING(subcategory_id) JOIN category USING(category_id) WHERE product_id = :productID AND category_id = :categoryID");
                                                $stmt->bindParam(':productID', $product['product_id'], PDO::PARAM_INT);
                                                $stmt->bindParam(':categoryID', $category['category_id'], PDO::PARAM_INT);
                                                $stmt->execute();
                                                $subcategories = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                            
                                                foreach($subcategories as $subcategory)
                                                {
                                                    ?>
                                                        <li>
                                                            <?php echo $subcategory['name'] ?>
                                                        </li>
                                                    <?php
                                                }
                                            ?>
                                        </ul>
                                    </div>
                                <?php
                            }
                        ?>
                </div>
            </div>
            <?php
                if ((isset($_GET['userID']) && $_GET['userID'] == $_SESSION['userID']) || !isset($_GET['userID']))
                {
                    ?>
                        <div class="product-actions">
                            <a href="../components/PROFILE/profileFavoriteProductsModification.php?productID=<?php echo $product['product_id'] ?>&mode=delete&site=user">
                                Delete from Favorites
                            </a>
                        </div>
                    <?php
                }
            ?>
        </section>
        <?php
            }

            if(!$products)
            {
                ?>
                <div style="width:100%; height:125px; text-align:center;">
                    <span style="color:gray; font-size:24px;">User hasn't got any favourite products yet.</span>
                </div>
                <?php
            }
        ?>
    </section>

    <?php
        }
        catch(PDOException $e) 
        {
            ?>
                <script>window.location.replace("../errors/uncaught.php?errorCode=<?php echo $e->getMessage(); ?>");</script>
            <?php
        }
        //Importing footer
        include("../components/footer.php");
    ?>

</body>

<!--Internal Scripts Import-->
<script src="./script.js"></script>

</html>
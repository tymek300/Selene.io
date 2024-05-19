<!DOCTYPE html>
<html lang="en">

<head>
    <?php
        //Importing header tags
        include("../components/headerparams.php");
        
        //TryCatch Block
        try
        {
            //Checking if product is selected
            if(!isset($_GET['productID']))
            {
                FailureMessage("You have to select product to see its details.", "../main/");
                echo '<title>Not selected product</title>';
                die;
            }

            //Fetching information about product with provided ID
            $stmt = $conn -> prepare("SELECT * FROM product JOIN product_photos USING(product_id) WHERE product_id = :productID");
            $stmt->bindParam(":productID", $_GET['productID'], PDO::PARAM_INT);
            $stmt->execute();
            $product = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <title><?php echo $product[0]['name']?></title>
</head>

<body>

    <?php
        // Importing header
        include('../components/headernav.php');
    ?>

    <section class="product-details-section">

        <div class="product-photos-box">
            <?php
                //Checking if product is favourite product of user
                $stmt = $conn -> prepare("SELECT * FROM favourite_product WHERE product_id = :productID AND user_id = :userID");
                $stmt->bindParam(":productID", $_GET['productID'], PDO::PARAM_INT);
                $stmt->bindParam(":userID", $_SESSION['userID'], PDO::PARAM_INT);
                $stmt->execute();
                $favouriteProduct = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if(!$favouriteProduct)
                {
                    ?>
                        <a href="../components/PROFILE/profileFavoriteProductsModification.php?productID=<?php echo $product[0]['product_id']?>&mode=add" class="favourite-icon-box">
                            <i class="fa-solid fa-heart"></i>
                            <span>Add to Favorites</span>
                        </a>
                    <?php
                }
                else
                {
                    ?>
                        <a href="../components/PROFILE/profileFavoriteProductsModification.php?productID=<?php echo $product[0]['product_id']?>&mode=delete" class="favourite-icon-box active">
                            <i class="fa-solid fa-heart"></i>
                            <span>Favourite product</span>
                        </a>
                    <?php
                }
            ?>
            <button onclick="Slideshow(-1)" id="SlideButton">
                <div class="arrow" style="rotate: 90deg;"></div>
            </button>

            <button onclick="Slideshow(1)" id="SlideButton">
                <div class="arrow" style="rotate: 270deg;"></div>
            </button>

            <div class="photo-number">
                <?php
                    //Getting number of product photos
                    $photosQuantity = count($product);

                    //Displaying photos selection indicators
                    for($i = $photosQuantity; $i > 0; $i--)
                    {
                        ?>
                            <span id="PhotoBox"></span>
                        <?php
                    }
                ?>
            </div>

            <?php
                //Displaying photos 
                for($i = $photosQuantity; $i > 0; $i--)
                {
                    ?>
                        <img src="<?php echo $product[$i-1]['path'] ?>" id="ProductPhoto" alt="ProductPhoto">
                    <?php
                }
                ?>
        </div>

        <div class="product-details-box">
            <h2 class="product-name"><?php echo $product[0]['name'] ?></h2>

            <hr>

            <div>
                <p class="price-holder">Price: <?php echo str_replace(".", ",", strval($product[0]['price']))?>$</p>
                <p class="lowest-price-holder">The lowest offer price from 30 days: <?php echo str_replace(".", ",", strval($product[0]['lowest_price_30d']))?>$</p>
            </div>

            <hr>

            <form class="quantity-form" action="../components/CART/AddProductCART.php" method="GET">
                <div class="quantity-box">
                    <button type="button" id="QuantityPlusPP">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                    <input type="text" name="productID" value="<?php echo $_GET['productID'] ?>" hidden required>
                    <input type="text" id="QuantityInputPP" name="quantity" value="1" readonly required>
                    <input type="text" id="QuantityAvailablePP" value="<?php echo $product[0]['quantity_available'] ?>" hidden required> 
                    <button type="button" id="QuantityMinusPP">
                        <i class="fa-solid fa-minus"></i>
                    </button>
                </div>
                <span>
                    Of <?php echo $product[0]['quantity_available'] ?> available
                </span>
                <button type="submit" class="cart-button">
                    <i class="fa-regular fa-cart-shopping fa-lg" style="color: #ffffff;"></i>
                </button>
                <label class="quantity-errorPP">
                    <b>Error: </b> Wrong quantity. Please select correct quantity
                </label>
            </form>

            <hr>

            <p><?php echo $product[0]['quantity_sold'] ?> people have already bought this item</p>

            <hr>

            <div class="avg-rating-box">
                <p>Average user rating: </p>
                <span class="product-rating">
                    <?php
                        //RATINGS HANDLING

                        //Drawing stars
                        $stars = $product[0]['average_rating'];
                        for($i = $stars; $i > 0; $i--)
                        {
                            ?>
                                <i class="fa-solid fa-star" style="color: #ffd700;"></i>                
                            <?php
                        }

                        //Drawing gray(empty) stars
                        $emptyStars = 5-$product[0]['average_rating'];
                        for($i = $emptyStars; $i > 0; $i--)
                        {
                            ?>
                                <i class="fa-solid fa-star" style="color: #808080;"></i>                
                            <?php
                        }
                    ?>                                                          
                </span>
            </div>

            <hr>

            <div class="product-action-icons">
                <a class="buy-now-button" href="../components/CART/AddProductCART.php?quantity=1&productID=<?php echo $_GET['productID'] ?>">
                    Buy now
                </a>
            </div>

        </div>
    </section>

    <section class="description-section">
        <h2>Description</h2>

        <div class="description">
            <?php echo $product[0]["description"] ?>
        </div>
    </section>

    <section class="user-review-section">
        <h2><?php echo $product[0]['name'] ?>'s Recent Reviews</h2>

        <?php
            //Fetching reviews of product with provided ID
            $stmt = $conn -> prepare("SELECT * FROM product_review JOIN user USING(user_id) WHERE product_id = :productID");
            $stmt->bindParam(":productID", $_GET['productID'], PDO::PARAM_INT);
            $stmt->execute();
            $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach($reviews as $review)
            {
                ?>
                    <div class="review-box">
                        <a href="../userProfile/index.php?userID=<?php echo $review['user_id'] ?>" class="review-profile-picture">
                            <img src="<?php echo $review['profile_picture'] ?>" alt="ProfilePicture">
                            <p><?php echo $review['nickname'] ?></p>
                        </a>
                        <p class="review-content">
                            <?php echo $review['review_content'] ?>
                        </p>
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
                <div style="width:100%; height:75px; text-align:center;">
                    <span style="color:gray; font-size:24px;">No reviews yet.</span>
                </div>
                <?php
            }
        ?>
    </section>

    <section class="review-form-section">
        <form action="../components/PROFILE/profileAddProductReview.php" method="post" class="review-form">
            <h2>Product Review Form</h2>

            <input type="text" name="productID" value="<?php echo $product[0]['product_id'] ?>" hidden>

            <div class="form-input-box">
                <label for="reviewContent">Your opinion about <b><?php echo $product[0]['name'] ?></b>:</label>
                <textarea name="reviewContent" required></textarea>
            </div>

            <div class="form-input-box">
                <label for="review-content">Your rating: </label>

                <span class="star-rating">
                    <label for="rate-1" style="--i:1">
                        <i class="fa-solid fa-star"></i>
                    </label>
                    <input type="radio" name="rating" id="rate-1" value="1" required>
                    <label for="rate-2" style="--i:2">
                        <i class="fa-solid fa-star"></i>
                    </label>
                    <input type="radio" name="rating" id="rate-2" value="2" checked required>
                    <label for="rate-3" style="--i:3">
                        <i class="fa-solid fa-star"></i>
                    </label>
                    <input type="radio" name="rating" id="rate-3" value="3" required>
                    <label for="rate-4" style="--i:4">
                        <i class="fa-solid fa-star"></i>
                    </label>
                    <input type="radio" name="rating" id="rate-4" value="4" required>
                    <label for="rate-5" style="--i:5">
                        <i class="fa-solid fa-star"></i>
                    </label>
                    <input type="radio" name="rating" id="rate-5" value="5" required>
                </span>
            </div>

            <div class="form-input-box">
                <button>
                    Submit
                </button>
            </div>
        </form>
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

</html>
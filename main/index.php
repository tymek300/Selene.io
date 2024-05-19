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

    <section class="slide-section">
        <div class="slide-box">
            <button onclick="Slideshow(-1)" id="SlideButton">
                <div class="arrow" style="rotate: 90deg;">

                </div>
            </button>
            <button onclick="Slideshow(1)" id="SlideButton">
                <div class="arrow" style="rotate: 270deg;">

                </div>
            </button>
            <img src="../photos/baners/g2a-banner.jpg" id="slide" alt="Baner">
            <img src="../photos/baners/steam-banner.jpg" id="slide" alt="Baner">
            <img src="../photos/baners/epicgames-banner.jpg" id="slide" alt="Baner">
        </div>
    </section>

    <section class="filter-bar-section">

        <form class="filter-form" method="get">

            <div class="form-inputs">

                <div class="input-box">
                    <label for="productName">Product name: </label>
                    <input type="text" name="productName">
                </div>

                <div class="input-box">
                    <label for="categoryName">Quantity available: </label>
                    <input type="number" step="1" min="0" lang="en" placeholder="From" name="quantityAvailableFrom">
                    <input type="number" step="1" min="0" lang="en" placeholder="To" name="quantityAvailableTo">
                </div>

                <div class="input-box">
                    <label for="categoryName">Price: </label>
                    <input type="number" step="any" min="0" lang="en" placeholder="From" name="PriceFrom">
                    <input type="number" step="any" min="0" lang="en" placeholder="To" name="PriceTo">
                </div>

                <h2 class="warning">
                    'To' value cannot be bigger than 'From' value. Please correct values.
                </h2>
            </div>

            <div class="filter-actions">
                <button>
                    Filter Products
                </button>
            </div>

        </form>
    </section>

    <section class="product-section">

        <?php
            try 
            {
                //Fetching categories
                $stmt = $conn -> prepare("SELECT * FROM category");
                $stmt->execute();
                $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

                ?>
                <article class="categories">
                <?php

                //Displaying categories and subcategories
                foreach($categories as $category)
                {
                    ?>
                        <div class="category-box" onclick="Reveal(this)" id="Category">
                            <div class="category-box-header">
                                <div class="header-title">
                    <?php
                                    echo $category['icon'];
                    ?>
                                    <span><?php echo $category['name']; ?> </span>
                                </div> 
                                <div class="arrow"></div>
                            </div>
                            <ul class="subcategories">
                    <?php
                            //Fetching subcategories of certain category
                            $stmt = $conn -> prepare("SELECT * FROM subcategory WHERE category_id = :categoryID");
                            $stmt->bindParam(":categoryID", $category['category_id'], PDO::PARAM_INT);
                            $stmt->execute();
                            $subcategories = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            
                            foreach($subcategories as $subcategory)
                            {
                                ?>
                                    <a href="../main/?subcategoryID=<?php echo $subcategory['subcategory_id']; ?>"><li><?php echo $subcategory['name']; ?></li></a>
                                <?php
                            }
                    ?>
                            </ul>
                        </div>
                <?php
                }
                ?>
                </article>

                <article class="products-grid">
                <?php

                //Creating varabiable to hold possible conditions
                $condition = "";

                //If user marks desirable product name
                if(isset($_GET['productName']))
                {
                    if(!empty($_GET['productName']))
                    {
                        $condition .= " AND name LIKE '%{$_GET['productName']}%'";
                    }
                }

                //If user marks desirable minimun of quantity available
                if(isset($_GET['quantityAvailableFrom']))
                {
                    if(!empty($_GET['quantityAvailableFrom']))
                    {
                        $condition .= " AND quantity_available >= {$_GET['quantityAvailableFrom']}";
                    }
                }

                //If user marks desirable maximum of quantity available
                if(isset($_GET['quantityAvailableTo']))
                {
                    if(!empty($_GET['quantityAvailableTo']))
                    {
                        $condition .= " AND quantity_available <= {$_GET['quantityAvailableTo']}";
                    }
                }

                //If user marks desirable minimum price
                if(isset($_GET['PriceFrom']))
                {
                    if(!empty($_GET['PriceFrom']))
                    {
                        $condition .= " AND price >= {$_GET['PriceFrom']}";
                    }
                }

                //If user marks desirable maximum price
                if(isset($_GET['PriceTo']))
                {
                    if(!empty($_GET['PriceTo']))
                    {
                        $condition .= " AND price <= {$_GET['PriceTo']}";
                    }
                }

                if(isset($_GET['subcategoryID']))
                {
                    if (!empty($_GET['subcategoryID']))
                    {
                        $condition .= " AND product_id IN (SELECT product_id FROM product_categories WHERE subcategory_id = {$_GET['subcategoryID']})";
                    }
                }

                //Fetching for products with certain parameters
                $stmt = $conn->prepare("SELECT * FROM product WHERE quantity_available > 0 $condition");
                $stmt->execute();
                $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

                //Checking if any product with the provided parameters exists
                if(!$products && $condition != "")
                {
                    FailureMessage("There are no available products with the given parameters in our shop.", "index.php");
                }

                foreach($products as $product)
                {
                    //Fetching product main photo
                    $stmt = $conn -> prepare("SELECT path FROM product_photos WHERE main = 1 AND product_id = :productID");
                    $stmt->bindParam(":productID", $product['product_id'], PDO::PARAM_INT);
                    $stmt->execute();
                    $photo = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    //Checking if product is favourite product of user
                    $stmt = $conn -> prepare("SELECT * FROM favourite_product WHERE product_id = :productID AND user_id = :userID");
                    $stmt->bindParam(":productID", $product['product_id'], PDO::PARAM_INT);
                    $stmt->bindParam(":userID", $_SESSION['userID'], PDO::PARAM_INT);
                    $stmt->execute();
                    $favouriteProduct = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    ?>
                        <div class="product-box">
                            <img src="<?php echo $photo[0]['path'];?>" class="product-photo" alt="ProductPhoto">
                            
                            <div class="product-actions-box">
                                <a href="../components/CART/AddProductCART.php?productID=<?php echo $product['product_id'] ?>&quantity=1&" class="card-icon">
                                    <i class="fa-regular fa-cart-shopping fa-lg" style="color: #ffffff;"></i>
                                </a>
                                <?php
                                    if(!$favouriteProduct)
                                    {
                                        ?>
                                            <a class="details-button" href="../productPage/?productID=<?php echo $product['product_id']?>">
                                                Details
                                            </a>
                                            <a class="favourite-icon" href="../components/favoriteProductsModification.php?productID=<?php echo $product['product_id']?>&mode=add&site=main">
                                                <i class="fa-regular fa-heart fa-lg" style="color: #ffffff;"></i>
                                            </a>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                            <a class="details-button" href="../productPage/?productID=<?php echo $product['product_id']?>" style="width:75%">
                                                Details
                                            </a>
                                        <?php
                                    }

                                ?>
                            </div>
                        </div>
                    <?php
                    }

                    //Fetching unavailable products if user didn't choose category
                    if(!isset($_GET['subcategoryID']))
                    {
                        $stmt = $conn -> prepare("SELECT * FROM product WHERE quantity_available = 0 $condition");
                        $stmt->execute();
                        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        foreach($products as $product)
                        {
                            //Fetching product main photo
                            $stmt = $conn -> prepare("SELECT path FROM product_photos WHERE main = 1 AND product_id = :productID");
                            $stmt->bindParam(":productID", $product['product_id'], PDO::PARAM_INT);
                            $stmt->execute();
                            $photo = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            ?>
                                <div class="product-box">
                                    <img src="<?php echo $photo[0]['path'];?>" class="product-photo unavailable" alt="ProductPhoto">
                                    <div class="product-actions-box">
                                        <a class="card-icon" style="width:100%; background-color:red;">
                                            Product is unavailable
                                        </a>
                                    </div>
                                </div>
                            <?php
                        }
                    }
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

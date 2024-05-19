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

    <!-- PRODUCT DELETING -->
    <div class="body-overlay product-delete-form-box">
        <div class="dialog-box">

            <div class="icon">
                    <i class="fa-solid fa-seal-question" style="color: #8240d4;"></i>
            </div>

            <div class="message">
                Are you sure you want to delete this product?
                <br>
                <b>Warning: </b> This may affect some client orders.
            </div>

            <form action="../components/ADMIN/Products/productDeleteADMIN.php" method="post" class="productDeleteForm">
                <input type="text" class="formTextInput" name="hiddenName" hidden required>

                <div>
                    <button class="close-btn" style="background-color: #E32636">Submit</button> &nbsp;
                    <button class="close-btn" type="button" style="background-color: #654ab8" onclick="closeDialog('products.php')">Close</button>
                </div>
            </form>
        </div>
    </div>

    <!-- PRODUCT MODYFYING -->
    <div class="body-overlay product-modify-form-box">
        <div class="dialog-box">

            <div class="icon">
                <i class="fa-solid fa-seal-question" style="color: #8240d4;"></i>
            </div>

            <div class="message">
                You can modify certain product below.
            </div>

            <form action="../components/ADMIN/Products/productAddModifyADMIN.php" method="post" class="productModifyForm">
                <legend>Product details: </legend>

                <input type="text" class="typeInput" name="type" value="modify" hidden required>

                <input type="text" class="idInput" name="productID" hidden required>
                <input type="text" class="formTextInput" name="hiddenName" hidden required>

                <label>
                    <span>Name: </span> 
                    <input type="text" class="formTextInput" name="productName" required>
                </label>

                <label>
                    <span class="warning name">Warning: Provided name includes one of forbidden characters: (', \, /, <, >, ", :, ?, |, *). Please product name.</span>
                </label>

                <label>
                    <span>Price: </span>
                    <input type="number" step="0.01" class="formTextInput" name="productPrice" required>
                </label>

                <label>
                    <span>Quantity available: </span>
                    <input type="number" step="1" class="formTextInput" name="productQAvailable" required>
                </label>

                <label>
                    <span>Quantity sold: </span>
                    <input type="number" step="1" class="formTextInput" name="productQSold" required>
                </label>

                <label>
                    <span>Description: </span>
                    <textarea class="formTextInput" name="productDescription" rows="15" required></textarea>
                </label>

                <label>
                    <span class="warning description">Warning: Provided decription includes one of forbidden characters: (', \). Please change description.</span>
                </label>

                <label>
                    <span>Rating: </span>
                    <input type="number" step="1" min="1" max="5" class="formTextInput" name="productRating" required>
                </label>

                <div>
                    <button class="close-btn form-block" style="background-color: #32de84">Submit</button> &nbsp;
                    <button class="close-btn" type="button" style="background-color: #654ab8" onclick="closeDialog('products.php')">Close</button>
                </div>
            </form>
        </div>
    </div>

    <!-- PRODUCT ADDING -->
    <div class="body-overlay product-add-form-box">
        <div class="dialog-box">

            <div class="icon">
                <i class="fa-solid fa-seal-question" style="color: #8240d4;"></i>
            </div>

            <div class="message">
                You can add product to database below.
            </div>

            <form action="../components/ADMIN/Products/productAddModifyADMIN.php" enctype="multipart/form-data" method="post" class="productAddForm">
                <legend>Product details: </legend>

                <input type="text" class="typeInput" name="type" value="add" hidden required>

                <label>
                    <span>Name: </span> 
                    <input type="text" class="formTextInput" name="productName" required>
                </label>

                <label>
                    <span class="warning name">Warning: Provided name includes one of forbidden characters: (', \, /, <, >, ", :, ?, |, *). Please product name.</span>
                </label>

                <label>
                    <span>Price: </span>
                    <input type="number" step="0.01" class="formTextInput" name="productPrice" required>
                </label>

                <label>
                    <span>Quantity available: </span>
                    <input type="number" step="1" class="formTextInput" name="productQAvailable" required>
                </label>

                <label>
                    <span>Quantity sold: </span>
                    <input type="number" step="1" class="formTextInput" name="productQSold" required>
                </label>

                <label>
                    <span>Photos: </span>
                    <input type="file" name="productPhotos[]" multiple accept=".jpg,.png,.jpeg" required>
                </label>

                <label>
                    <span>Category: </span>
                    <select name="subcategoryID"> 
                        <?php

                        //Fetching for categories
                        $stmt = $conn->prepare("SELECT * FROM category");
                        $stmt->execute();
                        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        foreach($categories as $category)
                        {
                            ?>
                            
                                <optgroup label="<?php echo $category['name'] ?>">
                                <?php
                                    //Fetching for subcategories of certain category
                                    $stmt = $conn->prepare("SELECT * FROM subcategory WHERE category_id = {$category['category_id']}");
                                    $stmt->execute();
                                    $subcategories = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                    foreach($subcategories as $subcategory)
                                    {
                                        ?>
                                            <option value="<?php echo $subcategory['subcategory_id'] ?>"><?php echo $subcategory['name'] ?></option>
                                        <?php
                                    }
                                ?>
                                </optgroup>
                            <?php
                        }
                        
                        ?>
                        
                    </select>
                </label>

                <label>
                    <span>Description: </span>
                    <textarea class="formTextInput" name="productDescription" rows="15" required></textarea>
                </label>

                <label>
                    <span class="warning description">Warning: Provided decription includes one of forbidden characters: (', \). Please change description.</span>
                </label>

                <label>
                    <span>Rating: </span>
                    <input type="number" step="1" min="1" max="5" class="formTextInput" name="productRating" required>
                </label>

                <div>
                    <button class="close-btn form-block" style="background-color: #32de84">Submit</button> &nbsp;
                    <button class="close-btn" type="button" style="background-color: #654ab8" onclick="closeDialog('products.php')">Close</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ADDING PRODUCT TO CATEGORY -->
    <div class="body-overlay product-category-form-box">
        <div class="dialog-box">

            <div class="icon">
                    <i class="fa-solid fa-seal-question" style="color: #8240d4;"></i>
            </div>

            <div class="message">
                You can add product to certain category below.
            </div>

            <form action="../components/ADMIN/Products/productCategoryAddDeleteADMIN.php" method="post" class="productCategoryForm">
                        
                <input type="text" class="typeInput" name="type" value="add" hidden required>
                <input type="text" class="idInput" name="productID" hidden required>

                <label>
                    <span>Category: </span>
                    <select name="subcategoryID"> 
                        <?php

                        //Fetching for categories
                        $stmt = $conn->prepare("SELECT * FROM category");
                        $stmt->execute();
                        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        foreach($categories as $category)
                        {
                            ?>
                            
                                <optgroup label="<?php echo $category['name'] ?>">
                                <?php
                                    //Fetching for subcategories of certain category
                                    $stmt = $conn->prepare("SELECT * FROM subcategory WHERE category_id = {$category['category_id']}");
                                    $stmt->execute();
                                    $subcategories = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                    foreach($subcategories as $subcategory)
                                    {
                                        ?>
                                            <option value="<?php echo $subcategory['subcategory_id'] ?>"><?php echo $subcategory['name'] ?></option>
                                        <?php
                                    }
                                ?>
                                </optgroup>
                            <?php
                        }
                        
                        ?>
                        
                    </select>
                </label>

                <div>
                    <button class="close-btn" style="background-color: #32de84">Submit</button> &nbsp;
                    <button class="close-btn" type="button" style="background-color: #654ab8" onclick="closeDialog('products.php')">Close</button>
                </div>
            </form>
        </div>
    </div>

    <!-- DELETING PRODUCT FROM CATEGORY -->
    <div class="body-overlay product-category-delete-form-box">
        <div class="dialog-box">

            <div class="icon">
                    <i class="fa-solid fa-seal-question" style="color: #8240d4;"></i>
            </div>

            <div class="message">
                Are you sure you want to remove this category from product?
            </div>

            <form action="../components/ADMIN/Products/productCategoryAddDeleteADMIN.php" method="post" class="productCategoryDeleteForm">
                
                <input type="text" class="typeInput" name="type" value="delete" hidden required>
                <input type="text" class="idInput" name="productID" hidden required>
                <input type="text" class="idInput" name="subcategoryID" hidden required>

                <div>
                    <button class="close-btn" style="background-color: #E32636">Submit</button> &nbsp;
                    <button class="close-btn" type="button" style="background-color: #654ab8" onclick="closeDialog('products.php')">Close</button>
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

        <div class="filter-bar">

            <form class="filter-form" method="get">

                <div class="form-inputs">

                    <div class="input-box">
                        <label for="productName">Product name: </label>
                        <input type="text" name="productName">
                    </div>

                    <div class="input-box">
                    <label for="productCategory">Category: </label>
                        <select name="productCategory"> 
                            <?php

                            //Fetching for categories
                            $stmt = $conn->prepare("SELECT * FROM category");
                            $stmt->execute();
                            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            foreach($categories as $category)
                            {
                                ?>
                                
                                    <optgroup label="<?php echo $category['name'] ?>">
                                    <?php
                                        //Fetching for subcategories of certain category
                                        $stmt = $conn->prepare("SELECT * FROM subcategory WHERE category_id = {$category['category_id']}");
                                        $stmt->execute();
                                        $subcategories = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                        foreach($subcategories as $subcategory)
                                        {
                                            ?>
                                                <option value="<?php echo $subcategory['subcategory_id'] ?>"><?php echo $subcategory['name'] ?></option>
                                            <?php
                                        }
                                    ?>
                                    </optgroup>
                                <?php
                            }
                            
                            ?>
                            
                        </select>
                    </div>

                    <div class="input-box">
                        <label for="categoryName">Quantity available: </label>
                        <input type="number" step="1" min="0" lang="en" placeholder="From" name="quantityAvailableFrom"> 
                        <input type="number" step="1" min="0" lang="en" placeholder="To" name="quantityAvailableTo">
                    </div>

                    <div class="input-box">
                        <label for="categoryName">Quantity sold: </label>
                        <input type="number" step="1" min="0" lang="en" placeholder="From" name="quantitySoldFrom"> 
                        <input type="number" step="1" min="0" lang="en" placeholder="To" name="quantitySoldTo">
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
                    
                    <a onclick="AddProduct()" style="background-color: #32de84"> 
                        Add new product
                    </a>
                </div>
                
            </form>
        </div>

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

            //If user marks desirable category of product
            if(isset($_GET['productCategory']))
            {
                if(!empty($_GET['productCategory'])) 
                {
                    $condition .= " AND product_id IN (SELECT product_id FROM product_categories WHERE subcategory_id = {$_GET['productCategory']})";
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

            //If user marks desirable minimum of quantity sold
            if(isset($_GET['quantitySoldFrom']))
            {
                if(!empty($_GET['quantitySoldFrom'])) 
                {
                    $condition .= " AND quantity_sold >= {$_GET['quantitySoldFrom']}";
                }
            }

            //If user marks desirable maximum of quantity sold
            if(isset($_GET['quantitySoldTo']))
            {
                if(!empty($_GET['quantitySoldTo'])) 
                {
                    $condition .= " AND quantity_sold <= {$_GET['quantitySoldTo']}";
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

            //Fetching for products with certain parameters
            $stmt = $conn->prepare("SELECT * FROM product WHERE 1 $condition");
            $stmt->execute();
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);


            foreach($products as $product)
            {
                ?>
                <section class="product-bar">

                    <div class="product-section">

                        <div class="product-photo">
                            <?php
                                $stmt = $conn->prepare("SELECT * FROM product_photos WHERE product_id = :productID AND main = 1");
                                $stmt->bindParam(':productID', $product['product_id'], PDO::PARAM_INT);
                                $stmt->execute();
                                $photo = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            ?>
                            <img src="<?php echo $photo[0]['path'] ?>">
                        </div>

                        <div class="product-details">
                            <div class="product-title">
                                <p><?php echo $product['name'] ?></p>
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
                                                                    <a onclick="ProductCategoryDelete(<?php echo $product['product_id'].', '.$subcategory['subcategory_id'] ?>)">Delete subcategory</a>
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
                    
                    <div class="product-actions">
                        <a onclick="ModifyProduct(<?php echo $product['product_id'] ?>, '<?php echo $product['name'] ?>', <?php echo $product['price'] ?>, '<?php echo htmlspecialchars($product['description']) ?>', <?php echo $product['quantity_available'] ?>, <?php echo $product['quantity_sold'] ?>, <?php echo $product['average_rating'] ?>)" style="background-color: #318CE7">
                            Modify product
                        </a>
                        <a href="product_photos.php?productID=<?php echo $product['product_id'] ?>" style="background-color: #FFAC1C">
                            Show product photos
                        </a>
                        <a onclick="ProductCategory(<?php echo $product['product_id'] ?>, this)" 
                        data-array=
                        "[<?php
                            //Fetching product subcategories
                            $stmt = $conn->prepare("SELECT s.subcategory_id FROM product_categories JOIN subcategory s USING(subcategory_id) JOIN category USING(category_id) WHERE product_id = :productID");
                            $stmt->bindParam(':productID', $product['product_id'], PDO::PARAM_INT);
                            $stmt->execute();
                            $subcategories = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            //Setting product subcategories ID
                            foreach($subcategories as $subcategory)
                            {
                                if($subcategory != end($subcategories))
                                {
                                    echo $subcategory['subcategory_id'].", ";
                                }
                                else
                                {
                                    echo $subcategory['subcategory_id'];
                                }
                            }
                        ?>]">
                            Add product to category
                        </a>
                        <a onclick="DeleteProduct(<?php echo '\''. $product['name']. '\'' ?>)" style="background-color: #fd5c63;">
                            Delete product
                        </a>
                    </div>
                </section>
                <?php
            }
            
        ?>

    </section>

    <!--Internal Scripts Import-->
    <script src="./script.js"></script>
</body>
</html>
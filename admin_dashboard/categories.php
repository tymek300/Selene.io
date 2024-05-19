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

        <!-- CATEGORY/SUBCATEGORY NAME CHANGE -->
        <div class="body-overlay category-subcategory-name-form-box">
            <div class="dialog-box">

                <div class="icon">
                        <i class="fa-solid fa-seal-question" style="color: #8240d4;"></i>
                </div>

                <div class="message">
                    You can change category/subcategory name below.
                </div>

                <form action="../components/ADMIN/CategoriesSubcategories/categorySubcategoryNameChangeADMIN.php" method="post" class="categorySubcategoryNameForm">
                    <legend>Set new name:</legend>

                    <input type="text" class="idInput" name="ID" required hidden>

                    <input type="text" class="typeInput" name="type" required hidden>

                    <label>
                        <span>Name: </span>
                        <input type="text" class="formTextInput" name="newName" required>
                    </label>
                    
                    <div>
                        <button class="close-btn" style="background-color: #32de84">Submit</button> &nbsp;
                        <button class="close-btn" type="button" style="background-color: #654ab8" onclick="closeDialog('categories.php')">Close</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- CATEGORY/SUBCATEGORY DELETE -->
        <div class="body-overlay category-subcategory-delete-form-box">
            <div class="dialog-box">

                <div class="icon">
                        <i class="fa-solid fa-seal-question" style="color: #8240d4;"></i>
                </div>

                <div class="message">
                    Are you sure you want to delete this category/subcategory?
                    <br>
                    <b>Warning: </b> This may affect products in database.
                </div>

                <form action="../components/ADMIN/CategoriesSubcategories/categorySubcategoryDeleteADMIN.php" method="post" class="categorySubcategoryDeleteForm">
                    <input type="text" class="idInput" name="ID" required hidden>

                    <input type="text" class="typeInput" name="type" required hidden>

                    <div>
                        <button class="close-btn" style="background-color: #E32636">Submit</button> &nbsp;
                        <button class="close-btn" type="button" style="background-color: #654ab8" onclick="closeDialog('categories.php')">Close</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- CATEGORY ICON CHANGE -->
        <div class="body-overlay category-icon-change-form-box">
            <div class="dialog-box">

                <div class="icon">
                    <i class="fa-solid fa-seal-question" style="color: #8240d4;"></i>
                </div>

                <div class="message">
                    You can change category icon below.
                    <br>
                    <b>Notice: </b> Icon has to be HTML tag for example: <pre>&lt;i&gt;</pre> <pre>&lt;svg&gt;</pre>
                </div>

                <form action="../components/ADMIN/CategoriesSubcategories/categoryIconChangeADMIN.php" method="post" class="categoryIconChangeForm">
                    <legend>Set new icon:</legend>

                    <input type="text" class="idInput" name="categoryID" required hidden>

                    <label>
                        <input type="text" class="formTextInput" name="newIcon" placeholder="For example: <i></i>" required>
                    </label>
                    <span class="warning">Warning: Provided icon is incorrect</span>
                    <div>
                        <button class="close-btn" style="background-color: #32de84">Submit</button> &nbsp;
                        <button class="close-btn" type="button" style="background-color: #654ab8" onclick="closeDialog('categories.php')">Close</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- SUBCATEGORY ADDING -->
        <div class="body-overlay subcategory-add-form-box">
            <div class="dialog-box">

                <div class="icon">
                    <i class="fa-solid fa-seal-question" style="color: #8240d4;"></i>
                </div>

                <div class="message">
                    You can add subcategory to category below.
                </div>

                <form action="../components/ADMIN/CategoriesSubcategories/subcategoryAddADMIN.php" method="post" class="subcategoryAddForm">
                    <legend>Subcategory details: </legend>

                    <input type="text" class="idInput" name="categoryID" required hidden>

                    <label>
                        <span>Subcategory for: </span>
                        <input type="text" class="formTextInput" name="categoryName" style="width:50%" required readonly>
                    </label>

                    <label>
                        <span>Name: </span> 
                        <input type="text" class="formTextInput" name="newSubcategory" style="width:50%" required>
                    </label>

                    <div>
                        <button class="close-btn" style="background-color: #32de84">Submit</button> &nbsp;
                        <button class="close-btn" type="button" style="background-color: #654ab8" onclick="closeDialog('categories.php')">Close</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- CATEGORY ADDING -->
        <div class="body-overlay category-add-form-box">
            <div class="dialog-box">

                <div class="icon">
                    <i class="fa-solid fa-seal-question" style="color: #8240d4;"></i>
                </div>

                <div class="message">
                    You can add subcategory to category below.
                    <br>
                    <b>Notice: </b> Icon has to be HTML tag for example: <pre>&lt;i&gt;</pre> <pre>&lt;svg&gt;</pre>
                </div>

                <form action="../components/ADMIN/CategoriesSubcategories/categoryAddADMIN.php" method="post" class="categoryAddForm">
                    <legend>Category details: </legend>

                    <label>
                        <span>Name: </span>
                        <input type="text" class="formTextInput" name="categoryName" required>
                    </label>

                    <label>
                        <span>Icon: </span> 
                        <input type="text" class="formTextInput" name="newIcon" placeholder="For example: <i></i>" required>
                    </label>

                    <span class="warning">Warning: Provided icon is incorrect</span>

                    <div>
                        <button class="close-btn" style="background-color: #32de84">Submit</button> &nbsp;
                        <button class="close-btn" type="button" style="background-color: #654ab8" onclick="closeDialog('categories.php')">Close</button>
                    </div>
                </form>
            </div>
        </div>

        <?php
            //Importing baner
            include("../components/ADMIN/sideNavbarADMIN.php");
            RenderSideNavbar(3);
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
                            <label for="categoryName">Category name: </label>
                            <input type="text" name="categoryName">
                        </div>
                    </div>

                    <div class="filter-actions">
                        <button>
                            Filter Categories
                        </button>
                        <a onclick="AddCategory()" style="background-color: #32de84"> 
                            Add new category
                        </a>
                    </div>
                    
                </form>
            </div>

            <?php

                //Creating varabiable to hold possible conditions
                $condition = "";

                //If user marks desirable category name
                if(!empty($_GET['categoryName']))
                {
                    $condition .= "AND name LIKE '%{$_GET['categoryName']}%'";
                }

                //Fetching for categories with certain parameters
                $stmt = $conn->prepare("SELECT * FROM category WHERE 1 $condition");
                $stmt->execute();
                $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach($categories as $category)
                {
                    ?>
                        <section class="categories-bar">

                            <div class="category-section">
                                <div class="category-info">
                                    <?php echo $category['icon']; ?>
                                    <span><?php echo $category['name']; ?></span>
                                </div>
                                <div class="category-actions">
                                    <a onclick="ChangeCategoryName(<?php echo $category['category_id']. ', \''. $category['name']. '\''. ', \''. 'category'. '\'' ?>)" style="background-color: #318CE7">
                                        Change name
                                    </a>
                                    <a onclick="IconChange(<?php echo $category['category_id']. ', \''. htmlspecialchars($category['icon']). '\''; ?>)">
                                        Change icon
                                    </a>
                                    <a style="background-color: #FFAC1C">
                                        Show subcategories
                                    </a>
                                    <a onclick="AddSubcategory(<?php echo $category['category_id']. ', \''. $category['name']. '\'' ?>)" style="background-color: #32de84;">
                                        Add subcategory
                                    </a>
                                    <a onclick="DeleteCategory(<?php echo $category['category_id']. ', \''. 'category'. '\'' ?>)" style="background-color: #fd5c63;">
                                        Delete category
                                    </a>
                                </div>
                            </div>
                            <ul class="subcategories">

                            <?php

                            //Fetching for subcategories of current category
                            $stmt = $conn->prepare("SELECT * FROM subcategory WHERE category_id = :categoryID");
                            $stmt->bindParam(":categoryID", $category['category_id'], PDO::PARAM_INT);
                            $stmt->execute();
                            $subcategories = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            foreach($subcategories as $subcategory)
                            {
                                ?>
                                        <li>
                                            <div class="subcategory-info">
                                                <span><?php echo $subcategory['name']; ?></span>
                                            </div>
                                            <div class="subcategory-actions">
                                                <a onclick="ChangeCategoryName(<?php echo $subcategory['subcategory_id']. ', \''. $subcategory['name']. '\''. ', \''. 'subcategory'. '\'' ?>)" style="background-color: #318CE7">
                                                    Change name
                                                </a>
                                                <a onclick="DeleteCategory(<?php echo $subcategory['subcategory_id']. ', \''. 'subcategory'. '\'' ?>)" style="background-color: #fd5c63;">
                                                    Delete subcategory
                                                </a>
                                            </div>
                                        </li>
                                <?php
                            }
                    ?>
                        </ul>
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
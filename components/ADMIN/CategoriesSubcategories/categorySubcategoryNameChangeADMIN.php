<?php
    try
    {
        include('../../../components/databaseConn.php');

        //Checking what should be updated: category or subcategory
        if($_POST['type'] == 'category')
        {
            //Fetching for categories with provided name
            $stmt = $conn->prepare("SELECT * FROM category WHERE name = :newName");
            $stmt->bindParam(':newName', $_POST['newName']);
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            //Error if category with provided name already exists
            if($users)
            {
                header('Location: ../../../admin_dashboard/categories.php?failure=Category with provided name already exists.&link=categories.php');
                die;
            }

            //Otherwise updating category name
            $stmt = $conn->prepare("UPDATE category SET name = :newName WHERE category_id = :categoryID");
            $stmt->bindParam(':newName', $_POST['newName']);
            $stmt->bindParam(':categoryID', $_POST['ID'], PDO::PARAM_INT);
            $stmt->execute();

            header('Location: ../../../admin_dashboard/categories.php?success=Category name has been updated successfully!&link=categories.php');
        }
        else
        {
            //Updating subcategory name
            $stmt = $conn->prepare("UPDATE subcategory SET name = :newName WHERE subcategory_id = :subcategoryID");
            $stmt->bindParam(':newName', $_POST['newName']);
            $stmt->bindParam(':subcategoryID', $_POST['ID'], PDO::PARAM_INT);
            $stmt->execute();

            header('Location: ../../../admin_dashboard/categories.php?success=Subcategory name has been updated successfully!&link=categories.php');
        }
    }
    catch(PDOException $e) 
    {
        ?>
        <script>window.location.replace("../../../errors/uncaught.php?errorCode=<?php echo $e->getMessage(); ?>");</script>
        <?php
    }

?>
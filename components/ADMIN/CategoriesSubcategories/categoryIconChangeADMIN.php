<?php
    try
    {
        include('../../../components/databaseConn.php');

        //Fetching for categories with provided icon
        $stmt = $conn->prepare("SELECT * FROM category WHERE icon = :newIcon");
        $stmt->bindParam(':newIcon', $_POST['newIcon']);
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //Error if category with provided icon already exists
        if($users)
        {
            header('Location: ../../../admin_dashboard/categories.php?failure=Category with provided icon already exists.&link=categories.php');
            die();
        }

        //Otherwise updating category name
        $stmt = $conn->prepare("UPDATE category SET icon = :newIcon WHERE category_id = :categoryID");
        $stmt->bindParam(':newIcon', $_POST['newIcon']);
        $stmt->bindParam(':categoryID', $_POST['categoryID'], PDO::PARAM_INT);
        $stmt->execute();

        header('Location: ../../../admin_dashboard/categories.php?success=Category icon has been updated successfully!&link=categories.php');
    }
    catch(PDOException $e) 
    {
        ?>
        <script>window.location.replace("../../../errors/uncaught.php?errorCode=<?php echo $e->getMessage(); ?>");</script>
        <?php
    }

?>
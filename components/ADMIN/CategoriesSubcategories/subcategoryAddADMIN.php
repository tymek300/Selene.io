<?php
    try
    {
        include('../../../components/databaseConn.php');

        //Adding new subcategory of certain category to database
        $stmt = $conn->prepare("INSERT INTO subcategory (name, category_id) VALUES (:newSubcategory, :categoryID)");
        $stmt->bindParam(':newSubcategory', $_POST['newSubcategory']);
        $stmt->bindParam(':categoryID', $_POST['categoryID'], PDO::PARAM_INT);
        $stmt->execute();

        header('Location: ../../../admin_dashboard/categories.php?success=Subcategory for ' . $_POST['categoryName'] . ' category has been added successfully!&link=categories.php');

    }
    catch(PDOException $e) 
    {
        ?>
        <script>window.location.replace("../../../errors/uncaught.php?errorCode=<?php echo $e->getMessage(); ?>");</script>
        <?php
    }

?>
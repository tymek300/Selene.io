<?php
    try
    {
        include('../../../components/databaseConn.php');

        //Checking what should be deleted: category or subcategory
        if($_POST['type'] == 'category')
        {
            //Deleting certain category
            $stmt = $conn->prepare("DELETE FROM category WHERE category_id = :categoryID");
            $stmt->bindParam(':categoryID', $_POST['ID'], PDO::PARAM_INT);
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            header('Location: ../../../admin_dashboard/categories.php?success=Category has been deleted successfully!&link=categories.php');
        }
        else
        {
            //Deleting certain subcategory
            $stmt = $conn->prepare("DELETE FROM subcategory WHERE subcategory_id = :subcategoryID");
            $stmt->bindParam(':subcategoryID', $_POST['ID'], PDO::PARAM_INT);
            $stmt->execute();

            header('Location: ../../../admin_dashboard/categories.php?success=Subcategory has been deleted successfully!&link=categories.php');
        }
    }
    catch(PDOException $e) 
    {
        ?>
        <script>window.location.replace("../../../errors/uncaught.php?errorCode=<?php echo $e->getMessage(); ?>");</script>
        <?php
    }

?>
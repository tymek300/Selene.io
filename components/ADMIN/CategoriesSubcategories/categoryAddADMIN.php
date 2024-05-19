<?php
    try
    {
        include('../../../components/databaseConn.php');

        //Fetching for category with given name
        $stmt = $conn->prepare("SELECT * FROM category WHERE name = :name");
        $stmt->bindParam(':name', $_POST['categoryName']);
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //Error if category already existst
        if($users)
        {
            header('Location: ../../../admin_dashboard/categories.php?failure=Category with provided name already exists.&link=categories.php');
            die;
        }

         //Fetching for category with given icon
         $stmt = $conn->prepare("SELECT * FROM category WHERE icon = :icon");
         $stmt->bindParam(':icon', $_POST['newIcon']);
         $stmt->execute();
         $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
 
         //Error if category already existst
         if($users)
         {
            header('Location: ../../../admin_dashboard/categories.php?failure=Category with provided icon already exists.&link=categories.php');
            die;
         }

        //Adding category to database
        $stmt = $conn->prepare("INSERT INTO category (name, icon) VALUES (:categoryName, :newIcon)");
        $stmt->bindParam(':categoryName', $_POST['categoryName']);
        $stmt->bindParam(':newIcon', $_POST['newIcon']);
        $stmt->execute();

        header('Location: ../../../admin_dashboard/categories.php?success=Category ' . $_POST['categoryName'] . ' has been added successfully!&link=categories.php');

    }
    catch(PDOException $e) 
    {
        ?>
        <script>window.location.replace("../../../errors/uncaught.php?errorCode=<?php echo $e->getMessage(); ?>");</script>
        <?php
    }

?>
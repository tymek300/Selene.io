<?php
    try
    {
        include('../../../components/databaseConn.php');

        if($_POST['type'] == 'add')
        {
            //Transforming promo code to uppercase
            $_POST['newName'] = strtoupper($_POST['newName']);

            //Checking if promo code with provided name already exists
            $stmt = $conn->prepare("SELECT * FROM promo_code WHERE code = :newName");
            $stmt->bindParam(':newName', $_POST['newName']);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if($result)
            {
                header('Location: ../../../admin_dashboard/promoCodes.php?failure=Promo code with provided name already exists.&link=promoCodes.php');
                die();
            }

            //Inserting new promo code to database
            $stmt = $conn->prepare("INSERT INTO promo_code (code, discount) VALUES (:newName, :newDiscount)");
            $stmt->bindParam(':newName', $_POST['newName']);
            $stmt->bindParam(':newDiscount', $_POST['newDiscount']);
            $stmt->execute();

            header('Location: ../../../admin_dashboard/promoCodes.php?success=New promo code <b>'.$_POST['newName'].'</b> has been successfully added.&link=promoCodes.php');
            die();
        }
        elseif($_POST['type'] == 'delete')
        {
            //Deleting promo code with provided ID
            $stmt = $conn->prepare("DELETE FROM promo_code WHERE promo_code_id = :promoCodeID");
            $stmt->bindParam(':promoCodeID', $_POST['ID']);
            $stmt->execute();

            header('Location: ../../../admin_dashboard/promoCodes.php?success=Promo code has been successfully deleted.&link=promoCodes.php');
            die();
        }
        else
        {
            //Transforming promo code to uppercase
            $_POST['newName'] = strtoupper($_POST['newName']);
            $_POST['oldName'] = strtoupper($_POST['oldName']);

            if($_POST['newName'] != $_POST['oldName'])
            {
                //Checking if promo code with provided name already exists
                $stmt = $conn->prepare("SELECT * FROM promo_code WHERE code = :newName");
                $stmt->bindParam(':newName', $_POST['newName']);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if($result)
                {
                    header('Location: ../../../admin_dashboard/promoCodes.php?failure=Promo code with provided name already exists.&link=promoCodes.php');
                    die();
                }
            }

            //Updating promo code
            $stmt = $conn->prepare("UPDATE promo_code SET code = :newName, discount = :newDiscount WHERE promo_code_id = :promoCodeID");
            $stmt->bindParam(':newName', $_POST['newName']);
            $stmt->bindParam(':newDiscount', $_POST['newDiscount']);
            $stmt->bindParam(':promoCodeID', $_POST['ID']);
            $stmt->execute();

            header('Location: ../../../admin_dashboard/promoCodes.php?success=Promo code has been successfully modified.&link=promoCodes.php');
            die();

        }
    }
    catch(PDOException $e) 
    {
        ?>
        <script>window.location.replace("../../../errors/uncaught.php?errorCode=<?php echo $e->getMessage(); ?>");</script>
        <?php
    }

?>
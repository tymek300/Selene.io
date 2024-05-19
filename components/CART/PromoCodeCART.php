<?php
try
{
    include('../../components/databaseConn.php');

    //Transforming promo code to uppercase
    $_GET['promoCode'] = strtoupper($_GET['promoCode']);

    //Fetching provided promo code
    $stmt = $conn->prepare("SELECT * FROM promo_code WHERE code = :promoCode");
    $stmt->bindParam(':promoCode', $_GET['promoCode']);
    $stmt->execute();
    $code = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$code)
    {
        header('Location: ../../cart/index.php?failure=Promo code <b>'.$_GET['promoCode'].'</b> does not exists. Please check the correctness of provided code!&link=index.php');
        die();
    }

    //Applying promo code on user cart
    $stmt = $conn->prepare("UPDATE cart SET promo_code_id = :codeID WHERE user_id = :userID AND is_completed = 0");
    $stmt->bindParam(':codeID', $code['promo_code_id'], PDO::PARAM_INT);
    $stmt->bindParam(':userID', $_SESSION['userID'], PDO::PARAM_INT);
    $stmt->execute();

    header('Location: ../../cart/index.php?success=Promo code <b>'.$_GET['promoCode'].'</b> has been successfully applied on your cart!&link=index.php');
}
catch(PDOException $e)
{
    ?>
    <script>window.location.replace("../../errors/uncaught.php?errorCode=<?php echo $e->getMessage(); ?>");</script>
    <?php
}

?>
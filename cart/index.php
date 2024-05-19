<!DOCTYPE html>
<html lang="en">

<head>
    <?php
        //Importing header tags
        include("../components/headerparams.php");
    ?>

    <title><?php echo $_SESSION['nickname'] ?>'s Cart</title>
</head>

<body>

    <?php
        // Importing header
        include('../components/headernav.php');
    ?>

    <?php
    if(!count($cart_products))
    {
        FailureMessage("Your cart is currently empty.", "../main/");
        die();
    }
    else
    {
        //Calculating cart total (with taxes and discounts)
        $cartTotal = $cart_products[0]['cart_subtotal'];
        $cartTotal = $cartTotal * 1.13; // Digital tax
        if ($cart_products[0]['discount'] != null)
        {
            $cartTotal = $cartTotal - ($cartTotal * $cart_products[0]['discount']);
        }
        $cartTotal = number_format($cartTotal, 2, '.');
    }
    ?>

    <div class="promo-code-container">
        <div class="promo-code-form">
            <h2>Enter promo code below</h2>
            <form action="../components/CART/PromoCodeCART.php"  method="get">
                <input type="text" name="promoCode" value="<?php if ($cart_products[0]['code'] != null) echo($cart_products[0]['code']); else echo("")?>" required>
                <div class="promo-code-action-container">
                    <button class="submitPromoCode">Submit</button>
                    <button class="closePromoCode" style="background-color: #d32f3d" type="button">Close</button>
                </div>

            </form>
        </div>
    </div>

    <div class="cart-header">
        <span class="cart-title">
            <i class="fa-light fa-bag-shopping fa-lg"></i>
            My Cart
        </span>
    </div>

    <div class="main-content">
        <div class="cart-box">
            <div class="stages">
                <span id="DotPointer">
                    <p>Items in cart</p>
                </span>
                <span id="DotPointer">
                    <p>Customer information</p>
                </span>
                <span id="DotPointer" class="purple">

                </span>
            </div>

            <div class="products-container">

            <?php
                foreach ($cart_products as $key=>$cart_product)
                {
                    $stmt = $conn -> prepare("SELECT * FROM product_photos WHERE product_id = :productID AND main = 1");
                    $stmt->bindParam(":productID", $cart_product['product_id'] , PDO::PARAM_INT);
                    $stmt->execute();
                    $product_photo = $stmt->fetch(PDO::FETCH_ASSOC);
                    ?>

                    <div class="cart-container-product-box">
                        <div class="cart-product">
                            <div class="cart-product-photo">
                                <a class="cart-delete-button" href="../components/CART/DeleteProductCART.php?productID=<?php echo $cart_product['product_id'] ?>">
                                    <i class="fa-solid fa-x fa-2xs" style="color: white"></i>
                                </a>
                                <img src="<?php echo $product_photo['path'] ?>" alt="ProductPhoto">
                            </div>
                            <div class="cart-product-info">
                                <?php echo $cart_product['name'] ?>
                                <span><?php echo $cart_product['quantity_available'] ?> units of this product left in the store</span>
                            </div>
                        </div>
                        <div class="cart-quantity">
                            <form class="cart-quantity-form">
                                <button type="button" id="QuantityMinusCP" onclick="updateCartProductQuantity(<?php echo($_SESSION['userID'].', '.$cart_product['product_id'].', -1, '.$key)?>)">
                                    <i class="fa-solid fa-minus"></i>
                                </button>

                                <input type="text" id="QuantityInputCP" value="<?php echo $cart_product['quantity']?>" readonly required>
                                <input type="text" id="QuantityAvailable" value="<?php echo $cart_product['quantity_available'] ?>" hidden required>

                                <button type="button" id="QuantityPlusCP" onclick="updateCartProductQuantity(<?php echo($_SESSION['userID'].', '.$cart_product['product_id'].', 1, '.$key)?>)">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            </form>

                            <span class="quantity-error">
                                <b>Error: </b> Wrong quantity. Please select correct quantity
                            </span>

                        </div>
                        <div class="cart-price">
                            $<?php echo $cart_product['price'] ?>
                        </div>
                        <div class="cart-single-total page">
                            $<?php echo $cart_product['total_price'] ?>
                        </div>
                    </div>
            <?php
                }

                //Fetching user account details
                $stmt = $conn -> prepare("SELECT * FROM user JOIN user_adress USING(user_id) WHERE user_id = :userID ");
                $stmt->bindParam(":userID", $_SESSION['userID'] , PDO::PARAM_INT);
                $stmt->execute();
                $account_details = $stmt->fetch(PDO::FETCH_ASSOC);
            ?>
            </div>

            <div class="checkout-form-container">
                <form class="checkout-form" action="../components/CART/OrderProccessCART.php" method="post">
                    <input type="number" name="totalPrice" class="cartTotalInput" value="<?php echo($cartTotal) ?>"  hidden required>
                    <input type="number" name="subtotalPrice" class="cartSubtotalInput" value="<?php echo($cart_products[0]['cart_subtotal']) ?>"  hidden required>
                    <input type="text" name="cartID" value="<?php echo($cart_product['cart_id']) ?>" hidden required>
                    
                    
                    <?php
                        if(!isset($account_details['country']))
                        {
                            ?>
                                <div class="form-row">
                                    <input type="text" name="name" value="<?php echo($account_details['nickname']) ?>" placeholder="Name *" required>
                                    <input type="text" name="surname" placeholder="Surname *" required>
                                </div>
                                <div class="form-row">
                                    <input type="email" name="mail" value="<?php echo($account_details['mail']) ?>" placeholder="E-mail *" required>
                                    <input type="text" name="phoneNumber" placeholder="Phone number">
                                </div>
                                <div class="form-row">
                                    <input type="text" name="street" placeholder="Street address *" required>
                                    <input type="text" name="houseNumber" placeholder="House number *" required>
                                </div>
                                <div class="form-row">
                                    <input type="text" name="city" placeholder="City *" required>
                                    <input type="text" name="postalCode" placeholder="Postal code *" required>
                                </div>
                                <div class="form-row">
                                    <input type="text" name="country" placeholder="Country *" required>
                                </div>
                            <?php
                        }
                        else
                        {
                            ?>
                                <div class="form-row">
                                    <input type="text" name="name" value="<?php echo($account_details['nickname']) ?>" placeholder="Name *" required>
                                    <input type="text" name="surname" placeholder="Surname *" required>
                                </div>
                                <div class="form-row">
                                    <input type="email" name="mail" value="<?php echo($account_details['mail']) ?>" placeholder="E-mail *" required>
                                    <input type="text" name="phoneNumber" placeholder="Phone number">
                                </div>
                                <div class="form-row">
                                    <input type="text" name="street" placeholder="Street address *" value="<?php echo($account_details['street']) ?>" required>
                                    <input type="text" name="houseNumber" placeholder="House number *" value="<?php echo($account_details['house_number']) ?>" required>
                                </div>
                                <div class="form-row">
                                    <input type="text" name="city" placeholder="City *" value="<?php echo($account_details['city']) ?>" required>
                                    <input type="text" name="postalCode" placeholder="Postal code *" value="<?php echo($account_details['postal_code']) ?>" required>
                                </div>
                                <div class="form-row">
                                    <input type="text" name="country" placeholder="Country *" value="<?php echo($account_details['country']) ?>" required>
                                </div>
                            <?php
                        }

                    ?>
                    
                    <div class="form-row">
                        <label>
                            <img src="../photos/logotypes/PayPal.png" alt="PayPal Logo">
                            <input type="radio" name="payment" value="paypal" required>
                        </label>
                        <label>
                            <img src="../photos/logotypes/Skrill.jpg" alt="Skrill Logo">
                            <input type="radio" name="payment" value="skrill" required>
                        </label>
                        <label>
                            <img src="../photos/logotypes/VisaMastercard.jpg" alt="Visa and Mastercard Logo">
                            <input type="radio" name="payment" value="creditCard" required>
                        </label>
                        <label>
                            <img src="../photos/logotypes/GooglePay.jpg" alt="GooglePay Logo">
                            <input type="radio" name="payment" value="googlePay" required>
                        </label>
                    </div>
                    <div class="form-row">
                        <span></span>

                        <button class="return-button" type="button">
                            <i class="fa-regular fa-arrow-left" style="color: #ffffff;"></i>
                            Back to products
                        </button>

                        <button class="submitForm" style="display: none"></button>

                        <span></span>
                    </div>
                </form>
            </div>
        </div>

        <div class="summary-box">
            <h2>Order Summary</h2>

            <span></span>

            <div class="summary-info-container">

                <div class="summary-info-legend">
                    <ul>
                        <li>Subtotal</li>
                        <li>Digital Services Tax</li>
                        <?php
                            if ($cart_products[0]['promo_code_id'] != null)
                            {
                                ?>
                                <li>
                                    Promo code
                                </li>
                                <li>Total</li>
                                <li class="promo-code">
                                    <?php echo ($cart_products[0]['code'])?>
                                    <i class="fa-regular fa-arrow-right fa-sm"></i>
                                </li>
                                <?php
                            }
                            else
                            {
                                ?>
                                    <li>Total</li>
                                    <li class="promo-code">
                                        Add coupon code
                                        <i class="fa-regular fa-arrow-right fa-sm"></i>
                                    </li>
                                <?php
                            }
                        ?>
                    </ul>
                </div>

                <div class="summary-info-data">
                    <ul>
                        <li class="subtotal">$<?php echo $cart_products[0]['cart_subtotal'] ?></li>
                        <li class="cartTax">
                            <?php
                                echo("$".number_format($cart_products[0]['cart_subtotal'] * 0.13, 2, '.'));
                            ?>
                        </li>
                        <?php
                        if ($cart_products[0]['promo_code_id'] != null)
                        {
                            ?>
                            <li>
                                <?php
                                    echo(($cart_products[0]['discount'] * 100)."% discount");
                                ?>
                            </li>
                            <?php
                        }
                        ?>
                        <li class="cartTotal">$<?php echo $cartTotal ?></li>
                    </ul>
                </div>
            </div>

            <span></span>

            <div class="checkout-button-container">
                <a class="checkout-button">
                    Checkout
                </a>
            </div>

        </div>
    </div>

    <?php
        //Importing footer
        include("../components/footer.php");
    ?>
    
</body>
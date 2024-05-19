<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap');


    input:focus-visible,
    textarea:focus-visible {
        border: none;
        outline: none;
    }

    .quantity-error {
        display: none;

        font-size: 12px;
        color: red;
    }

    .loader-overlay-container {
        z-index: 10001;

        background-color: rgba(0, 0, 0, 0.5);

        position: fixed;
        left: 0;
        top: 0;

        width: 100%;
        height: 100%;

        display: none;
        justify-content: center;
        align-items: center;
    }

    .loader {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: inline-block;
        position: relative;
        border: 3px solid;
        border-color: #FFF #FFF transparent transparent;
        box-sizing: border-box;
        animation: rotation 1s linear infinite;
    }
    .loader::after,
    .loader::before {
        content: '';
        box-sizing: border-box;
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        margin: auto;
        border: 3px solid;
        border-color: transparent transparent #5f33e4 #5f33e4;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        animation: rotationBack 0.5s linear infinite;
        transform-origin: center center;
    }
    .loader::before {
        width: 32px;
        height: 32px;
        border-color: #FFF #FFF transparent transparent;
        animation: rotation 1.5s linear infinite;
    }

    @keyframes rotation {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }
    @keyframes rotationBack {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(-360deg);
        }
    }

    .body-overlay-container {
        position: absolute;

        width: 100vw;
        height: 100vh;

        z-index: 9998;

        background-color: rgba(0, 0, 0, 0.5);

        align-items: center;
        justify-content: center;

        display: none;
    }

    .cart-container {
        width: 70%;
        height: 100%;
        min-width: 320px;

        overflow: hidden;
        overflow-y: scroll; 

        background-color: #ffffff;

        padding: 20px;

        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 20px;

        transition: 300ms ease-in-out;
    }

    .cart-container-title {
        font-family: "Poppins", sans-serif;
        font-weight: 500;

        font-size: 32px;

        margin-bottom: 15px;
        margin-top: 10px;
    }

    .legend-container {
        display: flex;
        flex-wrap: wrap;
        align-items: center;

        width: 100%;

        text-transform: uppercase;
        font-family: "Montserrat", sans-serif;
        font-size: 14px;
        color: rgba(0, 0, 0, 0.5);

        margin-bottom: -15px;
    }

    .legend-product{
        width: 60%;
    }

    .legend-quantity{
        width: 20%;
        text-align: center;
    }

    .legend-price{
        width: 10%;
        text-align: center;
    }

    .legend-total{
        width: 10%;
        text-align: right;
    }

    .cart-container-product-box {
        width: 100%;
        height: fit-content;

        font-family: "Kanit", sans-serif;

        display: flex;
        flex-wrap: wrap;
        align-items: center;
    }

    .cart-product {
        width: 60%;

        display: flex;

        align-items: start;
        gap: 20px;
    }

    .cart-product-photo  {
        height: 200px;

        position: relative;
    }

    .cart-product-photo img {
        height: 100%;
        object-fit: cover;

        max-width: 200px;

        border-radius: 6px;
    }

    .cart-delete-button {
        position: absolute;
        left: -5%;
        top: -5%;

        cursor: pointer;

        display: flex;
        justify-content: center;
        align-items: center;

        z-index: 9999;

        width: 20px;
        height: 20px;

        border-radius: 9999px;

        background-color: #d32f3d;
    }

    .cart-product-info {
        font-size: 24px;
        font-family: "Poppins", sans-serif;

        display: flex;
        flex-direction: column;
    }

    .cart-product-info span{
        color: #9a9ea6;
        font-size: 12px;
    }

    .cart-quantity {
        width: 20%;
        height: 100%;

        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .cart-quantity-form {
        display: flex;
        width: fit-content;
        gap: 5px;

        border: 2px solid rgba(128, 128, 128, 0.5);
    }

    .cart-quantity-form input {
        width: 50px;

        text-align: center;
    }

    .cart-quantity-form button {
        width: 40px;
        height: 40px;
    }

    .cart-price {
        width: 10%;

        text-align: center;

        font-size: 18px;
    }

    .cart-single-total{
        width: 10%;

        text-align: right;

        font-weight: bold;

        font-size: 18px;
    }

    .cart-product-separator {
        width: 100%;
        height: 2px;

        border: 0;
        border-radius: 4px;
        outline: 0;

        background-color: rgba(45, 45, 45, 0.5);
    }

    .cart-bottom {
        width: 100%;

        display: flex;
        align-items: end;
        justify-content: space-between;
    }

    .back-shopping{
        min-height: 15px;

        font-family: "Kanit", sans-serif;
        font-weight: bold;

        cursor: pointer;

        color: #5f33e4;
        font-size: 14px;

        transition: 200ms ease-in-out;
    }

    .back-shopping:hover {
        letter-spacing: 0.8px;
    }

    .checkout-container {
        display: flex;
        flex-direction: column;
        align-items: end;
        gap: 25px;

        font-family: "Kanit", sans-serif;
    }

    .checkout-info span{
        font-size: 16px;
    }

    .checkout-info h4 {
        font-size: 22px;
        font-weight: bold;
    }

    .cart-button {
        padding: 10px 15px 10px 15px;

        width: fit-content;

        border-radius: 8px;

        background-color: #4338CA;

        color: white;
        font-weight: bold;

        cursor: pointer;
        transition: 300ms ease-in-out;
    }

    .cart-button:hover {
        scale: 0.95;
    }
</style>

<?php
    try
    {
        //Fetching for user's products from cart
        $stmt = $conn -> prepare("SELECT * FROM cart JOIN cart_product USING(cart_id) LEFT JOIN promo_code USING(promo_code_id) JOIN product USING(product_id) WHERE user_id = :userID AND is_completed = 0");
        $stmt->bindParam(":userID", $_SESSION['userID'] , PDO::PARAM_INT);
        $stmt->execute();
        $cart_products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="loader-overlay-container">
    <span class="loader"></span>
</div>

<div class="body-overlay-container">
    <div class="cart-container">

        <h2 class="cart-container-title">
            My Cart
            <i class="fa-regular fa-cart-shopping fa-lg"></i>
        </h2>

        <div class="legend-container">
            <div class="legend-product">
                Product
            </div>
            <div class="legend-quantity">
                Quantity
            </div>
            <div class="legend-price">
                Price
            </div>
            <div class="legend-total">
                Total
            </div>
        </div>

        <hr class="cart-product-separator">


        <?php
        if (!$cart_products)
        {
            ?>
                <div style="width:100%; height:125px; text-align:center;">
                    <span style="color:gray; font-size:24px;">Your cart is currently empty</span>
                </div>
            <?php
        }
        else
        {
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
                            <button type="button" id="QuantityMinus" onclick="updateCartProductQuantity(<?php echo($_SESSION['userID'].', '.$cart_product['product_id'].', -1, '.$key)?>)">
                                <i class="fa-solid fa-minus"></i>
                            </button>

                            <input type="text" id="QuantityInput" value="<?php echo $cart_product['quantity']?>" readonly required>
                            <input type="text" id="QuantityAvailable" value="<?php echo $cart_product['quantity_available'] ?>" hidden required>

                            <button type="button" id="QuantityPlus" onclick="updateCartProductQuantity(<?php echo($_SESSION['userID'].', '.$cart_product['product_id'].', 1, '.$key)?>)">
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
                    <div class="cart-single-total">
                        $<?php echo $cart_product['total_price'] ?>
                    </div>
                </div>

                <hr class="cart-product-separator">

            <?php
            }
        }
            ?>

        <div class="cart-bottom">
            <div class="back-shopping">
                <i class="fa-regular fa-arrow-left"></i>
                &nbsp;
                Continue shopping
            </div>
            <div class="checkout-container">
                <?php
                if ($cart_products)
                {
                ?>
                    <div class="checkout-info">
                        <span>Subtotal:</span>
                        <h4 class="subtotal">$<?php echo $cart_products[0]['cart_subtotal'] ?></h4>
                    </div>
                    <a href="../cart/index.php" class="cart-button">
                        Checkout
                    </a>
                <?php
                }
    }
    catch(PDOException $e) 
    {
        ?>
            <script>window.location.replace("../errors/uncaught.php?errorCode=<?php echo $e->getMessage(); ?>");</script>
        <?php
    }
        ?>
            </div>
        </div>
    </div>
</div>

<script>
//ClosingCartOverlay
{
    let closeCartButton = document.querySelector(".back-shopping");
    let cart = document.querySelector(".body-overlay-container");

    closeCartButton.addEventListener("click", function ()
    {
        cart.style.display = "none";
    })
}

//ProductQuantityChange
{
    document.addEventListener("DOMContentLoaded", function () {

        //Overlay elements
        let quantityInputs = document.querySelectorAll("#QuantityInput");
        let plusButtons = document.querySelectorAll("#QuantityPlus");
        let minusButtons = document.querySelectorAll("#QuantityMinus");

        //Cart page elements
        let quantityInputsCP = document.querySelectorAll("#QuantityInputCP");
        let plusButtonsCP = document.querySelectorAll("#QuantityPlusCP");
        let minusButtonsCP = document.querySelectorAll("#QuantityMinusCP");

        
        plusButtonsCP.forEach((plusButtonCP, index) =>
        {
            plusButtonCP.addEventListener("click", function ()
            {
                quantityInputs[index].value++;
                quantityInputsCP[index].value++;
            });
        });


        plusButtons.forEach((plusButton, index) =>
        {
            plusButton.addEventListener("click", function ()
            {
                quantityInputs[index].value++;
                if(quantityInputsCP != undefined)
                {
                    quantityInputsCP[index].value++;
                }
            });
        });

        minusButtonsCP.forEach((minusButtonCP, index) =>
        {
            minusButtonCP.addEventListener("click", function ()
            {
                quantityInputs[index].value--;
                quantityInputsCP[index].value--;
            });
        });

        minusButtons.forEach((minusButton, index) =>
        {
            minusButton.addEventListener("click", function ()
            {
                quantityInputs[index].value--;
                if(quantityInputsCP != undefined)
                {
                    quantityInputsCP[index].value--;
                }
            });
        });
    })
}

//Function used to change quantity in database
function updateCartProductQuantity(userID, productID, type, productNumber)
{
    //Overlay elements
    let loaderContainer = document.querySelector(".loader-overlay-container");
    let currQuantity = document.querySelectorAll("#QuantityInput")[productNumber].value;
    let availableQuantity = document.querySelectorAll("#QuantityAvailable")[productNumber].value;
    let priceContainer = document.querySelectorAll(".cart-single-total")[productNumber];

    //Shared elements
    let subtotalPriceContainer = document.querySelectorAll(".subtotal");

    //Cart page elements
    let priceContainerPage = document.querySelectorAll(".cart-single-total.page")[productNumber];
    let totalPriceContainerPage = document.querySelector(".cartTotal");
    let totalPriceInputPage = document.querySelector(".cartTotalInput");
    let subtotalPriceInputPage = document.querySelector(".cartSubtotalInput");
    let taxAmountContainerPage = document.querySelector(".cartTax");
    
    //Sending error request if the number of products is incorrect
    if (parseInt(currQuantity) + type > parseInt(availableQuantity) || parseInt(currQuantity) + type < 1)
    {
        // Setting handling script URL
        const url = '../components/dialogbox.php';

        //Setting data package
        const data = {
            message: "Invalid quantity selected. Please choose a value between 1 and the available quantity.",
            link: "index.php<?php if(isset($_GET['productID'])) echo("?productID=".$_GET['productID']) ?>",
            type: "failure"
        };

        // Sending POST request
        fetch(url,
            {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.text())
            .then(data =>
            {
                //Showing error dialogbox
                document.querySelector("body").innerHTML += data;
            })
        return;
    }

    //Showing overlay loading container
    loaderContainer.style.display = "flex";

    // Setting handling script URL
    const url = '../components/CART/ChangeQuantityCART.php';

    //Setting data package
    const data = {
        userID: userID,
        productID: productID,
        type: type,
        currQuantity: currQuantity 
    };

    // Sending POST request
    fetch(url, 
    {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => 
    {
        //Updating total price for item which quantity has been modified in cart overlay
        priceContainer.innerHTML = "$" + data.productTotalPrice;

        //Updating total price for item which quantity has been modified, cart total(with taxes/discounts), tax amount on cart page 
        if (priceContainerPage !== undefined) {
            priceContainerPage.innerHTML = "$" + data.productTotalPrice;
            taxAmountContainerPage.innerHTML = "$" + (data.cartSubtotal*0.13).toFixed(2);
            totalPriceContainerPage.innerHTML = "$" + ((data.cartSubtotal * 1.13) * (1 - data.discount)).toFixed(2);
            totalPriceInputPage.value = ((data.cartSubtotal * 1.13) * (1 - data.discount)).toFixed(2);
            subtotalPriceInputPage.value = data.cartSubtotal;
        }

        //Updating subtotal for overlay and for cart page if user is on the cart page
        subtotalPriceContainer.forEach(element => {
            element.innerHTML = "$" + data.cartSubtotal;
        })

    })
    .finally(() => {

        setTimeout(() => {
            loaderContainer.style.display = "none";
        }, 300);

    })
}
</script>

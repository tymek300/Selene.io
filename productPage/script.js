//Slideshow
{
    let SlideNum = 0;

    function Slideshow(number) {
        let Boxes = document.querySelectorAll("#PhotoBox");
        let Photos = document.querySelectorAll("#ProductPhoto");

        Photos[SlideNum].style.display = "none";

        Boxes[SlideNum].style.backgroundColor = "#9CA3AF";

        SlideNum += number;
        if (SlideNum < 0) {
            SlideNum = Photos.length - 1;
        }
        else if (SlideNum > Photos.length - 1) {
            SlideNum = 0;
        }

        Photos[SlideNum].style.display = "inline";
        Boxes[SlideNum].style.backgroundColor = "#2b18ff";
    }
}

//CartIconClassChange
{
    let CartIcons = document.querySelectorAll(".cart-icon");

    CartIcons.forEach(element => {
        element.addEventListener('mouseenter', function () {
            element.children[0].className = "fa-regular fa-cart-shopping fa-lg fa-shake"
        })

        element.addEventListener('mouseleave', function () {
            element.children[0].className = "fa-regular fa-cart-shopping fa-lg";
        })
    });
}

//ProductQuantityChange
{
    let plusButtons = document.querySelectorAll("#QuantityPlusPP");
    let minusButtons = document.querySelectorAll("#QuantityMinusPP");
    let quantityInputs = document.querySelectorAll("#QuantityInputPP");
    let quantityAvailableInputs = document.querySelectorAll("#QuantityAvailablePP");
    let quantityErrors = document.querySelectorAll(".quantity-errorPP");
    let submitButtons = document.querySelectorAll(".cart-button");

    plusButtons.forEach((plusButton, index) => {
        plusButton.addEventListener("click", function () {

            let quantityInput = quantityInputs[index];
            let quantityAvailableInput = quantityAvailableInputs[index];
            let quantityError = quantityErrors[index];

            quantityInput.value++;

            validateQuantity(quantityInput, quantityAvailableInput, quantityError);
        });
    });


    minusButtons.forEach((minusButton, index) => {
        minusButton.addEventListener("click", function () {

            let quantityInput = quantityInputs[index];
            let quantityAvailableInput = quantityAvailableInputs[index];
            let quantityError = quantityErrors[index];

            quantityInput.value--;

            validateQuantity(quantityInput, quantityAvailableInput, quantityError);
        });
    });

    function validateQuantity(quantityInput, quantityAvailableInput, quantityError) {
        let quantityAvailable = parseInt(quantityAvailableInput.value);
        if (quantityInput.value > quantityAvailable || quantityInput.value < 1) {
            quantityError.style.display = "inline";
        } else {
            quantityError.style.display = "none";
        }

        let allValid = true;
        quantityInputs.forEach((input, index) => {
            if (parseInt(input.value) > parseInt(quantityAvailableInputs[index].value) || parseInt(input.value) < 1) {
                allValid = false;
            }
        });

        submitButtons.forEach((submitButton) => {
            submitButton.disabled = !allValid;
            submitButton.style.backgroundColor = allValid ? "#4338CA" : "gray";
        })
    }
}

//DeleteFromFavoriteContentChange
{
    let button = document.querySelector(".favourite-icon-box.active");

    let icon = document.querySelector(".favourite-icon-box i");
    let span = document.querySelector(".favourite-icon-box span");

    button.addEventListener("mouseenter", function () {
        icon.className = "fa-solid fa-trash";
        span.innerText = "Delete product from Favorite";
    })

    button.addEventListener("mouseleave", function () {
        icon.className = "fa-solid fa-heart";
        span.innerText = "Favourite product";
    })
}
//CheckoutFormSwitch
{
    let proceedbutton = document.querySelector(".checkout-button");
    let returnButton = document.querySelector(".return-button");
    let productsContainer = document.querySelector(".products-container");
    let checkoutDataContainer = document.querySelector(".checkout-form-container");
    let submitButton = document.querySelector(".submitForm");
    let pointer = document.querySelector(".purple");
    let legend = document.querySelectorAll("#DotPointer p");

    returnButton.addEventListener("click", function () {
        if(window.getComputedStyle(productsContainer).display === "none")
        {
            productsContainer.style.display = "flex";
            checkoutDataContainer.style.display = "none";

            pointer.style.transform = "translate(-55%)";

            legend[0].style.opacity = "1";
            legend[1].style.opacity = "0";

            proceedbutton.innerHTML = "Checkout";

            proceedbutton.removeEventListener("click", SubmitForm);
        }
    })

    proceedbutton.addEventListener("click", function () {
        if(window.getComputedStyle(productsContainer).display === "flex")
        {
            productsContainer.style.display = "none";
            checkoutDataContainer.style.display = "flex";

            pointer.style.transform = "translate(55%)";

            legend[0].style.opacity = "0";
            legend[1].style.opacity = "1";

            proceedbutton.innerHTML = "Confirm purchase";

            proceedbutton.addEventListener("click", SubmitForm);
        }
    })

    function SubmitForm()
    {
        submitButton.click();
    }
}


//PromoCodesForm
{
    let promoCodeContainer = document.querySelector(".promo-code-container");
    let closeButton = document .querySelector(".closePromoCode");
    let showButton = document.querySelector(".promo-code");
    let submitButton = document.querySelector(".submitPromoCode");


    showButton.addEventListener("click", function () {
        if (window.getComputedStyle(promoCodeContainer).display === "block")
        {
            promoCodeContainer.style.display = "none";
        }
        else
        {
            promoCodeContainer.style.display = "block";
        }
    })

    closeButton.addEventListener("click", function () {
        if (window.getComputedStyle(promoCodeContainer).display === "block")
        {
            promoCodeContainer.style.display = "none";
        }
        else
        {
            promoCodeContainer.style.display = "block";
        }
    })
}
//ShowingDialogBoxes
{
    function Display(number)
    {
        let elements = document.querySelectorAll(".body-overlay");
        elements[number].style.display = "block";
    }
}

//UserDataSelection
{
    let ReviewButton = document.querySelector("#ReviewButton");
    let FavoriteButton = document.querySelector("#FavoriteButton");
    let PointerDot = document.querySelector("#DotPointer.purple");
    let FavoriteSection = document.querySelector(".user-favourite-products");
    let UserReviews = document.querySelector(".user-review-section");

    ReviewButton.addEventListener("click", function() {
        PointerDot.style.left = "17%";

        FavoriteSection.style.display = "none";
        UserReviews.style.display =  "flex";

        FavoriteButton.style.backgroundColor = "#5f33e4";
        ReviewButton.style.backgroundColor = "#754eeb";
    })

    FavoriteButton.addEventListener("click", function () {
        PointerDot.style.left = "68%";

        FavoriteSection.style.display = "flex";
        UserReviews.style.display =  "none";

        FavoriteButton.style.backgroundColor = "#754eeb";
        ReviewButton.style.backgroundColor = "#5f33e4";
    })
}

//ProductCategoryReveal
{
    function Reveal(element) {
        let lastChild = element.lastElementChild;

        let computedHeight = window.getComputedStyle(lastChild).getPropertyValue('height')

        let size = String(element.querySelectorAll("li").length * 55) + "px";

        if (computedHeight === "0px") {
            lastChild.style.height = size;
        } else {
            lastChild.style.height = "0px";
        }
    }
}
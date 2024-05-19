//SideNavBarRevealing
{
    function Reveal(element) {
        let lastChild = element.lastElementChild;

        let computedHeight = window.getComputedStyle(lastChild).getPropertyValue('height')

        let size = String(element.querySelectorAll("li").length * 40) + "px";

        if (computedHeight === "0px") {
            lastChild.style.height = size;
        } else {
            lastChild.style.height = "0px";
        }
    }
}

//Slideshow
{
    let SlideNum = 0;

    function Slideshow(number) {
        let elements = document.querySelectorAll("#slide");
        elements[SlideNum].style.display = "none";

        SlideNum += number;
        if (SlideNum < 0) {
            SlideNum = elements.length - 1;
        }
        else if (SlideNum > elements.length - 1) {
            SlideNum = 0;
        }

        elements[SlideNum].style.display = "inline";
    }
}

//CartIconClassChange
{
    let CartIcons = document.querySelectorAll(".card-icon");

    CartIcons.forEach(element => {
        element.addEventListener('mouseenter', function () {
            element.children[0].className = "fa-regular fa-cart-shopping fa-lg fa-shake"
        })

        element.addEventListener('mouseleave', function () {
            element.children[0].className = "fa-regular fa-cart-shopping fa-lg";
        })
    });
}

// ProductFilterFormValidation
{
    let filterInputsFrom = document.querySelectorAll("input[placeholder='From']");
    let filterInputsTo = document.querySelectorAll("input[placeholder='To']");

    let warning = document.querySelector("h2.warning");

    let submitButton = document.querySelector(".filter-actions button");

    function validateInputs() {
        // Flag indicating if all pairs are valid
        let allPairsValid = true;

        // Iterate through all pairs of inputs
        filterInputsFrom.forEach((input, index) => {
            const fromValue = parseFloat(input.value);
            const toValue = parseFloat(filterInputsTo[index].value.trim());

            if (!isNaN(fromValue) && !isNaN(toValue) && fromValue > toValue) {
                allPairsValid = false;
            }
        });

        filterInputsTo.forEach((input, index) => {
            const toValue = parseFloat(input.value);
            const fromValue = parseFloat(filterInputsFrom[index].value.trim());

            if (!isNaN(fromValue) && !isNaN(toValue) && toValue < fromValue) {
                allPairsValid = false;
            }
        });

        // Set button and warning visibility based on validation
        if (!allPairsValid) {
            submitButton.disabled = true;
            submitButton.style.backgroundColor = "gray";
            warning.style.display = "inline";
        } else {
            submitButton.disabled = false;
            submitButton.style.backgroundColor = "#696cff";
            warning.style.display = "none";
        }
    }

    // Add change event listeners for all inputs
    filterInputsFrom.forEach(input => {
        input.addEventListener("change", validateInputs);
    });

    filterInputsTo.forEach(input => {
        input.addEventListener("change", validateInputs);
    });
}

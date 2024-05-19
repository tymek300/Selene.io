//USER SECTION
//ModifyUserForm
{
    function ModifyUser(userID, nickname, mail, admin)
    {
        document.querySelector(".user-modify-form-box").style.display = "block";

        document.querySelector(".userModifyForm .idInput").value = userID;
        document.querySelector(".userModifyForm input[name='hiddenNick']").value = nickname;
        document.querySelector(".userModifyForm input[name='hiddenMail']").value = mail;
        
        document.querySelector(".userModifyForm input[name='nickname']").value = nickname;
        document.querySelector(".userModifyForm input[name='mail']").value = mail;

        document.querySelector(".userModifyForm input[name='admin'][value='" + admin + "']").checked = true;

        if(admin === 1)
        {
            document.querySelector(".userModifyForm input[name='admin'][value='0']").disabled = true;
        }
    }
}

//AddUserForm
{
    function AddUser()
    {
        document.querySelector(".user-add-form-box").style.display = "block";
    }
}

//DeleteUserForm
{
    function DeleteUser(userID)
    {
        document.querySelector(".delete-user-form-box").style.display = "block";

        document.querySelector(".deleteUserForm .idInput").value = userID;
    }
}

//CATEGORIES SECTION
//ShowSubcategories
{
    function toggleSubcategories(button) {
        let subcategoriesList = button.closest('.categories-bar').querySelector('.subcategories');

        let categoriesBar = button.closest('.categories-bar');

        let currentHeight = window.getComputedStyle(categoriesBar).gap;
    
        if (currentHeight === "0px") {
            subcategoriesList.style.height = "fit-content";

            button.textContent = "Hide subcategories";

            categoriesBar.style.gap = "40px";
        } else {
            subcategoriesList.style.height = "0";

            button.textContent = "Show subcategories";

            categoriesBar.style.gap = "0px";
        }
    }

    let showSubcategoriesLinks = document.querySelectorAll('.category-actions a[style="background-color: #FFAC1C"]');

    showSubcategoriesLinks.forEach(function(button) {
        button.addEventListener("click", function() {
            toggleSubcategories(button);
        });
    });
}

//CategorySubcategoryNameChangeForm
{
    function ChangeCategoryName(categoryID, name, type)
    {
        document.querySelector(".category-subcategory-name-form-box").style.display = "block";

        document.querySelector(".categorySubcategoryNameForm .idInput").value = categoryID;
        document.querySelector(".categorySubcategoryNameForm .typeInput").value = type;
        document.querySelector(".categorySubcategoryNameForm .formTextInput").value = name;
    }
}

//DeleteCategorySubcategory
{
    function DeleteCategory(categoryID, type)
    {
        document.querySelector(".category-subcategory-delete-form-box").style.display = "block";

        document.querySelector(".categorySubcategoryDeleteForm .idInput").value = categoryID;
        document.querySelector(".categorySubcategoryDeleteForm .typeInput").value = type;
    }
}

//IconChangeValidation
{
    let inputs = document.querySelectorAll("input[name='newIcon']");

    inputs.forEach(element => {
        element.addEventListener("change", function() {

            // Icon input regex
            let regex = /<(i|svg).*?<\/(i|svg)>/;
            let value = element.value;

            if (!regex.test(value)) 
            {
                let error = element.parentNode.nextSibling;
                
                while (error && error.nodeType !== 1) {
                    error = error.nextSibling;
                }

                error.style.display = "inline";
            } 
            else 
            {
                let error = element.parentNode.nextSibling;

                while (error && error.nodeType !== 1) {
                    error = error.nextSibling;
                }

                error.style.display = "none";
            }

        });
    });
}

//ChangeCategoryIcon
{
    function IconChange(categoryID, icon)
    {
        document.querySelector(".category-icon-change-form-box").style.display = "block";

        document.querySelector(".categoryIconChangeForm .idInput").value = categoryID;
        document.querySelector(".categoryIconChangeForm .formTextInput").value = icon;
    }
}

//AddingSubcategory
{
    function AddSubcategory(categoryID, name)
    {
        document.querySelector(".subcategory-add-form-box").style.display = "block";

        document.querySelector(".subcategoryAddForm input[name='categoryID']").value = categoryID;
        document.querySelector(".subcategoryAddForm input[name='categoryName']").value = name;
    }
}

//AddingCategory
{
    function AddCategory()
    {
        document.querySelector(".category-add-form-box").style.display = "block";
    }
}

//PRODUCTS SECTION
//AddProduct 
{
    function AddProduct()
    {
        document.querySelector(".product-add-form-box").style.display = "block";
    }
}

//ModifyProduct
{
    function ModifyProduct(productID, name, price, description, qAvailable, qSold, rating)
    {
        document.querySelector(".product-modify-form-box").style.display = "block";

        document.querySelector(".productModifyForm .idInput").value = productID;
        document.querySelector(".productModifyForm input[name='productName']").value = name;
        document.querySelector(".productModifyForm input[name='hiddenName']").value = name;
        document.querySelector(".productModifyForm input[name='productPrice']").value = price;
        document.querySelector(".productModifyForm textarea[name='productDescription']").value = description;
        document.querySelector(".productModifyForm input[name='productQAvailable']").value = qAvailable;
        document.querySelector(".productModifyForm input[name='productQSold']").value = qSold;
        document.querySelector(".productModifyForm input[name='productRating']").value = rating;
    }
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

//DeleteProduct
{
    function DeleteProduct(name)
    {
        document.querySelector(".product-delete-form-box").style.display = "block";

        document.querySelector(".productDeleteForm input[name='hiddenName']").value = name;
    }
}

//AddProductToCategory
{
    function ProductCategory(productID, element)
    {
        document.querySelector(".product-category-form-box").style.display = "block";

        document.querySelector(".productCategoryForm .idInput").value = productID;

        let dataArray = JSON.parse(element.getAttribute('data-array'));

        dataArray.forEach(subcategoryID => {
            console.log(subcategoryID);
            document.querySelector(".productCategoryForm option[value='" + subcategoryID + "']").disabled = true;
        });

        let options = document.querySelectorAll(".productCategoryForm option");

        options.forEach(option => {
            option.selected = option.disabled === false;
        });
    }
}

//Delete product from category
{
    function ProductCategoryDelete(productID, subcategoryID)
    {
        document.querySelector(".product-category-delete-form-box").style.display = "block";

        document.querySelector(".productCategoryDeleteForm input[name='productID']").value = productID;
        document.querySelector(".productCategoryDeleteForm input[name='subcategoryID']").value = subcategoryID;
    }
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

//ProductDialogboxFormValidation
{
    //Fetching for product name and description
    let inputs = document.querySelectorAll("input[name='productName']");
    let textareas = document.querySelectorAll("textarea[name='productDescription']");

    //Fetching for error messages
    let errorMessagesName = document.querySelectorAll(".warning.name");
    let errorMessagesDescription = document.querySelectorAll(".warning.description");

    //Fetching for submit buttons
    let submitButtons = document.querySelectorAll(".form-block");

    //Setting forbidden character in description and name
    const forbiddenCharsName = ["<", ">", ":", "\"", "/", "\\", "|", "?", "*", "'"];
    const forbiddenCharsDescription = ["'", "\\"];

    //Setting flags of correctness of name and description
    let isNameValid = true;
    let isDescriptionValid = true;

    //Function to validate name
    function validateName(value) 
    {
        for (let i = 0; i < forbiddenCharsName.length; i++) 
        {
            if (value.includes(forbiddenCharsName[i])) 
            {
                return false;
            }
        }
        return true;
    }

    //Function to validate description
    function validateDescription(value) 
    {
        for (let i = 0; i < forbiddenCharsDescription.length; i++) 
        {
            if (value.includes(forbiddenCharsDescription[i])) 
            {
                return false;
            }
        }
        return true;
    }

    //Function for disabling/enabling form submit button
    function updateSubmitButtonState() 
    {
        //If name and desciption flags are true(their values are correct)
        if (isNameValid && isDescriptionValid) 
        {
            submitButtons.forEach(submitButton => {
                submitButton.disabled = false;
                submitButton.style.backgroundColor = "#32de84";
            });

        } 
        else 
        {
            submitButtons.forEach(submitButton => {
                submitButton.disabled = true;
                submitButton.style.backgroundColor = "gray";
            });
        }
    }

    //Adding event listener to product name inputs
    inputs.forEach(input => {
        input.addEventListener("change", function() {
            const value = this.value;

            //Checking correctness of provided name
            isNameValid = validateName(value);

            //Updating state of submit button
            updateSubmitButtonState();

            //Showind/hidding name error message
            errorMessagesName.forEach(errorMessage => {
                errorMessage.style.display = isNameValid ? "none" : "block";
            });
        });
    });

    //Adding event listener to product description textareas
    textareas.forEach(textarea => {
        textarea.addEventListener("change", function() {
            const value = this.value;

            //Checking correctness of provided description
            isDescriptionValid = validateDescription(value);

            //Updating state of submit button
            updateSubmitButtonState();

            //Showind/hidding description error message
            errorMessagesDescription.forEach(errorMessage => {
                errorMessage.style.display = isDescriptionValid ? "none" : "block";
            });
        });
    });

}

//PRODUCT PHOTOS SECTION

//DeletePhoto
{
    function DeletePhoto(productID, main)
    {
        document.querySelector(".photo-delete-form-box").style.display = "block";

        document.querySelector(".photoDeleteForm .idInput").value = productID;

        if(main === 1)
        {
            document.querySelector(".photo-delete-form-box  .warning").style.display = "block";
        }
        else
        {
            document.querySelector(".photo-delete-form-box  .warning").style.display = "none";
        }
    }
}

//AddPhoto
{
    function AddPhoto(photoID)
    {
        document.querySelector(".photo-add-form-box").style.display = "block";

        document.querySelector(".photoAddForm .idInput").value = photoID;
    }
}

//SetPhotoMain
{
    function PhotoMain(photoID, productID)
    {
        document.querySelector(".photo-main-form-box").style.display = "block";

        document.querySelector(".photoMainForm input[name='photoID']").value = photoID;
        document.querySelector(".photoMainForm input[name='productID']").value = productID;
    }
}

//PROMO CODES SECTION

//ModifyPromoCode
{
    function ModifyPromoCode(promoCodeID, name, discount)
    {
        document.querySelector(".promo-code-modification-form-box").style.display = "block";

        document.querySelector(".promoCodeModificationForm input[name='ID']").value = promoCodeID;
        document.querySelector(".promoCodeModificationForm input[name='oldName']").value = name;

        document.querySelector(".promoCodeModificationForm input[name='newName']").value = name;
        document.querySelector(".promoCodeModificationForm input[name='newDiscount']").value = discount;
    }

}

//AddPromoCode
{
    function AddPromoCode()
    {
        document.querySelector(".promo-code-add-form-box").style.display = "block";
    }

}

//DeletePromoCode
{
    function DeletePromoCode(promoCodeID)
    {
        document.querySelector(".promo-code-delete-form-box").style.display = "block";

        document.querySelector(".promoCodeDeleteForm .idInput").value = promoCodeID;
    }

}

//ORDERS SECTION

//ChangeOrderStatus
{
    function ChangeOrderStatus(orderID)
    {
        document.querySelector(".order-status-form-box").style.display = "block";

        document.querySelector(".orderStatusForm .idInput").value = orderID;
    }
}


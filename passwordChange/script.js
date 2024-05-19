//NewPasswordValidation
{
	let newPasswordInput = document.querySelector('input[name="newpassword"]');
	const regex = /^(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$/;

	newPasswordInput.addEventListener("change", function () {
        
		if (!regex.test(newPasswordInput.value)) {
			document.querySelector('.password-error').style.display = "inline";

			document.querySelector('button').style.backgroundColor = "grey";
			document.querySelector('button').style.borderColor = "grey";
			document.querySelector('button').disabled = true;
		}
		else
		{
			document.querySelector('.password-error').style.display = "none";

			document.querySelector('button').style.backgroundColor = "#533c99";
			document.querySelector('button').style.borderColor = "#533c99";
			document.querySelector('button').disabled = false;
		}
	});
}

//SimiliarityOfPasswords
{
    let newPasswordInput = document.querySelectorAll('input[name="newpassword"]');

    newPasswordInput.forEach(element => {

        element.addEventListener("change", function(){

            if(newPasswordInput[0].value !== newPasswordInput[1].value)
            {
                document.querySelector('.similiarity').style.display = "inline";

                document.querySelector('button').style.backgroundColor = "grey";
                document.querySelector('button').style.borderColor = "grey";
                document.querySelector('button').disabled = true;
            }
            else
            {
                document.querySelector('.similiarity').style.display = "none";

                document.querySelector('button').style.backgroundColor = "#533c99";
                document.querySelector('button').style.borderColor = "#533c99";
                document.querySelector('button').disabled = false;
            }
        })
    });
}

//NonTheSameAsOld
{
    function Check() 
    {
        if (newPasswordInput.value === oldPasswordInput.value) 
        {
            document.querySelector('.old-new').style.display = "inline";
            document.querySelector('button').style.backgroundColor = "grey";
            document.querySelector('button').style.borderColor = "grey";

            document.querySelector('button').disabled = true;
        } 
        else 
        {
            document.querySelector('.old-new').style.display = "none";
            document.querySelector('button').style.backgroundColor = "#533c99";
            document.querySelector('button').style.borderColor = "#533c99";

            document.querySelector('button').disabled = false;
        }
    }
    
    const newPasswordInput = document.querySelector('input[name="newpassword"]');
    const oldPasswordInput = document.querySelector('input[name="password"]');

    newPasswordInput.addEventListener("change", Check);
    oldPasswordInput.addEventListener("change", Check);
}
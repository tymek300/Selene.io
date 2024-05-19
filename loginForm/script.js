//FormManagement
{
	const signUpButton = document.getElementById('signUp');
	const signInButton = document.getElementById('signIn');
	const container = document.getElementById('container');

	signUpButton.addEventListener('click', () => {
		container.classList.add("right-panel-active");
	});

	signInButton.addEventListener('click', () => {
		container.classList.remove("right-panel-active");
	});
}

//FormValidation
{
	let passwordInput = document.querySelector('.sign-up-container input[type="password"]');
	const regex = /^(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$/;

	passwordInput.addEventListener("change", function () {

		passwordInput = document.querySelector('.sign-up-container input[type="password"]');
		
		if (!regex.test(passwordInput.value)) {
			document.querySelector('.password-error').style.display = "inline";

			document.querySelector('.sign-up-container button').style.backgroundColor = "grey";
			document.querySelector('.sign-up-container button').style.borderColor = "grey";
			document.querySelector('.sign-up-container button').disabled = true;
		}
		else
		{
			document.querySelector('.password-error').style.display = "none";

			document.querySelector('.sign-up-container button').style.backgroundColor = "#533c99";
			document.querySelector('.sign-up-container button').style.borderColor = "#533c99";
			document.querySelector('.sign-up-container button').disabled = false;
		}
	});
}
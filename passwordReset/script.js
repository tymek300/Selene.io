//FormValidation
{
	let passwordInput = document.querySelector('input[type="password"]');
	const regex = /^(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$/;

	passwordInput.addEventListener("change", function () {

		passwordInput = document.querySelector('input[type="password"]');
		
		if (!regex.test(passwordInput.value)) {
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
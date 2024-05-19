<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="/Selene.io/photos/logotypes/favicon.ico" type="image/x-icon">
	<title>Selene 404</title>

	<!-- Google font -->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,900" rel="stylesheet">

	<!-- Custom stylesheet -->
	<style>
		* {
			-webkit-box-sizing: border-box;
			box-sizing: border-box;
		}

		body {
			padding: 0;
			margin: 0;
		}

		#notfound {
			position: relative;

			height: 100vh;
		}

		#notfound .notfound {
			position: absolute;

			left: 50%;
			top: 50%;

			-webkit-transform: translate(-50%, -50%);
			-ms-transform: translate(-50%, -50%);
			transform: translate(-50%, -50%);
		}

		.notfound {
			max-width: 410px;
			width: 100%;

			text-align: center;

			user-select: none;
		}

		.notfound .notfound-404 {
			height: 280px;

			position: relative;
			z-index: -1;
		}

		.notfound .notfound-404 h1 {
			font-family: 'Montserrat', sans-serif;
			font-size: 230px;
			font-weight: 900;

			margin: 0;

			position: absolute;
			left: 50%;

			-webkit-transform: translateX(-50%);
			-ms-transform: translateX(-50%);
			transform: translateX(-50%);

			background-size: cover;
			background: url('/Selene.io/photos/baners/errorTextBG.jpg') no-repeat center;
			-webkit-background-clip: text;
			-webkit-text-fill-color: transparent;
		}


		.notfound h2 {
			font-family: 'Montserrat', sans-serif;

			color: #000;
			font-size: 24px;
			font-weight: 700;

			text-transform: uppercase;

			margin-top: 0;
		}

		.notfound p {
			font-family: 'Montserrat', sans-serif;
			color: #000;
			font-size: 14px;
			font-weight: 400;

			margin-bottom: 20px;
			margin-top: 0;
		}

		.notfound a {
			font-family: 'Montserrat', sans-serif;
			font-size: 14px;

			text-decoration: none;
			text-transform: uppercase;

			background: #533c99;

			display: inline-block;

			padding: 15px 30px;

			border-radius: 40px;

			transition: 100ms ease-in-out;

			color: #fff;

			font-weight: 700;

			-webkit-box-shadow: 0 4px 15px -5px #533c99;
			box-shadow: 0 4px 15px -5px #533c99;
		}

		.notfound a:hover {
			scale: 0.95;
		}


		@media only screen and (max-width: 767px) {
			.notfound .notfound-404 {
				height: 142px;
			}

			.notfound .notfound-404 h1 {
				font-size: 112px;
			}
		}
	</style>

</head>

<body>

	<div id="notfound">
		<div class="notfound">
			<div class="notfound-404">
				<h1>Oops!</h1>
			</div>
			<h2>Error</h2>
			<p>We don't know exactly what happened, but we're sure that you experienced an error. Please contact our
				support to solve it.</p>
			<?php
				if(isset($_GET['errorCode']))
				{
					echo "<p><b>Error code:</b> " . $_GET['errorCode'] . "</p>";
				}
			?>
			<a href="/Selene.io/main">Go To Homepage</a>
		</div>
	</div>

</body>

</html>
<?php
	include "include/config2.php";

	session_start();
	if(isset($_POST["newUserPassword"])&&isset($_POST["newUserPasswordConfirm"])&&isset($_SESSION["userId"])&&isset($_SESSION["passwordResetToken"])){
		$data = array(
				UserID=>$_SESSION["userId"],
				PasswordResetToken=>$_SESSION["passwordResetToken"],
				NewPassword=>$_POST["newUserPassword"],
				ConfirmPassword=>$_POST["newUserPasswordConfirm"]
			);
		
		$jsonData = json_encode($data);
		$ch = curl_init($apiBaseUrl.'Account/ResetPassword');
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); 
		/*curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_NOBODY, true); */
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);                                                                  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt($ch, CURLOPT_CAINFO, getcwd() . $certPath);	                                                                     
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
			'Content-Type: application/json; charset=UTF-8',                                                                                
			'Content-Length: '. strlen($jsonData))
		);
		
		$postResult = curl_exec($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		$jsonPostResult = json_decode($postResult);
		if($jsonPostResult->status && $jsonPostResult->message == "Password Reset Successful"){
			header("Location: resetpasswordsuccessful.php");
		}
		else{
			//$message=$jsonPostResult->Errors[0];
			$errorMessage=$jsonPostResult->message;
		}
	}

	 if(isset($_GET["id"])&&isset($_GET["token"])){
	 	$_SESSION["userId"]=$_GET["id"];
	 	$_SESSION["passwordResetToken"]=$_GET["token"];
	 }
?>

<!DOCTYPE html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans">
<link rel="stylesheet" href="assets/css/bootstrap.min.custom.css">
<link rel="stylesheet" href="assets/css/custom.css">

<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>

<script>
$(function() {
  $("#showPassword").click(function() {
    var x = document.getElementById("password");
    var ico = $("#showPassword i");
    if (x.type === "password") {
      x.type = "text";
      ico.removeClass("fa-eye");
      ico.addClass("fa-eye-slash");
    } else {
      x.type = "password";
      ico.removeClass("fa-eye-slash");
      ico.addClass("fa-eye");
    }
  });
});
</script>

</head>
<body>

<div class="container">
<div class="row">


<div class="col-sm-12 col-md-8 col-lg-6 mx-auto my-auto">
	<div class="jumbotron text-center mt-5 bg-transparent">
		<h3> Reset Your Password </h3>
			<p class="lead"><strong></strong>
			Add your new password below and tap/click Reset My Password </p>

			<hr>

			<?php 
			
				if(isset($errorMessage)){
					echo "<div class='alert alert-danger text-center'>" . $errorMessage . "</div>";
				}

			?>
	<form method="POST" name="resetPassword" autocomplete="off">

		<div class="form-group">
			<label for="password"> New Password </label>
			<div class="input-group mb-3">
				<input id="password" class="form-control form-control" id="new-user-password" name="newUserPassword" maxlength="32" type="password">
				<div class="input-group-append">
					<span id="showPassword" class="input-group-text"><i class="fa fa-eye"></i></span>
				</div>
			</div>
		</div>

		<div class="form-group">
			<label for="orderid"> Confirm New Password </label>
			<input class="form-control form-control" id="new-user-pasword-confirm" name="newUserPasswordConfirm" type="password">
		</div>

		<div class="form-group">
			<button id="reset-password" type="submit" class="btn btn-success btn-block"> Reset My Password </button>
		</div>
	</form>
	</div>
</div>

</div>
</div>

</body>

</html>
<?php

include "config.php";
if(isset($_POST["email"]))
{
	$data=array(
		"Email"=>$_POST['email'],
		"Password"=>$_POST['password'],
		"DeviceID"=>$_POST["deviceid"],
		"DeviceName"=>$_POST["devicename"],
		"Longitude"=>$_POST["longitude"],
		"Latitude"=>$_POST["latitude"]
	);
	
	$httpData = http_build_query($data);
	$ch = curl_init($apiBaseUrl.'Account/Login');                                                                      
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
	curl_setopt($ch, CURLOPT_POSTFIELDS, $httpData);                                                                  
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);	
	curl_setopt($ch, CURLOPT_CAINFO, getcwd() . $certPath);	
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
		'Content-Type: application/x-www-form-urlencoded',                                                                                
		'Content-Length: ' . strlen($httpData))                                                                       
	);
	
	$result = curl_exec($ch);
	curl_close($ch);

	if(strlen($result)>0){//verify we have a result
		$jsonResult = json_decode($result);
		$jsonResult = $jsonResult->data;

		if(isset($jsonResult->tokenContentResponse->access_token)){	//check that user has role to access this service
				session_start();
				$_SESSION["token"] = $jsonResult->tokenContentResponse->access_token;
				$_SESSION["fullName"] = $jsonResult->tokenContentResponse->fullName;
				$_SESSION["lastLogin"] = $jsonResult->tokenContentResponse->lastLogin;

				header("Location: securityquestions.php");

		}else if(isset($jsonResult->tokenContentResponse->error)){//if we have a login error output to the user
			$error = $jsonResult->tokenContentResponse->error_description;

		}else{
			$error = "Insufficient Login Privileages";
		}        
	}else{
		$error = "Something went wrong, try again";
	}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>E-Pay Merchant Services</title>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
	<link rel="stylesheet" href="css/bootstrap.min.custom.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script> 
	$(document).ready(function(){
		$("#login").click(function(){
			if($("#loc-lat").val() == 0 || $("#loc-long").val() == 0){
				//alert("Location is required to continue");
				//getLocation();
				return false;
			}else{
				$("#login-form").submit();
			}
		});

		$("#device-id").val();
		$("#device-name").val(navigator.platform);

		function getLocation() {
			if (navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(showPosition);
			} else {
				alert("Your browser does not support geolocation");
			}
		}

		function showPosition(position) {
			$("#loc-lat").val(position.coords.latitude);
			$("#loc-long").val(position.coords.longitude); 
		}
	});


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
<body class="">
<div class="container h-100 pt-5">
	<div class="row h-100 d-flex justify-content-center">
		<div class="col-sm-10 col-md-6 col-lg-6">
		
			<div class="card bg-white border-0">
				<div class="card-body">
				<div class=" text-center">
				<!--<img src="images/logo-epay-full.png" width="100" alt="E-Pay logo"/>-->
				<p><h4> E-Pay Account Security Registration </h4></p>
				<p class="text-muted"> Welcome back, login to continue </p>
			</div>

			<?php
				if(isset($error)){
					echo "<div class='alert alert-danger text-center'>" . $error . "</div>";
				}
			?>
					<form id="login-form" autocomplete="off" action="index.php"  method="POST">
					
						<input type="hidden" id="device-id" name="deviceid" value="12345678">
						<input type="hidden" id="device-name" name="devicename" value="computer">
						<input type="hidden" id="loc-lat" name="latitude" value="13.2319831903">
						<input type="hidden" id="loc-long" name="longitude" value="-59.2138025009">

						<div class="form-group">
							<label for="number"> Username </label>
							<input class="form-control" id="email" type="text" name="email" autocomplete="username email" placeholder="" required>
						</div>

						<div class="form-group">
                            <label for="password"> Password </label>
                                <div class="input-group">
									<input class="form-control" id="password" type="password" name="password" autocomplete="new-password" placeholder="" required>
                                    <div class="input-group-append">
										<span id="showPassword" class="input-group-text"><i class="fa fa-eye"></i></span>
                                    </div>
                                </div>
                            </div>

						<div class="form-group">
							<button id="login" type="submit" class="btn btn-success btn-block"> Login </button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>

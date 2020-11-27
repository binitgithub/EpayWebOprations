<?php
	include "include/config.php";

	session_start();

	if(isset($_GET["id"]) && isset($_GET["token"])){
		
		$data = array(
				UserId=>$_GET["id"],
				EmailConfirmationToken=>$_GET["token"],
			);
		
		$jsonData = json_encode($data);
		$ch = curl_init($apiBaseUrl.'Account/ConfirmEmail');
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); 
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
		if($jsonPostResult == "Email Confirmation Successful"){
			$success = true;
		}
		else if($jsonPostResult == "Email Already Confirmed"){
			$success = false;
			$emailAlreadyConfirmed = true;
			//$message=$jsonPostResult->Errors[0];
		}else{
			$success = false;
		}
	}
?>
<!DOCTYPE html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

<!--STYLES FOR UI UPDATE -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans">
<link rel="stylesheet" href="assets/css/bootstrap.min.custom.css">
<link rel="stylesheet" href="assets/css/custom.css">
<!-- END UI UPDATE STYLES -->

</head>
<body class="simple-web-page">

<div class="container">
<div class="row">


<div class="col-sm-12 col-md-8 col-lg-6 mx-auto my-auto">
	<div class="jumbotron text-center mt-5 bg-transparent">
	<?php if($success){ ?>
		<h3 class="text-center text-success"> <i class="fa fa-4x fa-fw fa-check-circle"></i> </h3>
			<hr>
		<h3> Email Confirmed </h3>
			<p class="lead">

			<strong> What Next? </strong> 
			<br/> Sign in to E-Pay on your mobile device to top up your mobile, pay bills, make point of sale payments and more.
			</p>

<?php  }else if($emailAlreadyConfirmed){ ?>
		<h3 class="text-center text-danger"> <i class="fa fa-3x fa-fw fa-exclamation-circle"></i> </h3>
			<hr>
		<h3> Email Already Confirmed </h3>
			<p class="lead"><strong></strong>
			Your email has already been confirmed, try signing in to E-Pay to get started. </p>

<?php }else{ ?>
	<h3 class="text-center text-danger"> <i class="fa fa-3x fa-fw fa-exclamation-circle"></i> </h3>
			<hr>
		<h3> Email Confirmation Failed </h3>
			<p class="lead"><strong></strong>
			Your activation link may have expired, try signing in to E-Pay to get a new link. </p>
	<?php } ?>
	</div>
</div>


</div>
</div>

</body>

</html>
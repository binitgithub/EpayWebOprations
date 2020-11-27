<?php
session_start();
include "config.php";


if(!isset($_SESSION["token"])){
    header("location:".$baseUrl);
}

$ch = curl_init($apiBaseUrl.'PIN/Check');                                                                      
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");                                                                                                                                      
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);	
curl_setopt($ch, CURLOPT_CAINFO, getcwd() . $certPath);	
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
    'Authorization: Bearer ' . $_SESSION["token"])
);

$result = curl_exec($ch);
curl_close($ch);

if(strlen($result)>0){//verify we have a result
    $jsonResult = json_decode($result);
    
    if($jsonResult->status && $jsonResult->message == "PIN Exists"){
        header("location: alreadyregistered.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>E-Pay Mobile Payment App</title>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">

    <style>
     .error{
         border-color:red;
     }
    </style>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script> 
        var token = "<?php echo $_SESSION["token"]; ?>";
        var apiBaseUrl = "<?php echo $apiBaseUrl; ?>";
    </script>
    
</head>

<body class="">
<div class="container h-100 pt-5 pb-5">
	<div class="row h-100 d-flex justify-content-center">
		<div class="col-sm-10 col-md-6 col-lg-6">
		
			<div class="card bg-white border-0">
				<div class="card-body">
				<div class=" text-center mb-5">
                <p><h4> Add Your Security PIN </h4></p>
                <p class="text-muted"> Create a pin to use when confirming actions in the app, this pin helps to keep you safe from any unauthorized transactions when using E-Pay </p>
                
            </div>

			<?php
				if(isset($error)){
					echo "<div class='alert alert-danger text-center'>" . $error . "</div>";
				}
			?>
				<form id="registerpin" autocomplete="off" action="registerpin.php"  method="POST">
                        <h6> Enter PIN </h6>
                        <p class="text-danger">Pins such as 9999, 1212, 2000, 1004, 1234 are not allowed</p>
                        <div class="form-group mb-2">
							<input class="form-control" id="pin" type="text" name="pin" placeholder="PIN" required>
						</div>

                        <div class="form-group">
							<input class="form-control" id="confirmpin" type="text" name="confirmpin" placeholder="Confirm PIN">
						</div>
                        <div id="errortext" class="alert alert-warning" role="alert">
                        
                        </div>

                        <button type="submit" id="submitbutton" class="btn btn-block btn-success"> Continue </button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- SETUP PIN  -->
<script> 
    var button = "#submitbutton";
	$(document).ready(function(){

        $("#errortext").hide();

        if (window.history && history.pushState) {//Disbale Broswer Back
        addEventListener('load', function() {
        history.pushState(null, null, null);
        addEventListener('popstate', function() {
                alert("You must complete the security pin to successfully complete registration");
                history.pushState(null, null, null);
            });
            });
        }
  
        $("#registerpin").on("submit", function(e){
            e.preventDefault();
            
            
            $(button).prop("disabled",true);
            
            $("#errortext").hide();
            $('#registerpin *').removeClass("error");
            
            var pin =       $("#pin").val();
            var pinConf =   $("#confirmpin").val();

            if(pin != pinConf){
                $("#errortext").text("Pins must match").fadeIn();
                $(button).removeAttr("disabled");
            }else if(pin.length != 4 && pinConf != 4 ){
                $("#errortext").text("Pins must be 4 digits only").fadeIn();
                $(button).removeAttr("disabled");
            }else if(pin == "" || pinConf == ""){
                $("#errortext").text("Add both Pin and Confirm Pin to continue").fadeIn();
                $(button).removeAttr("disabled");
            }else{
                addPin(pin, pinConf);
            }
        });
    });
    
    function addPin(pin, confirmPin){
        $.ajax({
                    url: apiBaseUrl + "PIN?Pin="+pin+"&ConfirmPIN="+confirmPin,
                    type: "POST",
                    crossDomain: true,
                    dataType: "json",
                    contentType: "application/json; charset=UTF-8",
                    beforeSend: function(xhr) {
                        xhr.setRequestHeader("Authorization", "Bearer " + token);
                    },
                    success: function(data) {
                        if (data.status) {
                            $(location).attr('href', 'success.php');
                        }else{
                            if(data.message == "A PIN has already been set."){
                                $("#errortext").text("A PIN has been previously set. Redirecting...").fadeIn();
                                setTimeout(function(){ 
                                    $(location).attr('href', 'alreadyregistered.php');
                                }, 3000);
                                
                            }else{
                                $(button).removeAttr("disabled");
                                $("#errortext").text(data.message).fadeIn(); 
                            }
                        }
                    }
                });
        }
	</script>

</body>
</html>

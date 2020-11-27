<?php
    session_start();
    include "config.php";

    if(!isset($_SESSION["token"])){
        header("location:".$baseUrl);
    }

    //Let's check if the user already has questions setup
    $ch = curl_init($apiBaseUrl.'SecurityResponse');                                                                      
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");                                                                   
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true); 
    curl_setopt($ch, CURLOPT_CAINFO, getcwd() . $certPath);	
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
        'Authorization: Bearer ' . $_SESSION["token"])
    );	

    $result = curl_exec($ch);
    $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if(strlen($result) > 0 && $status_code == "200")
    {
        $result = json_decode($result);

        if($result->status){
            if(sizeof($result->data) == 3){ //if the user already has 3 questions go to the pin setup screen
                header("location: securitypin.php");
            }else{//otherwise we let them setup their security questions

            }
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
                <p><h4> Add Your Security Questions</h4></p>
                <p class="text-muted"> The information you provide here adds another layer of security to your account, it protects you when signing in and completing transactions </p>
			</div>

			<?php
				if(isset($error)){
					echo "<div class='alert alert-danger text-center'>" . $error . "</div>";
				}
			?>
				<form id="registerquestions" autocomplete="off" action="securityquestions.php"  method="POST">
					
                    <h6> Security Quesiton 1 </h6>
                    <select class="form-control mb-2" id="question1">
                     
                    </select>
						<div class="form-group">
							<input class="form-control" id="question1response" type="text" name="question1response" placeholder="Add Reponse" required>
						</div>

                        <h6> Security Quesiton 2 </h6>
                    <select class="form-control mb-2"  id="question2">
                        
                    </select>
                        <div class="form-group">
							<input class="form-control" id="question2response" type="text" name="question2response" placeholder="Add Reponse" required>
						</div>

                        <h6> Custom Security Quesiton </h6>
                        <div class="form-group mb-2">
							<input class="form-control" id="question3" type="text" name="question3" placeholder="Add your own question here" required>
						</div>

                        <div class="form-group">
							<input class="form-control" id="question3response" type="text" name="question3response" placeholder="Add Reponse">
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

<!-- Get Questions -->
<script> 

    var okResponseCount = 0; 
    var button = "#submitbutton";

	$(document).ready(function(){
        $("#errortext").hide();

        $.ajax({
                url: apiBaseUrl + "SecurityQuestion",
                crossDomain: true,
                dataType: "json",
                method: "GET",
                beforeSend: function(xhr) {
                    xhr.setRequestHeader("Authorization", "Bearer " + token);
                },
                success: function(data) {
                    if (data.status) {
                        data = data.data;

                        for(var i=0; i<data.length; i++){//add questions to dropdown selects
                            $("#question1").append("<option value="+data[i].SecurityQuestionId+">"+data[i].Question+"</option>");
                            $("#question2").append("<option value="+data[i].SecurityQuestionId+">"+data[i].Question+"</option>");                            
                        }

                    } else {
                        alert("Something went wrong, Please login and try again");
                    }
                },
                error: function(err) {
                    alert("Something went wrong, Please login and try again");
                },
                complete: function() {
                    
            }
        });

        $("#registerquestions").on("submit", function(e){
            e.preventDefault();
            
            
            $(button).prop("disabled",true);
            
            $("#errortext").text("Choose two different questions").hide();
            $('#registerquestions *').removeClass("error");
            
            var quesOne =       $("#question1").val();
            var quesOneResp =   $("#question1response").val();
            var quesTwo =       $("#question2").val();
            var quesTwoResp =   $("#question2response").val();
            var quesThree =     $("#question3").val();
            var quesThreeResp = $("#question3response").val();

            if(quesOne == quesTwo){
                $("#question1").addClass("error");
                $("#question2").addClass("error");
                $("#errortext").text("Choose two different questions").fadeIn();
                $(button).removeAttr("disabled");
            }else if(quesOneResp == "" || quesTwoResp == "" || quesThreeResp == "" || quesThree == ""){
                $("#errortext").text("Answer all questions before continuing").fadeIn();
                $(button).removeAttr("disabled");
            }else{
                $("#errortext").text("").fadeOut();
                okResponseCount = 0;
                addQuestion(quesOne, quesOneResp);
                addQuestion(quesTwo, quesTwoResp);
                addCustomQuestion(quesThree, quesThreeResp);
            }
        });
    });
    

    function addQuestion(question, response){
        $.ajax({
                url: apiBaseUrl + "SecurityResponse?securityQuestionId="+question+"&response="+response,
                type: "POST",
                crossDomain: true,
                dataType: "json",
                contentType: "application/json; charset=UTF-8",
                beforeSend: function(xhr) {
                    xhr.setRequestHeader("Authorization", "Bearer " + token);
                },
                success: function(data) {
                    if (data.status) {
                        okResponseCount++;
                        allQuestionsRegistered(okResponseCount);
                    }else{
                        $(button).removeAttr("disabled");
                        $("#errortext").append(data.message+"<br/>").fadeIn(); 
                    }
                }
        });
    }

    function addCustomQuestion(question, response){
        $.ajax({
                url: apiBaseUrl + "SecurityResponse/CustomQuestion?question="+question+"&response="+response,
                type: "POST",
                crossDomain: true,
                dataType: "json",
                contentType: "application/json; charset=UTF-8",
                beforeSend: function(xhr) {
                    xhr.setRequestHeader("Authorization", "Bearer " + token);
                },
                success: function(data) {
                    if (data.status) {
                        okResponseCount++;
                        allQuestionsRegistered(okResponseCount);
                    }else{
                        $(button).removeAttr("disabled");
                        $("#errortext").append(data.message+"<br/>").fadeIn(); 
                    }
                }
        });
    }

    function allQuestionsRegistered(count){
        if(count == 3){
            $(location).attr('href', 'securitypin.php');
        }
    }
	</script>

</body>
</html>

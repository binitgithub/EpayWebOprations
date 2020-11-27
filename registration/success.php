<?php
	session_start();
	session_destroy();
?>
<!DOCTYPE html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

<!--STYLES FOR UI UPDATE -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
<!-- END UI UPDATE STYLES -->

</head>
<body class="simple-web-page">

<div class="container">
<div class="row">


<div class="col-sm-12 col-md-8 col-lg-6 mx-auto my-auto">
	<div class="jumbotron text-center mt-5 bg-transparent">
		<h3 class="text-center text-success"> <i class="fa fa-4x fa-fw fa-check-circle"></i> </h3>
			<hr>
		<h3> Registration Complete </h3>
			<p class="lead">

			<strong> What Next? </strong> 
			<br/> Try Signing In to E-Pay with your account
			</p>
	</div>
</div>


</div>
</div>

<script> 
    var button = "#submitbutton";
	$(document).ready(function(){//Disable browser back button
        if (window.history && history.pushState) {
        addEventListener('load', function() {
        history.pushState(null, null, null);
        addEventListener('popstate', function() {
                history.pushState(null, null, null);
            });
            });
        }
    });
</script>

</body>

</html>
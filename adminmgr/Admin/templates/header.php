<?php 
    session_start(); 
    include "helpers/settings.php";
    include "helpers/functions.php";

    $app = new App();//Instance of MerchantApp Class
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>  
    <?php
        $default_header = "E-Pay Admin Center";
        if (isset($title)) {
            echo "E-Pay Admin Center - ".$title;
        } 
        else {
            echo $default_header;
        }
    ?>
    </title>

    <meta charset="utf-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0'/>
    <link rel="manifest" href="/manifest.json" />


    <!-- CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.custom.css">
    <link rel="stylesheet" href="assets/css/custom.css">
    <link rel="stylesheet" href="assets/css/bsadmin.css">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.0/build/css/alertify.min.css" />
    <link rel="stylesheet" href="assets/css/alertify.min.custom.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.css"/>


    <!-- JavaScript -->
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.11.0/build/alertify.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://unpkg.com/popper.js/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"        crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.4/dist/loadingoverlay.min.js"></script>
    <script src="assets/js/config.js"></script>
    <script src="assets/js/lib/bsadmin.js"></script>
    <script src="assets/js/moment.js"></script>
    <script src="assets/js/helpers.js"></script>

    <script>
        var token = "<?php echo $_SESSION["token"]; ?>";
        var businessId = "<?php echo $_SESSION["businessId"]; ?>";
        var businessName = "<?php echo $_SESSION["businessName"]; ?>";
        var apiBaseUrl = "<?php echo $apiBaseUrl; ?>";
    </script>
</head>

<body>
    <nav class="navbar navbar-light fixed-top bg-white ">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <button class="navbar-toggler">
					<span  id="toggle-menu" class="navbar-toggler-icon mr-2"></span>
                    <img src="assets/images/logo-epay.png" class="mr-2" height="24" alt="e-pay logo">
                    <span class="d-none d-md-inline-block d-lg-inline-block navbar-text text-secondary text-uppercase small">
                       E-Pay Admin Center
                    </span>
                </button> 
            </a>

            <div class="float-right text-muted">
                <span class="mr-2"> <?php echo $_SESSION["businessDisplayName"]; ?> </span>
				<a href="helpers/logout.php" class="btn btn-danger btn-sm" style="margin-top:-2px;">
					<i class="fa fa-fw fa-sign-out-alt"></i>
					Logout
				</a>
		    </div>
        </div>
    </nav>
    <nav id="menu" class="menu bg-dark scrollable-menu">
        <ul class="list-unstyled">
            <!--<li>
                <a href="" class="inactive-link"><i class="far fa-building"></i> <?php echo $_SESSION["businessDisplayName"]; ?></a>
            </li>-->

               <!-- Heading -->
               <!-- Dashboard -->
                <li><a href="" class="inactive-link bg-darker"><i class="fa fa-fw fa-qrcode"></i> Dashboard </a></li>
                <li><a href="dashboard.php"> Home </a></li>
				
               <!-- Heading -->
               <!-- Transactions -->
                <li><a href="" class="inactive-link bg-darker"><i class="fas fa-plus-square"></i> Create </a></li>
                <li><a href="createbusiness.php"> Create Business </a></li> <!-- Working -->
                <li><a href="createsadmin.php"> Create New SAdmin </a></li><!-- Working -->
                <li><a href="createbranch.php"> Create New Branch </a></li><!-- Working On -->
                <li><a href="createbusinesuser.php"> Create New Business User </a></li>
				
               <!-- Heading -->
               <!-- Transactions -->
                <li><a href="" class="inactive-link bg-darker"><i class="fas fa-plus-square"></i> Manage </a></li>
                <li><a href="updatebusiness.php"> Manage Businesses </a></li><!-- Working -->
                <li><a href="updatebusinessservice.php"> Manage Business Service </a></li><!-- Working -->
                <li><a href="updatebusinessconfig.php"> Manage Business Config </a></li>
				
        </ul>
    </nav>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">
                <?php 
                    if(isset($title)){
                    echo $title;
                    }else {
                    echo $default_header;
                    } 
                ?>
            </li>
        </ol>
    </nav>

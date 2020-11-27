<?php
//set page vars
$title = "Business Service";
//include page header
include "templates/header.php";
?>

   <main id="main" class="container-fluid pt-2 mb-5">

        <div class="row">            
        <div class="col-sm-12 col-md-12 col-lg-12 mb-5">
                <div class="card bg-white">
                    <div class="card-header bg-light">
                        <h4> Business </h4>
                    </div>

                    <div class="card-body ">
                        <br/>
                        <table id="business-list" class="table table-responsive-sm table-striped table-borderless table-hover">
                            <thead class="border-top-0">
                                <tr>
                                    <th class="border-top-0" scope="col">Businesses</th>
                                </tr>
                            </thead>
                            <tbody id="business">

                            </tbody>
                        </table>
                        <!--<a href="#" class="btn btn-success">View All</a>-->
                    </div>
                </div>
            </div>
        </div>
</main>
<script src="assets/js/updatebusinessservice.js"></script>
<?php 
    include "templates/footer.php";
?>
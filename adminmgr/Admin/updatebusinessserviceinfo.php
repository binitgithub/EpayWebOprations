<?php
//set page vars
$title = "Create Business";
//include page header
include "templates/header.php";
?>

	<main id="main" class="container-fluid pt-2 mb-5">
	<h2 id="BusinessName"></h2>
	<div id="checkboxes"></div>
        <div class="form-group">
            <button id="Reset" type="submit" class="btn btn-success"> Reset </button>
            <button id="Create" type="submit" class="btn btn-danger"> Update </button>
        </div>


		<div class="modal fade" id="edit-agent-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
					<div class="modal-header">
						<h5 id="edit-agent-modal-title" class="modal-title">Update Business</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
                <div class="modal-body">
                    <form id="update-agent-form" method="POST" autocomplete="off">
                            <div class="form-group">
                                <label for="agentid"> Are you sure you want to update this business? </label>
                            </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button id="business-submit" type="button" class="btn btn-success">Yes</button>
                </div>

            </div> 
        </div>
	</main>


<script src="assets/js/updatebusinessserviceinfo.js"></script>
<?php 
	include "templates/footer.php";
?>
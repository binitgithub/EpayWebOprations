<?php
//set page vars
$title = "Create Branch";
//include page header
include "templates/header.php";
?>
	<h2 id="BusinessName"></h2>

	<main id="main" class="container-fluid pt-2 mb-5">
		<table>
			<tr>
				<th> Branch Name :</th>
				<td><input type="text" placeholder="Bridgetown" id="Branch-Name" required></td>
			</tr>
			<tr>
				<th> Branch Description :</th>
				<td><input type="text" placeholder="The barber shop in town" id="Branch-Description" required></td>
			</tr>
			<tr>
				<th> Branch Address :</th>
				<td><input type="text" placeholder="Baxters Road" id="Branch-Address" required></td>
			</tr>
			<tr>
				<th> Longitude :</th>
				<td><input type="number" placeholder="-59.5432" id="Longitude" required></td>
			</tr>
			<tr>
				<th> Latitude :</th>
				<td><input type="number" placeholder="13.1939" id="Latitude" required></td>
			</tr>
		</table>

	</main>


        <div class="form-group">
            <button id="Reset" type="submit" class="btn btn-success"> Reset </button>
            <button id="Create" type="submit" class="btn btn-danger"> Update </button>
        </div>


		<div class="modal fade" id="edit-agent-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
					<div class="modal-header">
						<h5 id="edit-agent-modal-title" class="modal-title">Create Branch</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
                <div class="modal-body">
                    <form id="update-agent-form" method="POST" autocomplete="off">
                            <div class="form-group">
                                <label for="agentid"> Are you sure you want to Create this Branch? </label>
                            </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button id="business-submit" type="button" class="btn btn-success">Yes</button>
                </div>

            </div> 
        </div>


<script src="assets/js/createbranchinfo.js"></script>
<?php 
	include "templates/footer.php";
?>
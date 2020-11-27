<?php
//set page vars
$title = "Create Business";
//include page header
include "templates/header.php";
?>

<main id="main" class="container-fluid pt-2 mb-5">
    <table>
        <tr>
            <th>Business Name :</th>
            <td><input type="text" placeholder="Business Name" id="business-name" required></td>
        </tr>
        <tr>
            <th>Display Name :</th>
            <td><input type="text" placeholder="Display Name" id="display-name" required></td>
        </tr>
        <tr>
            <th>Abbreviated Name :</th>
            <td><input type="text" placeholder="Abbreviated Name" id="abbreviated-name" required></td>
        </tr>
        <tr>
            <th>Description :</th>
            <td><input type="text" placeholder="Description" id="description" required></td>
        </tr>
        <tr>
            <th>Country :</th>
            <td><select id="CountryName"></select></td>
        </tr>
        <tr>
            <th>Status :</th>
            <td><input type="checkbox" id="Status"></td>
        </tr>
    </table>
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
    </div>
</main>


<script src="assets/js/updatebusinessinfo.js"></script>
<?php 
include "templates/footer.php";
?>
<?php
//set page vars
$title = "Create Business";
//include page header
include "templates/header.php";
?>
<h2 id="BusinessName"></h2>

<main id="main" class="container-fluid pt-2 mb-5 ">
    <table>

        <tr>
            <th><p><b>Admin Email:</b></p></th>
            <td><p><input type="text" id="admin-email" required></p></td>
        </tr>

        <tr>
            <th><p><b>MinAccountNumberLength:</b></p></th> 
            <td><p><input type="number" id="min-acc-number-length" required></p></td>
        </tr>

        <tr>
            <th><p><b>MaxAccountNumberLength:</b></p></th> 
            <td><p><input type="number" id="max-acc-number-length" required></p></td>
        </tr>

        <tr>
            <th><p><b>Has Agents:</b></p></th> 
            <td><p><input type="checkbox" id="has-agents" required></p></td>
        </tr>

        <tr>
            <th><p><b>UsingEpayPIN:</b></p></th> 
            <td><p><input type="checkbox" id="using-epay-pin" required></p></td>
        </tr>

        <tr>
            <th><p><b>UsingUniversalPIN:</b></p></th> 
            <td><p><input type="checkbox" id="using-universal-pin" required></p></td>
        </tr>

        <tr>
            <th><p><b>BillNumberValidation:</b></p></th> 
            <td><p><input type="checkbox" id="bill-no-validation" required></p></td>
        </tr>

        <tr>
            <th><p><b>Website:</b></p></th> 
            <td><p><input type="text" id="website" required></p></td>
        </tr>

        <tr>
            <th><p><b>PhoneNumber:</b></p></th> 
            <td><p><input type="text" id="phone-number" required></p></td>
        </tr>

        <tr>
            <th><p><b>ContactEmail:</b></p></th> 
            <td><p><input type="text" id="contact-email" required></p></td>
        </tr>

        <tr>
            <th><p><b>InternalSystemName:</b></p></th> 
            <td><p><input type="text" id="internal-system-name" required></p></td>
        </tr>

        <tr>
            <th><p><b>InternalSystemBaseAddress:</b></p></th> 
            <td><p><input type="text" id="internal-system-base-address" required></p></td>
        </tr>

        <tr>
            <th><p><b>UserAccountLinkageFields:</b></p></th> 
            <td><p><input type="text" id="user-linkage-fields" required></p></td>
        </tr>

        <tr>
            <th><p><b>AccountNumberFormat:</b></p></th> 
            <td><p><input type="text" id="acc-no-format" required></p></td>
        </tr>

        <tr>
            <th><p><b>InternalAccountNames:</b></p></th> 
            <td><p><input type="text" id="internal-account-names" required></p></td>
        </tr>

        <tr>
            <th><p><b>AdditionalInfo1:</b></p></th> 
            <td><p><input type="text" id="info1" required></p></td>
        </tr>

        <tr>
            <th><p><b>AdditionalInfo2:</b></p></th> 
            <td><p><input type="text" id="info2" required></p></td>
        </tr>

        <tr>
            <th><p><b>AdditionalInfo3:</b></p></th> 
            <td><p><input type="text" id="info3" required></p></td>
        </tr>

        <tr>
            <th><p><b>AdditionalInfo4:</b></p></th> 
            <td><p><input type="text" id="info4" required></p></td>
        </tr>

        <tr>
            <th><p><b>HasTip:</b></p></th> 
            <td><p><input type="checkbox" id="has-tip" required></p></td>
        </tr>

        <tr>
            <th><p><b>TipAccountName:</b></p></th> 
            <td><p><input type="text" id="tip-account-name" required></p></td>
        </tr>

        <tr>
            <th><p><b>TipAccountNumber:</b></p></th> 
            <td><p><input type="text" id="tip-account-number" required></p></td>
        </tr>

        <tr>
            <th><p><b>TipAccountFIName:</b></p></th> 
            <td><p><input type="text" id="tip-account-fi-name" required></p></td>
        </tr>

        <tr>
            <th><p><b>TipAccountBusinessId:</b></p></th> 
            <td><p><input type="number" id="tip-account-businessid" required></p></td>
        </tr>

        <tr>
            <th><p><b>TipWalletId:</b></p></th> 
            <td><p><input type="number" id="tip-wallet-id" required></p></td>
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
                <h5 id="edit-agent-modal-title" class="modal-title">Update Business Config</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="update-agent-form" method="POST" autocomplete="off">
                    <div class="form-group">
                        <label for="agentid"> Are you sure you want to update this business' config ? </label>
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


<script src="assets/js/updatebusinessconfiginfo.js"></script>
<?php 
include "templates/footer.php";
?>
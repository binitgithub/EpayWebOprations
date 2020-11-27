var BusinessId;
var BranchName;
var BranchDescription;
var BranchAddress;
var Longitude;
var Latitude;
$(document).ready(function () {

    $.LoadingOverlay("show");//show ajax loader
    BusinessId = localStorage.getItem("businessId");
    //localStorage.removeItem("businessId");

    $.ajax({
        url: apiBaseUrl + "Business/" + BusinessId,

        crossDomain: true,
        dataType: "json",
        method: "GET",
        beforeSend: function (xhr) {
            xhr.setRequestHeader("Authorization", "Bearer " + token);
        },
        success: function (data) {
            if (data.status) {
                var info = data.data;
                $("#BusinessName").text(info.DisplayName);
            }
            else {
                alertify.warning("No business found");
            }
        },
        error: function (err) {
            alertify.error("Something went wrong, try again");
        },
        complete: function () {
            $.LoadingOverlay("hide");//hide ajax loader
        }
    });
});

$(function () {

    //EDIT AGENT (Submit Update)
    $("#Reset").click(function () {
        $("#Branch-Name").val("");
        $("#Branch-Description").val("");
        $("#Branch-Address").val("");
        $("#Longitude").val("");
        $("#Latitude").val("");
    });

    $("#Create").click(function () {
        $("#edit-agent-modal").modal("show");
    });

    //EDIT AGENT (Submit Update)
    $("#business-submit").click(function () {

        BranchName = $("#Branch-Name").val();
        BranchDescription = $("#Branch-Description").val();
        BranchAddress = $("#Branch-Address").val();
        Longitude = $("#Longitude").val();
        Latitude = $("#Latitude").val();

        var BranchDetails = {
            BusinessId: BusinessId,
            BranchName: BranchName,
            BranchDescription: BranchDescription,
            BranchAddress: BranchAddress,
            Longitude: Longitude,
            Latitude: Latitude,
        };

        BranchDetails = JSON.stringify(BranchDetails);

        $.ajax({
            url: apiBaseUrl + "AdminPortal/CreateNewBusinessBranch",
            crossDomain: true,
            dataType: "json",
            method: "POST",
            contentType: "application/json; charset=UTF-8",
            data: BranchDetails,
            beforeSend: function (xhr) {
                xhr.setRequestHeader("Authorization", "Bearer " + token);
            },
            success: function (data) {
                if (data.status) {

                    window.location.href = "dashboard.php";
                }
                else {
                    alertify.error(data.message);
                }
            },
            error: function (err) {
                alertify.error("Something went wrong <br/>");
            },
            complete: function () {
                //$('#edit-agent-modal').modal('show');
            }
        });       
        
    });

})

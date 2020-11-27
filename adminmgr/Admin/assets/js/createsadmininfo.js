var BusinessId;
var Pin;
var selectedArray = new Array();
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
        $("#pinno").val("");
    });

    $("#Create").click(function () {
        $("#edit-agent-modal").modal("show");
    });

    //EDIT AGENT (Submit Update)
    $("#business-submit").click(function () {
        Pin = $("#pin-number").val();

        console.log(Pin);

        $.ajax({
            url: apiBaseUrl + "AdminPortal/CreateNewSADMINAgent?BusinessId=" + BusinessId + "&PIN=" + Pin,
            crossDomain: true,
            dataType: "json",
            method: "POST",
            contentType: "application/json; charset=UTF-8",
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

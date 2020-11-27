var BusinessName;
var DisplayName;
var AbbreviatedName;
var Description;
var CountryId;
var BusinessId;
var Status;
$(document).ready(function () {

    $.LoadingOverlay("show");//show ajax loader
    BusinessId = localStorage.getItem("businessId");
    //    localStorage.removeItem("businessId");

    $.ajax({
        url: apiBaseUrl + "Country/Available",

        crossDomain: true,
        dataType: "json",
        method: "GET",
        beforeSend: function (xhr) {
            xhr.setRequestHeader("Authorization", "Bearer " + token);
        },
        success: function (data) {
            if (data.status) {
                var info = data.data;
                fillDropdown(info);
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

    $.ajax({
        url: apiBaseUrl + "AdminPortal/ABusiness?id=" + BusinessId,

        crossDomain: true,
        dataType: "json",
        method: "GET",
        beforeSend: function (xhr) {
            xhr.setRequestHeader("Authorization", "Bearer " + token);
        },
        success: function (data) {
            if (data.status) {
                var info = data.data;
                $("#business-name").val(info.Name);
                $("#display-name").val(info.DisplayName);
                $("#abbreviated-name").val(info.AbbreviatedName);
                $("#description").val(info.Description);
                if (info.Status == "Active") {
                    $("#Status").prop('checked', true);
                }
                else {
                    $("#Status").prop('checked', false);
                }
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
        emptyInfo();
        fillInfo();
    });

    $("#Create").click(function () {
        $("#edit-agent-modal").modal("show");
    });

    //EDIT AGENT (Submit Update)
    $("#business-submit").click(function () {

        if ($("#Status").is(':checked')){
            Status = "Active";
        }
        else {
            Status = "Inactive";
        }

        BusinessName = $("#business-name").val();
        DisplayName = $("#display-name").val();
        AbbreviatedName = $("#abbreviated-name").val();
        Description = $("#description").val();
        CountryId = $("#CountryName").val();

        var businessDetails = {
            BusinessId: BusinessId,
            Name: BusinessName,
            DisplayName: DisplayName,
            AbbreviatedName: AbbreviatedName,
            Description: Description,
            CountryId: CountryId,
            Status: Status,
        };

        businessDetails = JSON.stringify(businessDetails);

        $.ajax({
            url: apiBaseUrl + "AdminPortal/UpdateBusiness",
            crossDomain: true,
            dataType: "json",
            method: "PUT",
            contentType: "application/json; charset=UTF-8",
            data: businessDetails,
            beforeSend: function (xhr) {
                xhr.setRequestHeader("Authorization", "Bearer " + token);
            },
            success: function (data) {
                if (data.status) {
                    alertify.success("Business Updated.");

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

function fillDropdown(data) {
    $("#businessName").empty();

    for (i = 0; i < data.length; i++) {
        var country = data[i];
        $("#CountryName").append('<option value=' + country.CountryId + '>' + country.CountryName + '</option>')
        //.appendTo("#businessName")
        //.hide()
            .fadeIn(500);
    }
}

function emptyInfo() {
    var myDDL = $("#CountryName");
    $("#business-name").val("");
    $("#display-name").val("");
    $("#abbreviated-name").val("");
    $("#description").val("");
    myDDL[0].selectedIndex = 0;
}

function fillInfo() {

    $.ajax({
        url: apiBaseUrl + "AdminPortal/ABusiness?id=" + BusinessId,

        crossDomain: true,
        dataType: "json",
        method: "GET",
        beforeSend: function (xhr) {
            xhr.setRequestHeader("Authorization", "Bearer " + token);
        },
        success: function (data) {
            if (data.status) {
                var info = data.data;
                $("#business-name").val(info.Name);
                $("#display-name").val(info.DisplayName);
                $("#abbreviated-name").val(info.AbbreviatedName);
                $("#description").val(info.Description);
                if (info.Status == "Active") {
                    $("#Status").prop('checked', true);
                }
                else {
                    $("#Status").prop('checked', false);
                }
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
}
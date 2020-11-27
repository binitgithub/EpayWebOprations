var BusinessName;
var DisplayName;
var AbbreviatedName;
var Description;
var CountryId;
$(document).ready(function () {

    $.LoadingOverlay("show");//show ajax loader

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
});

$(function () {

    //EDIT AGENT (Submit Update)
    $("#Reset").click(function () {
        var myDDL = $("#CountryName");
        $("#business-name").val("");
        $("#display-name").val("");
        $("#abbreviated-name").val("");
        $("#description").val("");
        myDDL[0].selectedIndex = 0;
    });

    $("#Create").click(function () {
        $("#edit-agent-modal").modal("show");
    });

    //EDIT AGENT (Submit Update)
    $("#business-submit").click(function () {

        BusinessName = $("#business-name").val();
        DisplayName = $("#display-name").val();
        AbbreviatedName = $("#abbreviated-name").val();
        Description = $("#description").val();
        CountryId = $("#CountryName").val();

        var businessDetails = {
            Name: BusinessName,
            DisplayName: DisplayName,
            AbbreviatedName: AbbreviatedName,
            Description: Description,
            CountryId: CountryId,
        };

        businessDetails = JSON.stringify(businessDetails);

        $.ajax({
            url: apiBaseUrl + "AdminPortal/CreateNewBusiness",
            crossDomain: true,
            dataType: "json",
            method: "POST",
            contentType: "application/json; charset=UTF-8",
            data: businessDetails,
            beforeSend: function (xhr) {
                xhr.setRequestHeader("Authorization", "Bearer " + token);
            },
            success: function (data) {
                if (data.status) {
                    alertify.success("Business Created.");

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
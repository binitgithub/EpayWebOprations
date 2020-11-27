var BusinessId;
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

    $.ajax({
        url: apiBaseUrl + "FinancialInstitution/Service",

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

                fillCheckBox();




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
        //add new services
        
    });

})

function fillDropdown(data) {
    for (i = 0; i < data.length; i++) {
        var service = data[i];
        $("#checkboxes").append('<input type="checkbox" class="business-service" data-service-id=' + service.ServiceId + '>' + service.Name )
            //.appendTo("#businessName")
            //.hide()
            .fadeIn(500);
    }
}

function fillCheckBox() {

    $.ajax({
        url: apiBaseUrl + "BusinessService?businessId=" + BusinessId,
        crossDomain: true,
        dataType: "json",
        method: "GET",
        contentType: "application/json; charset=UTF-8",
        beforeSend: function (xhr) {
            xhr.setRequestHeader("Authorization", "Bearer " + token);
        },
        success: function (data) {
            if (data.status)
            {
                //checkboxes
                var servicesList = $("#checkboxes").children();
                var businessServices = data.data;
                //console.log(servicesList[1]);
                for (i = 0; i < businessServices.length; i++)
                {
                    $(".business-service").each(function () {
                        if ($(this).attr("data-service-id") == businessServices[i].ServiceId) {
                            $(this).prop('checked', true);
                        }
                    });
                }
            }
            else {
                //alertify.error(data.message);
            }
        },
        error: function (err) {
            alertify.error("Something went wrong <br/>");
        },
        complete: function () {
            //$('#edit-agent-modal').modal('show');
        }
    });
}
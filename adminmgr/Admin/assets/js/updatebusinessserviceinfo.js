var BusinessId;
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
        emptyCheckBox();
        fillCheckBox();
    });

    $("#Create").click(function () {
        $("#edit-agent-modal").modal("show");
    });

    //EDIT AGENT (Submit Update)
    $("#business-submit").click(function () {
        //add new services

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
                    for (i = 0; i < info.length; i++) {
                        var service = info[i];

                        if ($("#chk" + service.ServiceId).is(':checked')) {
                            selectedArray[selectedArray.length] = service.ServiceId;
                        }
                        
                    }
                    //console.log(selectedArray);
                }
                else {
                    alertify.warning("No services found in database");
                }
            },
            error: function (err) {
                alertify.error("Something went wrong, try again");
            },
            complete: function () {

                var businessDetails = {
                    BusinessId: BusinessId,
                    BusinessServices: selectedArray,
                };

                businessDetails = JSON.stringify(businessDetails);

                $.ajax({
                    url: apiBaseUrl + "AdminPortal/UpdateBusinessService",
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


                        $.LoadingOverlay("hide");//hide ajax loader
            }
        });


        
        
    });

})

function fillDropdown(data) {
    for (i = 0; i < data.length; i++) {
        var service = data[i];
        $("#checkboxes").append('<input type="checkbox" class="business-service" id="chk' + service.ServiceId + '" data-service-id=' + service.ServiceId + '>' + service.Name)
            //.appendTo("#businessName")
            //.hide()
            .fadeIn(500);
    }
}

function emptyCheckBox() {

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
                for (i = 0; i < info.length; i++) {
                    var service = info[i];

                    if ($("#chk" + service.ServiceId).is(':checked')) {
                        $("#chk" + service.ServiceId).prop('checked', false);
                    }

                }
                //console.log(selectedArray);
            }
            else {
                alertify.warning("No services found in database");
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
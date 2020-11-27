$(document).ready(function () {
    
    $.LoadingOverlay("show");//show ajax loader
    $.ajax({
        url: apiBaseUrl + "AdminPortal/AllBusiness",

        crossDomain: true,
        dataType: "json",
        method: "GET",
        beforeSend: function (xhr) {
            xhr.setRequestHeader("Authorization", "Bearer " + token);
        },
        success: function (data) {
            if (data.status) {
                var info = data.data;
                addTableData(info);

                $("#business-list").DataTable({
                    "aaSorting": [[0, "asc"]]
                });
            }
            else {
                alertify.warning("No businesses found");
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

    $(document).on("click", "td", function () {
        var id = $(this).attr("data-business-id");
        localStorage.setItem("businessId", id);
        window.location.href = "updatebusinessserviceinfo.php";
    });

function addTableData(data) {
    $("#business").empty();

    for (i = 0; i < data.length; i++) {
        var business = data[i];
        $("<tr></tr>")
            .append(
            $("<td></td>").text(business.Name)
                .addClass("business-info-link")
                .attr("data-business-id", business.BusinessId)
            )
            .appendTo("#business")
            //.hide()
            .fadeIn(500);
    }
}

function sortTableData(row) {
    if ($.fn.dataTable.isDataTable('#business-list')) {
        table = $('#example').DataTable();
    }
    else {
        table = $('#example').DataTable({
            paging: false
        });
    }
}

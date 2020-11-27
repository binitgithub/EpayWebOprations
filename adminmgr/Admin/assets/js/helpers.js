function createCsvDownloadSummary(transfersList) {
    var headers = {
        BusinessId: "BusinessId",
        Name: "BusinessName",
        TransactionCount: "Transaction Count",
        TransactionTotal: "Transaction Total"
    };

    var transfersListFormat = [];
    console.log(transfersList);
    
        transfersListFormat.push({
            BusinessId: transfersList.BusinessId,
            Name: transfersList.Name,
            TransactionCount: transfersList.TransactionCount,
            TransactionTotal: transfersList.TransactionTotal
        });

    //console.log(transfersListFormat);
    var currentdate = new Date();
    var fileTitle =
        "TransfersAsOf" +
        currentdate.getDate() +
        "" +
        (currentdate.getMonth() + 1) +
        "" +
        currentdate.getFullYear() +
        "Time" +
        currentdate.getHours() +
        "" +
        currentdate.getMinutes();
    //"_" +
    //currentdate.getSeconds(); // or 'my-unique-title'

    exportCSVFile(headers, transfersListFormat, fileTitle); // call the exportCSVFile() function to process the JSON and trigger the download
}

function createCsvDownloadLooped(transfersList) {
    var headers = {
        Created: "Created",
        SourceAccount: "SourceAccount",
        Description: "Description",
        BusinessAccount: "BusinessAccount",
        Amount: "Amount",
        Status: "Status"
    };

    var transfersListFormat = [];
    console.log(transfersList);

    transfersList.forEach(item => {
        transfersListFormat.push({
            Created: item.Created.substring(0, 16).replace("T", " @ "),
            SourceAccount: item.SourceAccountId,
            Description: item.TransactionDescription,
            BusinessAccount: item.ReceiverAccountNumber, 
            Amount: item.Amount.toFixed(2),
            Status: item.Status 
        });
    });

    //console.log(transfersListFormat);
    var currentdate = new Date();
    var fileTitle =
        "TransfersAsOf" +
        currentdate.getDate() +
        "" +
        (currentdate.getMonth() + 1) +
        "" +
        currentdate.getFullYear() +
        "Time" +
        currentdate.getHours() +
        "" +
        currentdate.getMinutes();
    //"_" +
    //currentdate.getSeconds(); // or 'my-unique-title'

    exportCSVFile(headers, transfersListFormat, fileTitle); // call the exportCSVFile() function to process the JSON and trigger the download
}

function convertToCSV(objArray) {
    var array = typeof objArray != "object" ? JSON.parse(objArray) : objArray;
    var str = "";

    for (var i = 0; i < array.length; i++) {
        var line = "";
        for (var index in array[i]) {
            if (line != "") line += ",";

            line += array[i][index];
        }

        str += line + "\r\n";
    }

    return str;
}

function exportCSVFile(headers, items, fileTitle) {
    if (headers) {
        items.unshift(headers);
    }

    // Convert Object to JSON
    var jsonObject = JSON.stringify(items);

    var csv = this.convertToCSV(jsonObject);

    var exportedFilenmae = fileTitle + ".csv" || "export.csv";

    var blob = new Blob([csv], { type: "text/csv;charset=utf-8;" });
    if (navigator.msSaveBlob) {
        // IE 10+
        navigator.msSaveBlob(blob, exportedFilenmae);
    } else {
        var link = document.createElement("a");
        //var link = document.getElementById("download");
        if (link.download !== undefined) {
            // feature detection
            // Browsers that support HTML5 download attribute
            var url = URL.createObjectURL(blob);
            link.setAttribute("href", url);
            link.setAttribute("download", exportedFilenmae);
            link.style.visibility = "hidden";
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    }
}

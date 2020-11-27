$(document).ready(function() {

    var now = new Date();

    year = now.getFullYear().toString();
    month = now.getMonth().toString(); 
    date = now.getDate().toString();

    var something = new Date(year, month, date);
    something.setMonth(something.getMonth() + 1);// Add +1 because month starts at 0

    newyear = something.getFullYear().toString();
    newmonth = something.getMonth().toString();
    newdate = something.getDate().toString();

  $.LoadingOverlay("show");//show ajax loader
    $.ajax({
        url: apiBaseUrl + "FinancialInstitution/TransactionCount?sourceInstitution=" + businessId + "&year="+newyear+"&month="+newmonth + "&day=" + newdate,

    crossDomain: true,
    dataType: "json",
    method: "GET",
    beforeSend: function(xhr) {
      xhr.setRequestHeader("Authorization", "Bearer " + token);
    },
        success: function (data) {
        if (data.status) {
            var info = data.data;
            $("#day-data").text(info.todayCount);
            $("#month-data").text(info.monthCount);
            $("#year-data").text(info.yearCount);
      }
    },
    error: function(err){
      alertify.error(data.message);
    },
    complete: function(){
      $.LoadingOverlay("hide");//hide ajax loader
    }
  });
});

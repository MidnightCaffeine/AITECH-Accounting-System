$(document).ready(function () {

    $.ajax({
        url: "lib/dashboard/check_balance.php",
        method: "POST",
        data: {
            fetch: "1",
        },
        dataType: "json",
        success: function (data) {
            $("#peso").text(data[0].phpBalance);
            $("#usd").text(data[1].usdBalance);
        },
    });

    $("#activity").load("lib/log/fetch_log.php");


});

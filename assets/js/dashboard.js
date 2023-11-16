$(document).ready(function () {
    $.ajax({
        url: "lib/dashboard/check_balance.php",
        method: "POST",
        data: {
            fetch: "123",
        },
        dataType: "json",
        success: function (data) {
            $("#peso").text(data[0].phpBalance);
            $("#usd").text(data[1].usdBalance);
        },
    });

    $("#activity").load("lib/log/fetch_log.php");
    $("#near_deadline").load("lib/dashboard/check_upcoming_deadline.php");

    $(document).on("click", ".view", function () {
        var fees_id = $(this).attr("id");
        var year_include = $(this).attr("name");

        $("#view_students").modal("show");
    
        $( "#unpaid_students" ).load( "lib/dashboard/check_unpaid_students.php", { "datas[]": [ fees_id, year_include ] } );
    });

});

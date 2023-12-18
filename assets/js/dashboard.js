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

    $("#activity").load("lib/dashboard/fetch_log.php");
    $("#near_deadline").load("lib/dashboard/check_upcoming_deadline.php");

    $(document).on("click", ".view", function () {
        var fees_id = $(this).attr("id");
        var year_include = $(this).attr("name");

        $("#view_students").modal("show");
        console.log("clicked");
    
        // $( "#unpaid_students" ).load( "lib/dashboard/check_unpaid_students.php", { "datas[]": [ fees_id, year_include ] } );
        $( "#freshman_table" ).load( "lib/dashboard/unpaid_freshman.php", { "datas[]": [ fees_id, year_include ] } );
        $( "#sophomore_table" ).load( "lib/dashboard/unpaid_sophomore.php", { "datas[]": [ fees_id, year_include ] } );
        $( "#junior_table" ).load( "lib/dashboard/unpaid_junior.php", { "datas[]": [ fees_id, year_include ] } );
        $( "#senior_table" ).load( "lib/dashboard/unpaid_senior.php", { "datas[]": [ fees_id, year_include ] } );
        $( "#irregular_table" ).load( "lib/dashboard/unpaid_irreg.php", { "datas[]": [ fees_id, year_include ] } );
    });

});

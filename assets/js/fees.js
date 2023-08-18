$(document).ready(function() {
    $('#addFeesForm').submit(function(event) {
        event.preventDefault();

        var fees_title = $('#fees_title').val();
        var fees_details = $('#fees_details').val();
        var fees_year = $('#fees_year').val();
        var fees_cost = $('#fees_cost').val();
        var deadline = $('#deadline').val();
        var add_fees = $('#add_fees').val();

        $(".form-message").load("lib/fees/add_fees.php", {
            fees_title: fees_title,
            feed_details: feed_details,
            fees_year: fees_year,
            fees_cost: fees_cost,
            deadline: deadline,
            add_fees: add_fees

        });
    });
});

<?php
require_once '../databaseHandler/connection.php';

if (isset($_POST['cost'])) {

    $fees_id = $_POST['fees_id'];
    $student_id =  $_POST['student_id'];
    $fullname = $_POST['fullname'];
    $section = $_POST['section'];
    $year_level =  $_POST['year_level'];
    $deadline = strtotime($_POST['date']);
    $date = date('Y-m-d', $deadline);
    $cost = $_POST['cost'];
    $status = 1;

    $insert = $pdo->prepare("INSERT INTO payment_list(fees_id, student_id, fullname, section, year_level, date, status, cost) VALUES(:fees_id, :student_id, :fullname, :section, :year_level, :dates, :stats, :cost)");

    $insert->bindparam('fees_id', $fees_id);
    $insert->bindparam('student_id', $student_id);
    $insert->bindparam('fullname', $fullname);
    $insert->bindparam('section', $section);
    $insert->bindparam('year_level', $year_level);
    $insert->bindparam('dates', $date);
    $insert->bindparam('stats', $status);
    $insert->bindparam('cost', $cost);

    $insert->execute();
}

?>

<script>
    var myModalEl = document.getElementById('newPayment');
    var modal = bootstrap.Modal.getInstance(myModalEl)
    modal.hide();

    Swal.fire({
        title: "Payment Successful!",
        text: "Your payment has been sent",
        icon: "success",
        timer: 2000,
        timerProgressBar: true,
        showConfirmButton: false
    });
    setTimeout(function() {
        location.reload();
    }, 2000);
</script>
<?php
require_once '../databaseHandler/connection.php';
session_start();

date_default_timezone_set('Asia/Manila');
$d = date("Y-m-d");

if (isset($_POST['fees_id'])) {

    $fees_id = $_POST['fees_id'];
    $student_id = $_SESSION['student_id'];
    $fullname = $_POST['fullname'];
    $section = $_POST['section'];
    $year_level =  $_POST['year_level'];
    $cost = $_POST['cost'];
    $reference_id = $_POST['reference_id'];
    $amount_cost = $_POST['amount_cost'];
    $status = 1;
    $type = 3;

    $get_fees = $pdo->prepare(
        "SELECT * FROM fees_list WHERE fees_id = '$fees_id'"
    );
    $get_fees->execute();
    while ($row = $get_fees->fetch(PDO::FETCH_ASSOC)) {
        $fees_title = $row['fees_title'];
    }

    $action = 'Payed ' . $cost . ' for ' . $fees_title . '  reference number: ' . $reference_id;

    $select = $pdo->prepare("SELECT * FROM payment_list WHERE fees_id = '$fees_id' AND student_id = '$student_id'");
    $select->execute();
    $result = $select->fetchAll();

    if (empty($result)) {

        $total_balance = $amount_cost - $cost;
        if ($total_balance > 0) {
            $status = 2;
        }

        $insert = $pdo->prepare("INSERT INTO payment_list(fees_id, student_id, fullname, section, year_level, date, status, cost, reference) VALUES(:fees_id, :student_id, :fullname, :section, :year_level, :date , :stats, :cost, :reference)");

        $insert->bindparam('fees_id', $fees_id);
        $insert->bindparam('student_id', $student_id);
        $insert->bindparam('fullname', $fullname);
        $insert->bindparam('section', $section);
        $insert->bindparam('year_level', $year_level);
        $insert->bindparam('date', $d);
        $insert->bindparam('stats', $status);
        $insert->bindparam('cost', $cost);
        $insert->bindparam('reference', $reference_id);

        if ($insert->execute()) {
            $insertLog = $pdo->prepare("INSERT INTO logs(user_id, user_email, action, type) values(:id, :user, :action, :type)");

            $insertLog->bindParam(':id', $_SESSION['myid']);
            $insertLog->bindParam(':user', $_SESSION['userEmail']);
            $insertLog->bindParam(':action', $action);
            $insertLog->bindParam(':type', $type);
            $insertLog->execute();
        }
    } else {

        $select = $pdo->prepare("SELECT * FROM payment_list WHERE fees_id = '$fees_id' AND student_id = '$student_id'");
        $select->execute();
        while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
            $payment_id = $row['payment_id'];
            $stats = $row["status"];
            $amount = $row["cost"];
        }

        if ($stats != 1) {
            $total_payment = $amount + $cost;
            $total_balance = $amount_cost - $total_payment;

            if ($total_balance > 0) {
                $update = $pdo->prepare("UPDATE `payment_list` SET `cost` = '$total_payment', `date` = '$d'  WHERE `payment_id` = '$payment_id'");
            } else {
                $update = $pdo->prepare("UPDATE `payment_list` SET `cost` = '$total_payment' , `status` = '$status', `date` = '$d'  WHERE `payment_id` = '$payment_id'");
            }
            if ($update->execute()) {
                $insertLog = $pdo->prepare("INSERT INTO logs(user_id, user_email, action, type) values(:id, :user, :action, :type)");

                $insertLog->bindParam(':id', $_SESSION['myid']);
                $insertLog->bindParam(':user', $_SESSION['userEmail']);
                $insertLog->bindParam(':action', $action);
                $insertLog->bindParam(':type', $type);
                $insertLog->execute();
            }
        }
    }
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
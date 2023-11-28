<?php

use PHPMailer\PHPMailer\PHPMailer;

require_once '../databaseHandler/connection.php';
session_start();

require_once 'PHPMailer/src/Exception.php';
require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';

date_default_timezone_set('Asia/Manila');
$d = date("Y-m-d");

$mail = new PHPMailer(true);

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
        $description = $row['fees_description'];
    }

    $recipient = $_SESSION['userEmail'];
    $subject = 'Successful Payment For ' . $fees_title;

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

        try {
            $mail->IsSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = true;

            $mail->Username = "midnightcoffee014@gmail.com";
            $mail->Password = "tpgcshdmagysdbla";
            $mail->SMTPSecure = 'tls';
            $mail->Port = '587';

            $mail->SetFrom('midnightcoffee014@gmail.com');
            $mail->AddAddress($recipient);

            $mail->IsHTML(true);
            $mail->Subject = $subject;

            $mail->Body = '<body data-new-gr-c-s-loaded="14.1141.0" style="width: 100%; font-family: open sans, helvetica neue, helvetica, arial, sans-serif; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; padding: 0; margin: 0;"><div dir="ltr" class="es-wrapper-color" lang="en" style="background-color: #eeeeee"><table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0px;padding: 0;margin: 0;width: 100%;height: 100%;background-repeat: repeat;background-position: center top;background-color: #eeeeee;"><tr style="border-collapse: collapse"><td valign="top" style="padding: 0; margin: 0"><table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0px;table-layout: fixed !important;width: 100%;"><tr style="border-collapse: collapse"></tr> <tr style="border-collapse: collapse"><td align="center" style="padding: 0; margin: 0"><table class="es-header-body" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0px;background-color: #FDA63A;width: 600px;" cellspacing="0" cellpadding="0" bgcolor="#044767" align="center"><tr style="border-collapse: collapse"><td align="left" style="margin: 0;padding-top: 35px;padding-left: 35px;padding-right: 35px;padding-bottom: 40px;"><table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0px;"><tr style="border-collapse: collapse"><td valign="top" align="center" style="padding: 0; margin: 0; width: 530px"><table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0px;"><tr style="border-collapse: collapse">   <td class="es-m-txt-c" align="center" style="padding: 0; margin: 0"><h1 style="margin: 0;line-height: 36px;mso-line-height-rule: exactly;font-family: open sans, helvetica neue,helvetica, arial, sans-serif;font-size: 36px;font-style: normal;font-weight: bold;color: #ffffff;">AITECHS</h1></td></tr></table></td></tr></table></td></tr></table></td></tr></table><table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0px;table-layout: fixed !important;width: 100%;"><tr style="border-collapse: collapse"><td align="center" style="padding: 0; margin: 0"><table class="es-content-body" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0px;background-color: #ffffff;width: 600px;"><tr style="border-collapse: collapse"><td align="left" style="margin: 0;padding-bottom: 25px;padding-top: 35px;padding-left: 35px;padding-right: 35px;"><table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0px;"><tr style="border-collapse: collapse"><td valign="top" align="center" style="padding: 0; margin: 0; width: 530px"><table width="100%" cellspacing="0" cellpadding="0"  style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0px;"><tr style="border-collapse: collapse"><td align="left" style="padding: 0;margin: 0;padding-bottom: 5px;padding-top: 20px;"><h3 style="margin: 0;line-height: 22px;mso-line-height-rule: exactly;font-family: open sans, helvetica neue,helvetica, arial, sans-serif;font-size: 18px;font-style: normal;font-weight: bold;color: #333333;">Hello ' . $fullname . ',<br /></h3></td></tr><tr style="border-collapse: collapse"><td align="left" style="padding: 0;margin: 0;padding-bottom: 10px;padding-top: 15px;">   <p style="margin: 0;-webkit-text-size-adjust: none;-ms-text-size-adjust: none;mso-line-height-rule: exactly;font-family: open sans, helvetica neue,helvetica, arial, sans-serif;line-height: 24px;color: #777777;font-size: 16px;"><i></i>This letter acknowledges the payment for ' . $fees_title . ', Reference No. ' . $reference_id . ' and Amount Rs. ' . $cost . ' Pesos.<i></i></p></td></tr><tr style="border-collapse: collapse"><td align="left" style="padding: 0;margin: 0;padding-top: 5px;"><p style="margin: 0;-webkit-text-size-adjust: none;-ms-text-size-adjust: none;mso-line-height-rule: exactly;font-family: open sans, helvetica neue,helvetica, arial, sans-serif;     line-height: 24px;color: #777777;font-size: 16px;" >We are committed to providing you with the best possible solutions and ensuring that you have a positive experience with our system. Thank you for your continued support, and we look forward to serving you in the future. </p></td> </tr></table></td></tr></table>    </td></tr></table></td></tr></table><table cellpadding="0" cellspacing="0" class="es-footer"align="center" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0px;table-layout: fixed !important;width: 100%;background-color: transparent;background-repeat: repeat;      background-position: center top;"><tr style="border-collapse: collapse"><td align="center" style="padding: 0; margin: 0"><table  class="es-footer-body"  cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0px;    background-color: #ffffff;width: 600px;"><tr style="border-collapse: collapse"><td align="left"style="margin: 0;padding-top: 35px;padding-left: 35px;padding-right: 35px;padding-bottom: 40px;"><table width="100%"cellspacing="0"cellpadding="0"style="  mso-table-lspace: 0pt;  mso-table-rspace: 0pt;  border-collapse: collapse;  border-spacing: 0px;"><tr style="border-collapse: collapse"><td valign="top" align="center" style="padding: 0; margin: 0; width: 530px"><table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0px;"><tr style="border-collapse: collapse"><td align="center" style="padding: 0;margin: 0;padding-bottom: 15px;font-size: 0;"></td></tr><tr style="border-collapse: collapse"><td align="center" style="padding: 0;margin: 0;padding-bottom: 35px;"> <p style="margin: 0;-webkit-text-size-adjust: none;-ms-text-size-adjust: none;mso-line-height-rule: exactly;font-family: open sans, helvetica neue,helvetica, arial, sans-serif;line-height: 21px;color: #333333;font-size: 14px;   " >   <b>School of Information Technology</b> </p> <p style="margin: 0;-webkit-text-size-adjust: none;-ms-text-size-adjust: none;mso-line-height-rule: exactly;font-family: open sans, helvetica neue,helvetica, arial, sans-serif;line-height: 21px;color: #333333;font-size: 14px;" ><b></b><b></b>AITECHS Accounting System<br/></p></td></tr></table></td></tr></table></td></tr></table></td></tr></table></td></tr></table></div></body>';

            $mail->send();
        } catch (Exception $e) {

            echo $mail->ErrorInfo;
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

        try {
            $mail->IsSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = true;

            $mail->Username = "midnightcoffee014@gmail.com";
            $mail->Password = "tpgcshdmagysdbla";
            $mail->SMTPSecure = 'tls';
            $mail->Port = '587';

            $mail->SetFrom('midnightcoffee014@gmail.com');
            $mail->AddAddress($recipient);

            $mail->IsHTML(true);
            $mail->Subject = $subject;

            $mail->Body = '<body data-new-gr-c-s-loaded="14.1141.0" style="width: 100%; font-family: open sans, helvetica neue, helvetica, arial, sans-serif; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; padding: 0; margin: 0;"><div dir="ltr" class="es-wrapper-color" lang="en" style="background-color: #eeeeee"><table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0px;padding: 0;margin: 0;width: 100%;height: 100%;background-repeat: repeat;background-position: center top;background-color: #eeeeee;"><tr style="border-collapse: collapse"><td valign="top" style="padding: 0; margin: 0"><table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0px;table-layout: fixed !important;width: 100%;"><tr style="border-collapse: collapse"></tr> <tr style="border-collapse: collapse"><td align="center" style="padding: 0; margin: 0"><table class="es-header-body" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0px;background-color: #FDA63A;width: 600px;" cellspacing="0" cellpadding="0" bgcolor="#044767" align="center"><tr style="border-collapse: collapse"><td align="left" style="margin: 0;padding-top: 35px;padding-left: 35px;padding-right: 35px;padding-bottom: 40px;"><table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0px;"><tr style="border-collapse: collapse"><td valign="top" align="center" style="padding: 0; margin: 0; width: 530px"><table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0px;"><tr style="border-collapse: collapse">   <td class="es-m-txt-c" align="center" style="padding: 0; margin: 0"><h1 style="margin: 0;line-height: 36px;mso-line-height-rule: exactly;font-family: open sans, helvetica neue,helvetica, arial, sans-serif;font-size: 36px;font-style: normal;font-weight: bold;color: #ffffff;">AITECHS</h1></td></tr></table></td></tr></table></td></tr></table></td></tr></table><table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0px;table-layout: fixed !important;width: 100%;"><tr style="border-collapse: collapse"><td align="center" style="padding: 0; margin: 0"><table class="es-content-body" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0px;background-color: #ffffff;width: 600px;"><tr style="border-collapse: collapse"><td align="left" style="margin: 0;padding-bottom: 25px;padding-top: 35px;padding-left: 35px;padding-right: 35px;"><table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0px;"><tr style="border-collapse: collapse"><td valign="top" align="center" style="padding: 0; margin: 0; width: 530px"><table width="100%" cellspacing="0" cellpadding="0"  style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0px;"><tr style="border-collapse: collapse"><td align="left" style="padding: 0;margin: 0;padding-bottom: 5px;padding-top: 20px;"><h3 style="margin: 0;line-height: 22px;mso-line-height-rule: exactly;font-family: open sans, helvetica neue,helvetica, arial, sans-serif;font-size: 18px;font-style: normal;font-weight: bold;color: #333333;">Hello ' . $fullname . ',<br /></h3></td></tr><tr style="border-collapse: collapse"><td align="left" style="padding: 0;margin: 0;padding-bottom: 10px;padding-top: 15px;">   <p style="margin: 0;-webkit-text-size-adjust: none;-ms-text-size-adjust: none;mso-line-height-rule: exactly;font-family: open sans, helvetica neue,helvetica, arial, sans-serif;line-height: 24px;color: #777777;font-size: 16px;"><i></i>This letter acknowledges the payment for ' . $fees_title . ', Reference No. ' . $reference_id . ' and Amount Rs. ' . $cost . ' Pesos.<i></i></p></td></tr><tr style="border-collapse: collapse"><td align="left" style="padding: 0;margin: 0;padding-top: 5px;"><p style="margin: 0;-webkit-text-size-adjust: none;-ms-text-size-adjust: none;mso-line-height-rule: exactly;font-family: open sans, helvetica neue,helvetica, arial, sans-serif;     line-height: 24px;color: #777777;font-size: 16px;" >We are committed to providing you with the best possible solutions and ensuring that you have a positive experience with our system. Thank you for your continued support, and we look forward to serving you in the future. </p></td> </tr></table></td></tr></table>    </td></tr></table></td></tr></table><table cellpadding="0" cellspacing="0" class="es-footer"align="center" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0px;table-layout: fixed !important;width: 100%;background-color: transparent;background-repeat: repeat;      background-position: center top;"><tr style="border-collapse: collapse"><td align="center" style="padding: 0; margin: 0"><table  class="es-footer-body"  cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0px;    background-color: #ffffff;width: 600px;"><tr style="border-collapse: collapse"><td align="left"style="margin: 0;padding-top: 35px;padding-left: 35px;padding-right: 35px;padding-bottom: 40px;"><table width="100%"cellspacing="0"cellpadding="0"style="  mso-table-lspace: 0pt;  mso-table-rspace: 0pt;  border-collapse: collapse;  border-spacing: 0px;"><tr style="border-collapse: collapse"><td valign="top" align="center" style="padding: 0; margin: 0; width: 530px"><table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0px;"><tr style="border-collapse: collapse"><td align="center" style="padding: 0;margin: 0;padding-bottom: 15px;font-size: 0;"></td></tr><tr style="border-collapse: collapse"><td align="center" style="padding: 0;margin: 0;padding-bottom: 35px;"> <p style="margin: 0;-webkit-text-size-adjust: none;-ms-text-size-adjust: none;mso-line-height-rule: exactly;font-family: open sans, helvetica neue,helvetica, arial, sans-serif;line-height: 21px;color: #333333;font-size: 14px;   " >   <b>School of Information Technology</b> </p> <p style="margin: 0;-webkit-text-size-adjust: none;-ms-text-size-adjust: none;mso-line-height-rule: exactly;font-family: open sans, helvetica neue,helvetica, arial, sans-serif;line-height: 21px;color: #333333;font-size: 14px;" ><b></b><b></b>AITECHS Accounting System<br/></p></td></tr></table></td></tr></table></td></tr></table></td></tr></table></td></tr></table></div></body>';

            $mail->send();
        } catch (Exception $e) {

            echo $mail->ErrorInfo;
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
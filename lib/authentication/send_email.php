<?php

use PHPMailer\PHPMailer\PHPMailer;

require_once '../databaseHandler/connection.php';

require_once 'PHPMailer/src/Exception.php';
require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';
require_once '../../assets/includes/time_relative.php';
session_start();

$mail = new PHPMailer(true);

if (isset($_POST['send_otp'])) {
    $forgot_email = ucfirst(htmlspecialchars($_POST['forgot_email']));

    $otp = generateNumericOTP(6);
    $recipient = $forgot_email;
    $subject = 'Forgot Password OTP';


    $errorEmpty = false;
    $errorEmail = false;

    $select = $pdo->prepare("SELECT * FROM  users WHERE email = '$forgot_email'");
    $select->execute();
    $result = $select->fetchAll();
    foreach ($result as $row) {
        $user_id = $row["user_id"];
    }

    // error handler for empty fields
    if (empty($forgot_email)) {
        echo "<span class='form-error'>Please Enter A Registered Email!</span>";
        $errorEmpty = true;
    }

    // error handler for email format
    elseif (!filter_var($forgot_email, FILTER_VALIDATE_EMAIL)) {
        echo "<span class='form-error'>Invalid Email</span>";
        $errorEmail = true;
    }

    // error handler for checking if the email already exist
    elseif ($select->rowCount() < 1) {

        echo "<span class='form-error'>No Account is Associated with This Email!</span>";
        $errorEmail = true;
    }
    // inserts the data to the database
    else {
        $select = $pdo->prepare("SELECT * FROM  students WHERE user_id = '$user_id'");
        $select->execute();
        $result = $select->fetchAll();
        foreach ($result as $row) {
            $fullname = $row["firstname"] . ' ' . $row["middlename"] . ' ' . $row["lastname"];
        }


        $update = $pdo->prepare("UPDATE users SET verification = :otp WHERE email = :email");

        $update->bindparam('otp', $otp);
        $update->bindparam('email', $forgot_email);
        try {
            $mail->IsSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = true;

            $mail->Username = "aitechs1122@gmail.com";
            $mail->Password = "kdebvodkiqsrdulj";
            $mail->SMTPSecure = 'tls';
            $mail->Port = '587';

            $mail->SetFrom('aitechs1122@gmail.com');
            $mail->AddAddress($recipient);

            $mail->IsHTML(true);
            $mail->Subject = $subject;

            $mail->Body = '<body data-new-gr-c-s-loaded="14.1141.0" style="width: 100%; font-family: open sans, helvetica neue, helvetica, arial, sans-serif; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; padding: 0; margin: 0;"><div dir="ltr" class="es-wrapper-color" lang="en" style="background-color: #eeeeee"><table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0px;padding: 0;margin: 0;width: 100%;height: 100%;background-repeat: repeat;background-position: center top;background-color: #eeeeee;"><tr style="border-collapse: collapse"><td valign="top" style="padding: 0; margin: 0"><table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0px;table-layout: fixed !important;width: 100%;"><tr style="border-collapse: collapse"></tr> <tr style="border-collapse: collapse"><td align="center" style="padding: 0; margin: 0"><table class="es-header-body" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0px;background-color: #FDA63A;width: 600px;" cellspacing="0" cellpadding="0" bgcolor="#044767" align="center"><tr style="border-collapse: collapse"><td align="left" style="margin: 0;padding-top: 35px;padding-left: 35px;padding-right: 35px;padding-bottom: 40px;"><table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0px;"><tr style="border-collapse: collapse"><td valign="top" align="center" style="padding: 0; margin: 0; width: 530px"><table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0px;"><tr style="border-collapse: collapse">   <td class="es-m-txt-c" align="center" style="padding: 0; margin: 0"><h1 style="margin: 0;line-height: 36px;mso-line-height-rule: exactly;font-family: open sans, helvetica neue,helvetica, arial, sans-serif;font-size: 36px;font-style: normal;font-weight: bold;color: #ffffff;">AITECHS</h1></td></tr></table></td></tr></table></td></tr></table></td></tr></table><table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0px;table-layout: fixed !important;width: 100%;"><tr style="border-collapse: collapse"><td align="center" style="padding: 0; margin: 0"><table class="es-content-body" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0px;background-color: #ffffff;width: 600px;"><tr style="border-collapse: collapse"><td align="left" style="margin: 0;padding-bottom: 25px;padding-top: 35px;padding-left: 35px;padding-right: 35px;"><table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0px;"><tr style="border-collapse: collapse"><td valign="top" align="center" style="padding: 0; margin: 0; width: 530px"><table width="100%" cellspacing="0" cellpadding="0"  style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0px;"><tr style="border-collapse: collapse"><td align="left" style="padding: 0;margin: 0;padding-bottom: 5px;padding-top: 20px;"><h3 style="margin: 0;line-height: 22px;mso-line-height-rule: exactly;font-family: open sans, helvetica neue,helvetica, arial, sans-serif;font-size: 18px;font-style: normal;font-weight: bold;color: #333333;">Hello ' . $fullname . ',<br /></h3></td></tr><tr style="border-collapse: collapse"><td align="left" style="padding: 0;margin: 0;padding-bottom: 10px;padding-top: 15px;">   <p style="margin: 0;-webkit-text-size-adjust: none;-ms-text-size-adjust: none;mso-line-height-rule: exactly;font-family: open sans, helvetica neue,helvetica, arial, sans-serif;line-height: 24px;color: #777777;font-size: 16px;"><i></i>You\'re requesting an OTP for changing your password.<br/>Here\'s You\'re OTP (' . $otp . ').<br/><br/>If You did\'nt request for this please disregard.<br/><br/>Don\'t share your OTP to other\'s by any mean.<i></i></p></td></tr><tr style="border-collapse: collapse"><td align="left" style="padding: 0;margin: 0;padding-top: 5px;"><p style="margin: 0;-webkit-text-size-adjust: none;-ms-text-size-adjust: none;mso-line-height-rule: exactly;font-family: open sans, helvetica neue,helvetica, arial, sans-serif;     line-height: 24px;color: #777777;font-size: 16px;" >We are committed to providing you with the best possible solutions and ensuring that you have a positive experience with our system. Thank you for your continued support, and we look forward to serving you in the future. </p></td> </tr></table></td></tr></table>    </td></tr></table></td></tr></table><table cellpadding="0" cellspacing="0" class="es-footer"align="center" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0px;table-layout: fixed !important;width: 100%;background-color: transparent;background-repeat: repeat;      background-position: center top;"><tr style="border-collapse: collapse"><td align="center" style="padding: 0; margin: 0"><table  class="es-footer-body"  cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0px;    background-color: #ffffff;width: 600px;"><tr style="border-collapse: collapse"><td align="left"style="margin: 0;padding-top: 35px;padding-left: 35px;padding-right: 35px;padding-bottom: 40px;"><table width="100%"cellspacing="0"cellpadding="0"style="  mso-table-lspace: 0pt;  mso-table-rspace: 0pt;  border-collapse: collapse;  border-spacing: 0px;"><tr style="border-collapse: collapse"><td valign="top" align="center" style="padding: 0; margin: 0; width: 530px"><table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0px;"><tr style="border-collapse: collapse"><td align="center" style="padding: 0;margin: 0;padding-bottom: 15px;font-size: 0;"></td></tr><tr style="border-collapse: collapse"><td align="center" style="padding: 0;margin: 0;padding-bottom: 35px;"> <p style="margin: 0;-webkit-text-size-adjust: none;-ms-text-size-adjust: none;mso-line-height-rule: exactly;font-family: open sans, helvetica neue,helvetica, arial, sans-serif;line-height: 21px;color: #333333;font-size: 14px;   " >   <b>School of Information Technology</b> </p> <p style="margin: 0;-webkit-text-size-adjust: none;-ms-text-size-adjust: none;mso-line-height-rule: exactly;font-family: open sans, helvetica neue,helvetica, arial, sans-serif;line-height: 21px;color: #333333;font-size: 14px;" ><b></b><b></b>AITECHS Accounting System<br/></p></td></tr></table></td></tr></table></td></tr></table></td></tr></table></td></tr></table></div></body>';

            if ($update->execute()) {
                echo "<span class='form-success'>Code has been sent to you're E-mail!</span>";
                $mail->send();
            }
        } catch (Exception $e) {

            echo $mail->ErrorInfo;
        }
    }
} else {
    echo "There was an error!";
}
?>

<script>
    $("#forgot_email").removeClass(".input-error");

    var errorEmpty = "<?php echo $errorEmpty; ?>";
    var errorEmail = "<?php echo $errorEmail; ?>";
    var email = "<?php echo $forgot_email; ?>";
    var user_id = "<?php echo $user_id; ?>";

    if (errorEmpty == true) {
        $("#forgot_email").addClass("input-error");
    }
    if (errorEmail == true) {
        $("#forgot_email").addClass("input-error");
    }
    if (errorEmail == false && errorEmpty == false) {
        $("#forgot_email").removeClass(".input-error");
        $("#forgot_email").addClass("input-success");
        $("#send_otp").removeClass(".btn-primary");
        $("#send_otp").addClass(".btn-success");
        $(".otpart").show();
        $("#hidden_email").val(email);
        $("#user_id").val(user_id);
    }
</script>
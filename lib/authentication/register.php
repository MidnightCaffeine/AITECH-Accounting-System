<?php

use PHPMailer\PHPMailer\PHPMailer;

require_once '../databaseHandler/connection.php';

require_once 'PHPMailer/src/Exception.php';
require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';
require_once '../../assets/includes/time_relative.php';
session_start();

$mail = new PHPMailer(true);

if (isset($_POST['signUp'])) {
    $register_firstname = ucfirst(htmlspecialchars($_POST['register_firstname']));
    $register_lastname = ucfirst(htmlspecialchars($_POST['register_lastname']));
    $register_middlename = ucfirst(htmlspecialchars($_POST['register_middlename']));
    $register_email = $_POST['register_email'];
    $year_group = $_POST['year_group'];
    $section = $_POST['section'];
    $register_password = $_POST['register_password'];
    $confirm_password = $_POST['confirm_password'];
    $hashed_password = password_hash($register_password, PASSWORD_DEFAULT);
    $position = 3;
    $otp = generateNumericOTP(6);
    $recipient = $register_email;
    $subject = 'Confirmation Code';

    $fullname = $register_firstname . " " . $register_middlename . " " . $register_lastname;

    $errorEmpty = false;
    $errorEmail = false;
    $errorPassword = false;

    // error handler for empty fields
    if (empty($register_firstname) || empty($register_lastname) || empty($register_email) || empty($register_password) || empty($confirm_password)) {
        echo "<span class='form-error'>Fill in all fields!</span>";
        $errorEmpty = true;
    }

    // error handler for email format
    elseif (!filter_var($register_email, FILTER_VALIDATE_EMAIL)) {
        echo "<span class='form-error'>Invalid Email</span>";
        $errorEmail = true;
    }

    // error handler for checking if the email already exist
    elseif (isset($_POST[$register_email])) {
        $select = $pdo->prepare("SELECT email FROM  users WHERE email = '$register_email'");
        $select->execute();

        if ($select->rowCount() > 0) {
            echo "<span class='form-error'>Email Already Exist!</span>";
            $errorEmail = true;
        }
    }

    // error handler for confirming password
    elseif ($register_password != $confirm_password && !empty($confirm_password) && !empty($register_password)) {
        echo "<span class='form-error'>Password must be matched</span>";
        $errorPassword = true;
    }

    // inserts the data to the database
    else {
        $insert = $pdo->prepare("INSERT INTO users(email, password, privilege,verification) VALUES(:email, :password, :privilege, :otp)");

        $insert->bindparam('email', $register_email);
        $insert->bindparam('password', $hashed_password);
        $insert->bindparam('privilege', $position);
        $insert->bindparam('otp', $otp);

        if ($insert->execute()) {

            $select = $pdo->prepare("SELECT user_id FROM users WHERE email = '$register_email'");
            $select->execute();
            while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
                $id = $row['user_id'];
            }

            $insertStudent = $pdo->prepare("INSERT INTO students (user_id, firstname, middlename, lastname, year_group, section) VALUES(:id, :firstname, :middlename, :lastname, :year_group, :section)");

            $insertStudent->bindparam('id', $id);
            $insertStudent->bindparam('firstname', $register_firstname);
            $insertStudent->bindparam('middlename', $register_middlename);
            $insertStudent->bindparam('lastname', $register_lastname);
            $insertStudent->bindparam('year_group', $year_group);
            $insertStudent->bindparam('section', $section);

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

                $mail->Body = '<body data-new-gr-c-s-loaded="14.1141.0" style="width: 100%; font-family: open sans, helvetica neue, helvetica, arial, sans-serif; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; padding: 0; margin: 0;"><div dir="ltr" class="es-wrapper-color" lang="en" style="background-color: #eeeeee"><table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0px;padding: 0;margin: 0;width: 100%;height: 100%;background-repeat: repeat;background-position: center top;background-color: #eeeeee;"><tr style="border-collapse: collapse"><td valign="top" style="padding: 0; margin: 0"><table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0px;table-layout: fixed !important;width: 100%;"><tr style="border-collapse: collapse"></tr> <tr style="border-collapse: collapse"><td align="center" style="padding: 0; margin: 0"><table class="es-header-body" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0px;background-color: #FDA63A;width: 600px;" cellspacing="0" cellpadding="0" bgcolor="#044767" align="center"><tr style="border-collapse: collapse"><td align="left" style="margin: 0;padding-top: 35px;padding-left: 35px;padding-right: 35px;padding-bottom: 40px;"><table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0px;"><tr style="border-collapse: collapse"><td valign="top" align="center" style="padding: 0; margin: 0; width: 530px"><table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0px;"><tr style="border-collapse: collapse">   <td class="es-m-txt-c" align="center" style="padding: 0; margin: 0"><h1 style="margin: 0;line-height: 36px;mso-line-height-rule: exactly;font-family: open sans, helvetica neue,helvetica, arial, sans-serif;font-size: 36px;font-style: normal;font-weight: bold;color: #ffffff;">AITECHS</h1></td></tr></table></td></tr></table></td></tr></table></td></tr></table><table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0px;table-layout: fixed !important;width: 100%;"><tr style="border-collapse: collapse"><td align="center" style="padding: 0; margin: 0"><table class="es-content-body" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0px;background-color: #ffffff;width: 600px;"><tr style="border-collapse: collapse"><td align="left" style="margin: 0;padding-bottom: 25px;padding-top: 35px;padding-left: 35px;padding-right: 35px;"><table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0px;"><tr style="border-collapse: collapse"><td valign="top" align="center" style="padding: 0; margin: 0; width: 530px"><table width="100%" cellspacing="0" cellpadding="0"  style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0px;"><tr style="border-collapse: collapse"><td align="left" style="padding: 0;margin: 0;padding-bottom: 5px;padding-top: 20px;"><h3 style="margin: 0;line-height: 22px;mso-line-height-rule: exactly;font-family: open sans, helvetica neue,helvetica, arial, sans-serif;font-size: 18px;font-style: normal;font-weight: bold;color: #333333;">Hello ' . $fullname . ',<br /></h3></td></tr><tr style="border-collapse: collapse"><td align="left" style="padding: 0;margin: 0;padding-bottom: 10px;padding-top: 15px;">   <p style="margin: 0;-webkit-text-size-adjust: none;-ms-text-size-adjust: none;mso-line-height-rule: exactly;font-family: open sans, helvetica neue,helvetica, arial, sans-serif;line-height: 24px;color: #777777;font-size: 16px;"><i></i>Dear ' . $fullname . ', the confirmation code to confirm your email for AITECHS Accounting System is (' . $otp . ').<i></i></p></td></tr><tr style="border-collapse: collapse"><td align="left" style="padding: 0;margin: 0;padding-top: 5px;"><p style="margin: 0;-webkit-text-size-adjust: none;-ms-text-size-adjust: none;mso-line-height-rule: exactly;font-family: open sans, helvetica neue,helvetica, arial, sans-serif;     line-height: 24px;color: #777777;font-size: 16px;" >We are committed to providing you with the best possible solutions and ensuring that you have a positive experience with our system. Thank you for your continued support, and we look forward to serving you in the future. </p></td> </tr></table></td></tr></table>    </td></tr></table></td></tr></table><table cellpadding="0" cellspacing="0" class="es-footer"align="center" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0px;table-layout: fixed !important;width: 100%;background-color: transparent;background-repeat: repeat;      background-position: center top;"><tr style="border-collapse: collapse"><td align="center" style="padding: 0; margin: 0"><table  class="es-footer-body"  cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0px;    background-color: #ffffff;width: 600px;"><tr style="border-collapse: collapse"><td align="left"style="margin: 0;padding-top: 35px;padding-left: 35px;padding-right: 35px;padding-bottom: 40px;"><table width="100%"cellspacing="0"cellpadding="0"style="  mso-table-lspace: 0pt;  mso-table-rspace: 0pt;  border-collapse: collapse;  border-spacing: 0px;"><tr style="border-collapse: collapse"><td valign="top" align="center" style="padding: 0; margin: 0; width: 530px"><table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;border-collapse: collapse;border-spacing: 0px;"><tr style="border-collapse: collapse"><td align="center" style="padding: 0;margin: 0;padding-bottom: 15px;font-size: 0;"></td></tr><tr style="border-collapse: collapse"><td align="center" style="padding: 0;margin: 0;padding-bottom: 35px;"> <p style="margin: 0;-webkit-text-size-adjust: none;-ms-text-size-adjust: none;mso-line-height-rule: exactly;font-family: open sans, helvetica neue,helvetica, arial, sans-serif;line-height: 21px;color: #333333;font-size: 14px;   " >   <b>School of Information Technology</b> </p> <p style="margin: 0;-webkit-text-size-adjust: none;-ms-text-size-adjust: none;mso-line-height-rule: exactly;font-family: open sans, helvetica neue,helvetica, arial, sans-serif;line-height: 21px;color: #333333;font-size: 14px;" ><b></b><b></b>AITECHS Accounting System<br/></p></td></tr></table></td></tr></table></td></tr></table></td></tr></table></td></tr></table></div></body>';

                if ($insertStudent->execute()) {
                    $mail->send();
                }
            } catch (Exception $e) {

                echo $mail->ErrorInfo;
            }
        }
    }
} else {
    echo "There was an error!";
}
?>

<script>
    $("#register_firstname, #register_lastname, #register_middlename, #register_email, #register_password, #confirm_password").removeClass(".input-error");

    var errorEmpty = "<?php echo $errorEmpty; ?>";
    var errorEmail = "<?php echo $errorEmail; ?>";
    var errorPassword = "<?php echo $errorPassword; ?>";

    if (errorEmpty == true) {
        $("#register_firstname, #register_lastname, #register_email, #register_password, #confirm_password").addClass("input-error");
    }
    if (errorEmail == true) {
        $("#register_email").addClass("input-error");
    }
    if (errorPassword == true) {
        $("#confirm_password").addClass("input-error");
    }
    if (errorEmail == false && errorEmpty == false && errorPassword == false) {
        $("#register_firstname, #register_lastname, #register_middlename, #register_email, #register_password, #confirm_password").val("");

        Swal.fire({
            title: "Registration Successful!",
            text: "The confirmation Code is Sent on Your E-mail.",
            icon: "success",
            timer: 2000,
            timerProgressBar: true,
            showConfirmButton: false
        });

        var myModalEl = document.getElementById('addStudent');
        var modal = bootstrap.Modal.getInstance(myModalEl)
        modal.hide();
        $('#studentsTable').DataTable().ajax.reload();
    }
</script>
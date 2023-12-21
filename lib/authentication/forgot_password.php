<?php

use PHPMailer\PHPMailer\PHPMailer;

require_once '../databaseHandler/connection.php';

require_once 'PHPMailer/src/Exception.php';
require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';
require_once '../../assets/includes/time_relative.php';
session_start();

$mail = new PHPMailer(true);

if (isset($_POST['submitOTP'])) {
    $otpCode = $_POST['otpCode'];
    $hidden_email = $_POST['hidden_email'];

    $errorEmpty = false;
    $errorEmail = false;

    $select = $pdo->prepare("SELECT * FROM  users WHERE email = '$hidden_email'");
    $select->execute();
    $result = $select->fetchAll();
    foreach ($result as $row) {
        $verification = $row["verification"];
    }

    // error handler for empty fields
    if (empty($otpCode)) {
        echo "<span class='form-error'>An OTP is required!</span>";
        $errorEmpty = true;
    }
    // error handler for checking if the email already exist
    elseif ($verification != $otpCode) {
        echo "<span class='form-error'>Invalid OTP!</span>";
        $errorEmail = true;
    }
    // inserts the data to the database
} else {
    echo "There was an error!";
}
?>

<script>
    $("#otpCode").removeClass(".input-error");

    var errorEmpty = "<?php echo $errorEmpty; ?>";
    var errorEmail = "<?php echo $errorEmail; ?>";

    if (errorEmpty == true) {
        $("#otpCode").addClass("input-error");
    }
    if (errorEmail == true) {
        $("#otpCode").addClass("input-error");
    }
    if (errorEmail == false && errorEmpty == false) {
        $("#otpCode").removeClass(".input-error");
        $("#otpCode").addClass("input-success");
        $("#change_password").modal("show");
    }
</script>
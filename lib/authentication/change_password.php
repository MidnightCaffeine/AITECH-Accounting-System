<?php
date_default_timezone_set('Asia/Manila');
require_once '../databaseHandler/connection.php';
require_once '../init.php';

$cur_time = date("Y-m-d H:i:s");

if (isset($_POST['changePassword'])) {
    $user_id = $_POST['user_id'];
    $new_password = $_POST['new_password'];
    $confirm_new = $_POST['confirm_new'];

    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    $errorEmty = false;
    $combinationError = false;


    if (empty($new_password) || empty($confirm_new)) {
        echo "<span class='form-error'>Fill in all fields!</span>";
        $errorEmty = true;
    } elseif ($new_password != $confirm_new) {
        echo "<span class='form-error'>Password Not Matched!</span>";
        $combinationError = true;
    } else {
        $update = $pdo->prepare("UPDATE users SET password = :passwords, updated_at = :updated_at WHERE $user_id = :id");

        $update->bindparam('passwords', $hashed_password);
        $update->bindparam('updated_at', $cur_time);
        $update->bindparam('id', $user_id);

        $update->execute();
    }
}
?>
<script>
    $("#new_password, #confirm_new").removeClass(".input-error");

    var combinationError = "<?php echo $combinationError; ?>";
    var errorEmty = "<?php echo $errorEmty; ?>";

    if (combinationError == true) {
        $("#new_password, #confirm_new").addClass("input-error");
    }
    if (errorEmty == true) {
        $("#new_password, #confirm_new").addClass("input-error");
    }

    if (combinationError == false && errorEmty == false) {
        Swal.fire({
            title: "Password Changed!",
            text: "Redirecting to login page",
            icon: "success",
            timer: 2000,
            timerProgressBar: true,
            showConfirmButton: false
        });

        setTimeout(function() {
            window.location.replace("index.php")

        }, 2000); //redirect after 2 seconds

    }
</script>
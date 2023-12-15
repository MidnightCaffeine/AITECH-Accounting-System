<?php
date_default_timezone_set('Asia/Manila');
require_once 'databaseHandler/connection.php';
require_once 'init.php';

$cur_time = date("Y-m-d H:i:s");

if (isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_new = $_POST['confirm_new'];

    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    $errorEmty = false;
    $combinationError = false;
    $passwordError = false;


    if (empty($old_password) || empty($new_password) || empty($confirm_new)) {
        echo "<span class='form-error'>Fill in all fields!</span>";
        $errorEmty = true;
    } elseif ($new_password != $confirm_new) {
        echo "<span class='form-error'>Confirm the new password!</span>";
        $combinationError = true;
    } else {
        $select = $pdo->prepare("SELECT * FROM users WHERE $user_id = '$user_id'");
        $select->execute();
        $row = $select->fetch(PDO::FETCH_ASSOC);

        if (password_verify($old_password, $row['password'])) {


            $update = $pdo->prepare("UPDATE users SET password = :passwords, updated_at = :updated_at WHERE $user_id = :id");

            $update->bindparam('passwords', $hashed_password);
            $update->bindparam('updated_at', $cur_time);
            $update->bindparam('id', $user_id);

            $update->execute();
        } else {
            echo "<span class='form-error'>Wrong password!</span>";
            $passwordError = true;
        }
    }
}
?>
<script>
    $("#email, #password").removeClass(".input-error");

    var passwordError = "<?php echo $passwordError; ?>";
    var combinationError = "<?php echo $combinationError; ?>";
    var errorEmty = "<?php echo $errorEmty; ?>";

    if (passwordError == true) {
        $("#old_password").addClass("input-error");
    }
    if (combinationError == true) {
        $("#new_password, #confirm_new").addClass("input-error");
    }
    if (errorEmty == true) {
        $("#old_password, #new_password, #confirm_new").addClass("input-error");
    }

    if (passwordError == false && combinationError == false && errorEmty == false) {
        Swal.fire({
            title: "Password Changed!",
            text: "Redirecting to profile page",
            icon: "success",
            timer: 2000,
            timerProgressBar: true,
            showConfirmButton: false
        });

        setTimeout(function() {
            window.location.replace("profile.php")

        }, 2000); //redirect after 2 seconds

    }
</script>
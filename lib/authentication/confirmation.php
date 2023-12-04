<?php

require_once '../databaseHandler/connection.php';
require_once '../init.php';

if (isset($_POST['confirm_submit'])) {
    $confirmation_code = $_POST['confirmation_code'];
    $id = $_SESSION['myid'];

    $emptyError = false;
    $invalidCode = false;

    $select = $pdo->prepare("SELECT * FROM users WHERE user_id = '$id'");
    $select->execute();
    while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
        $verification = $row['verification'];
    }

    if (empty($confirmation_code)) {
        echo "<span class='form-error'>Confirmation Code Must Be Filled!</span>";
        $emptyError = true;
    } elseif ($confirmation_code != $verification) {
        echo "<span class='form-error'>Incorect Verification Code!</span>";
        $invalidCode = true;
    } else {
        $status = 1;
        $_SESSION['status'] = 1;
        $update = $pdo->prepare("UPDATE students SET status = :status WHERE user_id = :id");

        $update->bindparam('status', $status);
        $update->bindparam('id', $id);
        $update->execute();
    }
}
?>
<script>
    $("#confirmation").removeClass(".input-error");

    var position = "<?php echo $_SESSION['userType']; ?>";
    var emptyError = "<?php echo $emptyError; ?>";
    var invalidCode = "<?php echo $invalidCode; ?>";

    if (emptyError == true) {
        $("#confirmation").addClass("input-error");
    }
    if (invalidCode == true) {
        $("#confirmation").addClass("input-error");
    }
    if (emptyError == false) {
        $("#confirmation").removeClass(".input-error");
    }
    if (invalidCode == false) {
        $("#confirmation").removeClass(".input-error");
    }

    if (invalidCode == false && emptyError == false) {
        var myModalEl = document.getElementById('confirm');
        var modal = bootstrap.Modal.getInstance(myModalEl)
        modal.hide();

        Swal.fire({
            title: "Verification Successful!",
            text: "Redirecting to home page",
            icon: "success",
            timer: 2000,
            timerProgressBar: true,
            showConfirmButton: false
        });

        setTimeout(function() {
            if (position == 1) {
                window.location.replace("admin_dashboard.php")
            } else {
                window.location.replace("home.php")
            } //will redirect to homepage
        }, 2000); //redirect after 2 seconds

    }
</script>
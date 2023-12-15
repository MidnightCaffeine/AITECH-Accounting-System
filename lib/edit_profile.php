<?php
require_once 'databaseHandler/connection.php';


if (isset($_POST['student_id'])) {

    $id = $_POST['student_id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $middlename = $_POST['middlename'];
    $year = $_POST['year'];
    $section = $_POST['section'];

    $errorFirstname = false;
    $errorLastname = false;

    // error handler for empty fields
    if (empty($firstname)) {
        echo "<span class='form-error'>Fill in all fields!</span>";
        $errorFirstname = true;
    } elseif (empty($lastname)) {
        echo "<span class='form-error'>Fill in all fields!</span>";
        $errorLastname = true;
    } else {

        $update = $pdo->prepare("UPDATE students SET firstname = :firstname, lastname = :lastname, middlename = :middlename , year_group = :years , section = :section WHERE student_id = :id");

        $update->bindparam('firstname', $firstname);
        $update->bindparam('lastname', $lastname);
        $update->bindparam('middlename', $middlename);
        $update->bindparam('years', $year);
        $update->bindparam('section', $section);
        $update->bindparam('id', $id);

        $update->execute();
    }
}
?>

<script>
    $("#firstname_profile, #lastname_profile").removeClass(".input-error");

    var errorFirstname = "<?php echo $errorFirstname; ?>";
    var errorLastname = "<?php echo $errorLastname; ?>";

    if (errorFirstname == true) {
        $("#firstname_profile").addClass("input-error");
    }
    if (errorLastname == true) {
        $("#lastname_profile").addClass("input-error");
    }


    if (errorFirstname == false && errorLastname == false) {
        $("#firstname_profile, #lastname_profile").val("");

        var myModalEl = document.getElementById('edit_profile');
        var modal = bootstrap.Modal.getInstance(myModalEl)
        modal.hide();

        Swal.fire({
            title: "Details Changed!!!",
            text: "Details updated on the database",
            icon: "success",
            timer: 2000,
            timerProgressBar: true,
            showConfirmButton: false
        });
        setTimeout(function() {
            window.location.replace("profile.php")
            //will redirect to homepage
        }, 2000);
    }
</script>
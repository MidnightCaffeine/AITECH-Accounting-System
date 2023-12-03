<?php

require_once '../databaseHandler/connection.php';
require_once '../init.php';

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $loginErrorEmail = false;
    $loginErrorPassword = false;
    $combinationError = false;

    $select = $pdo->prepare("SELECT email FROM users WHERE email = '$email'");
    $select->execute();

    if (empty($email)) {
        echo "<span class='form-error'>Fill in all fields!</span>";
        $loginErrorEmail = true;
    } elseif (empty($password)) {
        echo "<span class='form-error'>Fill in all fields!</span>";
        $loginErrorPassword = true;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<span class='form-error'>Invalid Email</span>";
        $loginErrorEmail = true;
    } elseif ($select->rowCount() < 1) {
        echo "<span class='form-error'>Theres no account associated in this e-mail!</span>";
        $loginErrorEmail = true;
    } else {
        $select = $pdo->prepare("SELECT * FROM users WHERE email = '$email'");
        $select->execute();
        $row = $select->fetch(PDO::FETCH_ASSOC);

        if (password_verify($password, $row['password'])) {

            $id = $row['user_id'];
            $_SESSION['myid'] = $id;
            $_SESSION['created'] = $row['created_at'];
            $_SESSION['updated'] = $row['updated_at'];
            $_SESSION['userEmail'] = htmlspecialchars($row['email']);
            if (password_verify('1', $row['privilege'])) {
                $_SESSION['userType'] = '1';
            } else {
                $_SESSION['userType'] = '3';
            }

            $select = $pdo->prepare("SELECT * FROM students WHERE user_id = '$id'");
            if ($select->execute()) {
                while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
                    $id = $row['student_id'];
                    $firstname = ucfirst(htmlspecialchars($row["firstname"]));
                    $middlename = ucfirst(htmlspecialchars($row["middlename"]));
                    $lastname = ucfirst(htmlspecialchars($row["lastname"]));
                    $_SESSION['year_level'] = $row['year_group'];
                    $section = $row['section'];
                    $_SESSION['firstname'] = ucfirst($firstname);
                }
                $_SESSION['student_id'] = $id;
                $_SESSION['section'] = $section;
                if ($middlename != null) {
                    $_SESSION['fullname'] = $firstname . " " . $middlename . " " . $lastname;
                } else {
                    $_SESSION['fullname'] = $firstname . " " . $lastname;
                }
            }
        } else {
            echo "<span class='form-error'>Wrong password!</span>";
            $combinationError = true;
        }
    }
}
?>
<script>
    $("#email, #password").removeClass(".input-error");
    
    var position = "<?php echo $_SESSION['userType']; ?>";
    var loginErrorEmail = "<?php echo $loginErrorEmail; ?>";
    var loginErrorPassword = "<?php echo $loginErrorPassword; ?>";
    var combinationError = "<?php echo $combinationError; ?>";

    if (loginErrorEmail == true) {
        $("#email").addClass("input-error");
    }
    if (loginErrorPassword == true) {
        $("#password").addClass("input-error");
    }
    if (combinationError == true) {
        $("#password").addClass("input-error");
        Swal.fire({
            title: "Login Successful!",
            text: "Redirecting to home page",
            icon: "success",
            timer: 2000,
            timerProgressBar: true,
            showConfirmButton: false
        });
    }

    if (loginErrorEmail == false) {
        $("#email").removeClass(".input-error");
    }
    if (loginErrorPassword == false) {
        $("#password").removeClass(".input-error");
    }
    if (combinationError == false) {
        $("#password").removeClass(".input-error");
    }

    if (loginErrorEmail == false && loginErrorPassword == false && combinationError == false) {
        Swal.fire({
            title: "Login Successful!",
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
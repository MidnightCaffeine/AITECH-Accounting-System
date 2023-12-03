<?php
$page = 'Students';
require_once 'lib/databaseHandler/connection.php';
require_once 'lib/init.php';
require_once 'lib/no_session_bypass.php';

?>

<!DOCTYPE html>
<html lang="en">
<?php include_once 'assets/includes/head.php'; ?>
<script type="text/javascript" src="assets/js/students.js"></script>
</head>

<body>

    <?php
    include_once 'assets/includes/navigation.php';
    include_once 'assets/includes/side_navigation.php';
    ?>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Students</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Manage</li>
                    <li class="breadcrumb-item active">Students</li>
                </ol>
            </nav>
        </div>
        <section class="section dashboard">

            <button type="button" class="btn btn-primary ms-auto mb-3" data-bs-toggle="modal" data-bs-target="#addStudent">Add Student</button>

            <table id="studentsTable" class="display table table-bordered">
                <thead>
                    <tr>
                        <th>Firstname</th>
                        <th>Middlename</th>
                        <th>Lastname</th>
                        <th>Year</th>
                        <th>Section</th>
                        <th>Status</th>
                    </tr>
                </thead>

            </table>

        </section>
    </main>

    <?php
    include_once 'assets/includes/footer.php';
    require_once 'assets/includes/script.php';
    ?>

    //add fees modal
    <div class="modal fade" id="addStudent" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">

                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Students</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="register" action="lib/authentication/register.php" method="post">
                        <p id="message"></p>
                        <div class="row g-2">
                            <p class="form-message"></p>
                            <div class="col-sm-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="register_firstname" name="register_firstname" placeholder="Firstname">
                                    <label for="register_firstname">Firstname</label>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="register_lastname" name="register_lastname" placeholder="Lastname">
                                    <label for="register_lastname">Lastname</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="register_middlename" name="register_middlename" placeholder="Middlename">
                            <label for="register_middlename">Middlename</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="register_email" name="register_email" autocomplete="false" placeholder="name@example.com">
                            <label for="register_email">Email</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" id="year_group">
                                <option value="1">Freshman (1st year)</option>
                                <option value="2">Sophomore (2nd year)</option>
                                <option value="3">Junior (3rd year)</option>
                                <option value="4">Senior (4th year)</option>
                                <option value="6">Irregular</option>
                            </select>
                            <label for="year_group">Year Group</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" id="section">
                                <option value="1">A</option>
                                <option value="2">B</option>
                                <option value="3">C</option>
                                <option value="4">D</option>
                                <option value="5">E</option>
                                <option value="6">F</option>
                                <option value="7">G</option>
                                <option value="8">H</option>
                                <option value="9">I</option>
                            </select>
                            <label for="section">Section</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="register_password" placeholder="password">
                            <label for="register_password">Password</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="confirm_password" placeholder="password">
                            <label for="confirm_password">Confirm Password</label>
                        </div>
                        <div class="col-md-12 text-center block">
                            <button type="submit" name="signUp" id="signUp" class="btn btn-secondary w-100">Sign-Up</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>


</body>

</html>
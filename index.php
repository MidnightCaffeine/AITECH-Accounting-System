<?php

require_once 'lib/databaseHandler/connection.php';
require_once 'lib/init.php';

if (isset($_SESSION['fullname'])) {
    if ($_SESSION['userType'] != 1) {
        header("Location: home.php");
    } else {
        header("Location: admin_dashboard.php");
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link href="assets/img/logo.png" rel="icon">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css?family=Karla:400,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/material_design_icons.min.css" />
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/login.css" />
    <script type="text/javascript" src="assets/js/jquery.js"></script>
    <link rel="stylesheet" href="assets/css/animate.min.css" />
    <link rel="stylesheet" href="assets/css/sweetalert2.min.css" />
    <script type="text/javascript" src="assets/js/sweetalert2.all.min.js"></script>
    <script type="text/javascript" src="assets/js/authentication.js"></script>


</head>

<body>
    <main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6 px-0 d-none d-sm-block thumbnail text-center">
                    <img src="assets/img/login.jpg" alt="Random Images" class="login-img" />
                    <div class="caption">
                        <img src="assets/img/logo.png" alt="logo" class="logo animate__animated animate__bounce" />
                        <h3>AITECHS Accounting System</h3>
                    </div>
                </div>
                <div class="col-sm-6 login-section-wrapper">
                    <div class="login-wrapper my-auto">
                        <h1 class="login-title">Log in</h1>
                        <form id="login-form" action="lib/authentication/login.php" method="post">
                            <p class="login-message"></p>
                            <div class="form-group form-floating mb-2">
                                <input type="text" id="email" name="email" class="form-control" placeholder=" " />
                                <label for="email">Email or Username</label>
                            </div>
                            <div class="form-floating mb-4">
                                <input type="password" id="password" name="password" class="form-control" placeholder=" " />
                                <label for="password">Password</label>
                            </div>
                            <input name="btn_login" id="login" class="btn btn-block login-btn" type="submit" value="Login" />
                        </form>
                        <a class="forgot-password-link " href="forget_password.php">Forgot password?</a>


                        <p class="login-wrapper-footer-text">
                            Don't have an account?
                            <a data-target="#addStudent" data-bs-toggle="modal" href="#addStudent">Create an account</a>
                        </p>

                    </div>
                </div>
            </div>
        </div>
    </main>
    <script type="text/javascript" src="assets/js/bootstrap.bundle.min.js"></script>


    <div class="modal fade" id="addStudent" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">

                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Sign-Up</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="register" action="lib/authentication/register.php" method="post">
                        <p class="form-message"></p>
                        <div class="row g-2">
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
                                <option value="1st Year">Freshman (1st year)</option>
                                <option value="2nd Year">Sophomore (2nd year)</option>
                                <option value="3rd Year">Junior (3rd year)</option>
                                <option value="4th Year">Senior (4th year)</option>
                                <option value="Irregular">Irregular</option>

                            </select>
                            <label for="year_group">Year Group</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" id="section">
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                                <option value="E">E</option>
                                <option value="F">F</option>
                                <option value="G">G</option>
                                <option value="H">H</option>
                                <option value="I">I</option>
                                <option value="J">J</option>
                                <option value="K">K</option>
                                <option value="N">N</option>
                                <option value="M">M</option>
                                <option value="O">O</option>
                                <option value="P">P</option>
                                <option value="Q">Q</option>
                                <option value="R">R</option>
                                <option value="S">S</option>
                                <option value="T">T</option>
                                <option value="U">U</option>
                                <option value="V">V</option>
                                <option value="W">W</option>
                                <option value="X">X</option>
                                <option value="Y">Y</option>
                                <option value="Z">Z</option>
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

    <div class="modal fade" id="confirm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">

                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Email Confirmation</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form autocomplete="off" id="confirmation_form" action="lib/authentication/confirmation.php" method="post">
                        <input autocomplete="false" name="hidden" type="text" style="display:none;">
                        <h4>Since this is your first time login you need to confirm your e-mail to proceed.</h3>
                            <p class="verification_message mb-2 mt-2"></p>
                            <div class="row g-2">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="confirmation" name="confirmation" placeholder="confirmation">
                                    <label for="confirmation">Confirmation Code</label>
                                </div>
                                <div class="col-md-12 text-center block">
                                    <button type="submit" name="confirmSubmit" id="confirmSubmit" class="btn btn-success w-100">Verify Email</button>
                                </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- <div class="modal fade" id="forget_password" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="forgotPass" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">

                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="forgotPass">Forgot Password</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form autocomplete="off" id="send_email_form" action="lib/authentication/send_email.php" method="post">
                        <input autocomplete="false" name="hidden" type="text" style="display:none;">
                        <p class="verification_message mb-2 mt-2"></p>
                        <div class="row g-2">
                            <div class="col-sm-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="forgot_email" name="forgot_email" placeholder="Registered Email">
                                    <label for="forgot_email">Registered Email</label>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="col-md-12 text-center block">
                                    <button type="submit" name="send_otp" id="send_otp" class="btn btn-success w-100">Send OTP</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <form autocomplete="off" id="otp_form" action="lib/authentication/forgot_password.php" method="post">
                        <div class="row g-2">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="otpCode" name="otpCode" placeholder="OTP">
                                <label for="otpCode">OTP</label>
                            </div>
                            <div class="col-md-12 text-center block">
                                <button type="submit" name="submitOTP" id="submitOTP" class="btn btn-success w-100">Verify Email</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div> -->
</body>

</html>
</body>

</html>
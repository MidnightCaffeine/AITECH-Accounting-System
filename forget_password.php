<?php
$page = 'Forget Password';
require_once 'lib/databaseHandler/connection.php';
date_default_timezone_set('Asia/Manila');
?>

<!DOCTYPE html>
<html lang="en">
<?php include_once 'assets/includes/head.php'; ?>
<script>
    $(document).ready(function() {
        $(".otpart").hide();
        $("#send_email_form").submit(function(event) {
            event.preventDefault();

            // $(".resend_otp").text("Resend OTP ");
            $("#send_otp").prop('disabled', true);

            var timeleft = 20;
            var downloadTimer = setInterval(function() {
                timeleft--;
                document.getElementById("countdowntimer").textContent = timeleft;
                if (timeleft <= 0) {
                    clearInterval(downloadTimer);
                    $("#countdowntimer").text("");
                    $("#send_otp").html('Resend OTP');
                    $("#send_otp").prop('disabled', false);
                }

            }, 1000);


            var forgot_email = $("#forgot_email").val();
            var send_otp = $("#send_otp").val();

            $(".verification_message").load("lib/authentication/send_email.php", {
                forgot_email,
                send_otp,
            });
        });
        $("#submit_otp").submit(function(event) {
            event.preventDefault();

            var otpCode = $("#otpCode").val();
            var submitOTP = $("#submitOTP").val();
            var hidden_email = $("#hidden_email").val();

            $(".verification_message").load("lib/authentication/forgot_password.php", {
                otpCode,
                submitOTP,
                hidden_email
            });
        });

        $("#change_form").submit(function(event) {
            event.preventDefault();

            var new_password = $("#new_password").val();
            var confirm_new = $("#confirm_new").val();
            var changePassword = $("#changePassword").val();
            var user_id = $("#user_id").val();

            $(".modal-verification").load("lib/authentication/change_password.php", {
                new_password,
                confirm_new,
                changePassword,
                user_id
            });
        });
    });
</script>
</head>

<body>
    <main>
        <div class="container">
            <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                            <div class="d-flex justify-content-center py-4"> <a href="index.html" class="logo d-flex align-items-center w-auto"> <img src="assets/img/logo.png" alt=""> <span class="d-none d-lg-block">AITECHS</span> </a></div>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Forgot Password</h5>
                                    </div>
                                    <p class="verification_message"></p>
                                    <form class="row g-3" autocomplete="off" id="send_email_form" action="lib/authentication/send_email.php" method="post">
                                        <div class="col-12">
                                            <label for="forgot_email" class="form-label">Registered Email</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text" id="inputGroupPrepend">@</span> <input type="text" name="forgot_email" class="form-control" id="forgot_email">
                                            </div>
                                            <div class="col-12 mt-2">
                                                <button class="btn btn-primary w-100" type="submit" name="send_otp" id="send_otp">Send OTP <span id="countdowntimer"></span></button>

                                            </div>

                                        </div>
                                    </form>
                                    <div class="otpart">
                                        <form class="row g-3" autocomplete="off" id="submit_otp" action="lib/authentication/forgot_password.php" method="post">
                                            <div class="col-12">
                                                <input type="hidden" id="hidden_email" name="hidden_email">
                                                <label for="otpCode" class="form-label mt-2">One Time Password (OTP)</label>
                                                <div class="input-group has-validation">
                                                    <input type="text" name="otpCode" class="form-control" id="otpCode">
                                                </div>
                                                <div class="col-12 mt-2">
                                                    <button class="btn btn-success w-100" type="submit" name="submitOTP" id="submitOTP">Submit OTP</button>
                                                </div>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
    <div class="modal fade" id="change_password" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">

                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Change Password</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form autocomplete="off" id="change_form" action="lib/authentication/change_password.php" method="post">
                        <input autocomplete="false" name="hidden" type="text" style="display:none;">
                        <input type="hidden" id="user_id" name="user_id">
                        <p class="modal-verification mb-2 mt-2"></p>
                        <div class="row g-2">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="new_password" name="new_password" placeholder="New Password">
                                <label for="new_password">New Password</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="confirm_new" name="confirm_new" placeholder="Confirm Password">
                                <label for="confirm_new">Confirm Password</label>
                            </div>
                            <div class="col-md-12 text-center block">
                                <button type="submit" name="changePassword" id="changePassword" class="btn btn-success w-100">Change Password</button>
                            </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    <script src="assets/js/apexcharts.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/chart.min.js"></script>
    <script src="assets/js/echarts.min.js"></script>
    <script src="assets/js/quill.min.js"></script>
    <script src="assets/js/simple-datatables.js"></script>
    <script src="assets/js/tinymce.min.js"></script>
    <script src="assets/js/validate.js"></script>
    <script src="assets/js/main.js"></script>
</body>

</html>
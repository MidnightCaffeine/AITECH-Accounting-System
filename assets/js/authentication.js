$(document).ready(function () {
  $("#register").submit(function (event) {
    event.preventDefault();

    var register_firstname = $("#register_firstname").val();
    var register_lastname = $("#register_lastname").val();
    var register_middlename = $("#register_middlename").val();
    var register_email = $("#register_email").val();
    var year_group = $("#year_group").val();
    var section = $("#section").val();
    var register_password = $("#register_password").val();
    var confirm_password = $("#confirm_password").val();
    var signUp = $("#signUp").val();

    $(".form-message").load("lib/authentication/register.php", {
      register_firstname: register_firstname,
      register_lastname: register_lastname,
      register_middlename: register_middlename,
      register_email: register_email,
      year_group: year_group,
      section: section,
      register_password: register_password,
      confirm_password: confirm_password,
      signUp: signUp,
    });
  });

  $("#login-form").submit(function (event) {
    event.preventDefault();

    var email = $("#email").val();
    var password = $("#password").val();
    var login = $("#login").val();

    $(".login-message").load("lib/authentication/login.php", {
      email: email,
      password: password,
      login: login,
    });
  });

  $("#confirmation_form").submit(function (event) {
    event.preventDefault();

    var confirmation_code = $("#confirmation").val();
    var confirm_submit = $("#confirmSubmit").val();

    $(".verification_message").load("lib/authentication/confirmation.php", {
      confirmation_code,
      confirm_submit,
    });
  });


});

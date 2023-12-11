$(document).ready(function () {
  $("#studentsTable").DataTable({
    processing: true,
    serverSide: true,
    ajax: "lib/students/fetch_data.php",
  });

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

  $(document).on("click", ".delete", function () {
    var user_id = $(this).attr("id");

    Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "lib/students/delete_students.php",
          method: "POST",
          data: {
            user_id: user_id,
          },
          success: function (data) {
            Swal.fire({
              title: "Delete Successfully!",
              text: "Fee has been deleted on the list",
              icon: "success",
              timer: 2000,
              timerProgressBar: true,
              showConfirmButton: false,
            });
            $("#studentsTable").DataTable().ajax.reload();
          },
        });
      }
    });
  });
});

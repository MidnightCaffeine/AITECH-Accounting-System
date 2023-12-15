$(document).ready(function () {
  $(document).on("click", ".profile_edit", function () {
    var student_id = $(this).attr("id");

    $.ajax({
      url: "lib/fetch_profile.php",
      method: "POST",
      data: {
        student_id,
      },
      dataType: "json",
      success: function (data) {
        $("#edit_profile").modal("show");
        $("#profile_edit_title").text(data.title);
        $("#firstname_profile").val(data.firstname);
        $("#lastname_profile").val(data.lastname);
        $("#middlename_profile").val(data.middlename);
        var year_index;
        if (data.year == "1st Year") {
          year_index = 0;
        } else if (data.year == "2nd Year") {
          year_index = 1;
        } else if (data.year == "3rd Year") {
          year_index = 2;
        } else if (data.year == "4th Year") {
          year_index = 3;
        } else if (data.year == "Irregular") {
          year_index = 4;
        }

        var section_index;
        if (data.section == "A") {
          section_index = 0;
        } else if (data.section == "B") {
          section_index = 1;
        } else if (data.section == "C") {
          section_index = 2;
        } else if (data.section == "D") {
          section_index = 3;
        } else if (data.section == "E") {
          section_index = 4;
        } else if (data.section == "F") {
          section_index = 5;
        } else if (data.section == "G") {
          section_index = 6;
        } else if (data.section == "H") {
          section_index = 7;
        } else if (data.section == "I") {
          section_index = 8;
        }

        document.getElementById("year_group").selectedIndex = year_index;
        document.getElementById("section").selectedIndex = section_index;
        $("#hid").val(student_id);
      },
    });
  });

  $("#edit_details").submit(function (event) {
    event.preventDefault();

    var student_id = $("#hid").val();
    var firstname = $("#firstname_profile").val();
    var lastname = $("#lastname_profile").val();
    var middlename = $("#middlename_profile").val();
    var year = $("#year_group").val();
    var section = $("#section").val();

    $(".form-message").load("lib/edit_profile.php", {
        student_id,
        firstname,
        lastname,
        middlename,
        year,
        section
    });
  });

  $("#changePassword_form").submit(function (event) {
    event.preventDefault();

    var user_id = $("#user_id").val();
    var old_password = $("#old_password").val();
    var new_password = $("#new_password").val();
    var confirm_new = $("#confirm_new").val();

    $(".change-password-form-message").load("lib/change_password.php", {
        user_id,
        old_password,
        new_password,
        confirm_new
    });
  });

});

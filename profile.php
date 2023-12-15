<?php
$page = 'Profile';
date_default_timezone_set('Asia/Manila');
require_once 'lib/databaseHandler/connection.php';
require_once 'lib/init.php';
require_once 'lib/no_session_bypass.php';
require_once 'assets/includes/time_relative.php';

$statement = $pdo->prepare(
   "SELECT * FROM students WHERE student_id = '" . $_SESSION['student_id'] . "'"
);
$statement->execute();
$result = $statement->fetchAll();
foreach ($result as $row) {
   $fullname = $row["firstname"] . ' ' . $row["middlename"] . ' ' . $row["lastname"];
   $year = $row["year_group"];
   $section = $row["section"];
}
$statement = $pdo->prepare(
   "SELECT * FROM users WHERE user_id = '" . $_SESSION['myid'] . "'"
);
$statement->execute();
$result = $statement->fetchAll();
foreach ($result as $row) {
   $created_at = $row["created_at"];
   $updated_at = $row["updated_at"];
}


?>

<!DOCTYPE html>
<html lang="en">
<?php include_once 'assets/includes/head.php'; ?>
<script type="text/javascript" src="assets/js/profile.js"></script>
</head>

<body>

   <?php
   include_once 'assets/includes/navigation.php';
   include_once 'assets/includes/side_navigation.php';
   ?>
   <main id="main" class="main">
      <div class="pagetitle">
         <h1>Dashboard</h1>
         <nav>
            <ol class="breadcrumb">
               <li class="breadcrumb-item active">Home</li>
            </ol>
         </nav>
      </div>
      <section class="section profile">
         <div class="row">
            <div class="col-xl-4">
               <div class="card">
                  <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                     <img src="assets/img/profile.jpg" alt="Profile" class="img-fluid">
                     <h2><?php echo $_SESSION['fullname']; ?></h2>
                     <?php
                     if ($_SESSION['userType'] != 1) {
                     ?>

                        <h3><?php echo $year . ' - Section ' . $section; ?></h3>
                     <?php
                     }
                     ?>

                  </div>
               </div>
            </div>
            <div class="col-xl-8">
               <div class="card">
                  <div class="card-body pt-3">
                     <ul class="nav nav-tabs nav-tabs-bordered">
                        <li class="nav-item"> <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button></li>
                     </ul>
                     <div class="tab-content pt-2">
                        <div class="tab-pane fade show active profile-overview" id="profile-overview">
                           <h5 class="card-title">Profile Details</h5>
                           <div class="row">
                              <div class="col-lg-3 col-md-4 label ">Full Name</div>
                              <div class="col-lg-9 col-md-8"><?php echo $_SESSION['fullname']; ?></div>
                           </div>
                           <?php
                           if ($_SESSION['userType'] != 1) {
                           ?>

                              <div class="row">
                                 <div class="col-lg-3 col-md-4 label">Year and Section</div>
                                 <div class="col-lg-9 col-md-8"><?php echo $year . ' - Section ' . $section; ?></div>
                              </div>
                           <?php
                           }
                           ?>
                           <div class="row">
                              <div class="col-lg-3 col-md-4 label">Email</div>
                              <div class="col-lg-9 col-md-8"><?php echo $_SESSION['userEmail']; ?></div>
                           </div>
                           <div class="row">
                              <div class="col-lg-3 col-md-4 label">Created since</div>
                              <div class="col-lg-9 col-md-8"><?php echo time2str($created_at); ?></div>
                           </div>
                           <div class="row">
                              <div class="col-lg-3 col-md-4 label">Last Password change</div>
                              <div class="col-lg-9 col-md-8">
                                 <?php
                                 if ($created_at == $updated_at) {
                                    echo 'Passsword has\'t been changed since created';
                                 } else {
                                    echo time2str($updated_at);
                                 }

                                 ?>
                              </div>
                           </div>
                           <?php
                           if ($_SESSION['userType'] != 1) {
                           ?>

                              <button type="button" id="<?php echo $_SESSION['student_id']; ?>" class="btn btn-primary ms-auto mb-3 profile_edit" data-bs-toggle="modal" data-bs-target="#edit_profile">Edit Profile</button>
                           <?php
                           }
                           ?>

                           <button type="button" id="<?php echo $_SESSION['myid']; ?>" class="btn btn-primary ms-auto mb-3 password_change" data-bs-toggle="modal" data-bs-target="#password_modal">Change Password</button>

                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
   </main>
   <?php
   include_once 'assets/includes/footer.php';
   require_once 'assets/includes/script.php';
   ?>

   <div class="modal fade" id="password_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
         <div class="modal-content">

            <div class="modal-header">
               <h1 class="modal-title fs-5" id="password_title">Change Password</h1>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <form id="changePassword_form" action="lib/change_password.php" method="post">
                  <p id="message"></p>
                  <div class="row g-2">
                     <p class="change-password-form-message"></p>
                     <input type="hidden" id="user_id" name="user_id" value="<?php echo $_SESSION['myid']; ?>">
                     <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="old_password" name="old_password" placeholder="Old password">
                        <label for="old_password">Old password</label>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-floating mb-3">
                           <input type="password" class="form-control" id="new_password" name="new_password" placeholder="New Password">
                           <label for="new_password">New Password</label>
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-floating mb-3">
                           <input type="password" class="form-control" id="confirm_new" name="confirm_new" placeholder="Confirm New password">
                           <label for="confirm_new">Confirm New Password</label>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-12 text-center block">
                     <button type="submit" name="pwd_change" id="pwd_change" class="btn btn-secondary w-100">Change Password</button>
                  </div>
               </form>
            </div>

         </div>
      </div>
   </div>

   <div class="modal fade" id="edit_profile" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
         <div class="modal-content">

            <div class="modal-header">
               <h1 class="modal-title fs-5" id="profile_edit_title">Edit Profile</h1>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <form id="edit_details" action="lib/edit_profile.php" method="post">
                  <p id="message"></p>
                  <div class="row g-2">
                     <p class="form-message"></p>
                     <input type="hidden" id="hid" name="hid">
                     <div class="col-sm-6">
                        <div class="form-floating mb-3">
                           <input type="text" class="form-control" id="firstname_profile" name="firstname_profile" placeholder="Firstname">
                           <label for="firstname_profile">Firstname</label>
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-floating mb-3">
                           <input type="text" class="form-control" id="lastname_profile" name="lastname_profile" placeholder="Lastname">
                           <label for="lastname_profile">Lastname</label>
                        </div>
                     </div>
                  </div>
                  <div class="form-floating mb-3">
                     <input type="text" class="form-control" id="middlename_profile" name="middlename_profile" placeholder="Middlename">
                     <label for="middlename_profile">Middlename</label>
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
                     </select>
                     <label for="section">Section</label>
                  </div>
                  <div class="col-md-12 text-center block">
                     <button type="submit" name="edit_btn" id="edit_btn" class="btn btn-secondary w-100">Edit Profile</button>
                  </div>
               </form>
            </div>

         </div>
      </div>
   </div>



</body>

</html>
<?php
$page = 'Profile';
require_once 'lib/databaseHandler/connection.php';
require_once 'lib/init.php';
require_once 'lib/no_session_bypass.php';
$sections = ["A", "B", "C", "D", "E", "F", "G", "H", "I"];
?>

<!DOCTYPE html>
<html lang="en">
<?php include_once 'assets/includes/head.php'; ?>
<script type="text/javascript" src="assets/js/dashboard.js"></script>
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
                     <h3><?php echo $_SESSION['year_level'] . '-' . $sections[$_SESSION['section'] - 1]; ?></h3>
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
                           <h5 class="card-title">About</h5>
                           <p class="small fst-italic">Sunt est soluta temporibus accusantium neque nam maiores cumque temporibus. Tempora libero non est unde veniam est qui dolor. Ut sunt iure rerum quae quisquam autem eveniet perspiciatis odit. Fuga sequi sed ea saepe at unde.</p>
                           <h5 class="card-title">Profile Details</h5>
                           <div class="row">
                              <div class="col-lg-3 col-md-4 label ">Full Name</div>
                              <div class="col-lg-9 col-md-8"><?php echo $_SESSION['fullname']; ?></div>
                           </div>
                           <div class="row">
                              <div class="col-lg-3 col-md-4 label">Year and Section</div>
                              <div class="col-lg-9 col-md-8"><?php echo $_SESSION['year_level'] . '-' . $sections[$_SESSION['section'] - 1]; ?></div>
                           </div>
                           <div class="row">
                              <div class="col-lg-3 col-md-4 label">Email</div>
                              <div class="col-lg-9 col-md-8"><?php echo $_SESSION['userEmail']; ?></div>
                           </div>
                           <div class="row">
                              <div class="col-lg-3 col-md-4 label">Created since</div>
                              <div class="col-lg-9 col-md-8"><?php echo date('F d Y', strtotime($_SESSION['created'])); ?></div>
                           </div>
                           <div class="row">
                              <div class="col-lg-3 col-md-4 label">Last Password change</div>
                              <div class="col-lg-9 col-md-8">
                                 <?php
                                 if ($_SESSION['updated'] == $_SESSION['created']) {
                                    echo 'Passsword has\'t been changed since created';
                                 } else {
                                    echo date('F d Y', strtotime($_SESSION['updated']));
                                 }

                                 ?>
                              </div>
                           </div>
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

</body>

</html>
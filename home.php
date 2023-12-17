<?php
$page = 'Home';
require_once 'lib/databaseHandler/connection.php';
require_once 'lib/init.php';
require_once 'lib/no_session_bypass.php';
date_default_timezone_set('Asia/Manila');

?>

<!DOCTYPE html>
<html lang="en">
<?php include_once 'assets/includes/head.php'; ?>
<script type="text/javascript" src="assets/js/client_dashboard.js"></script>
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
      <section class="section dashboard">
         <div class="row">
            <div class="col-lg-8">
               <div class="row">
                  <div class="col-xxl-12 col-xl-12">
                     <div class="card">
                        <div class="card-body">
                           <h5 class="card-title">Near Dealine Fees</span></h5>
                           <div class="d-flex align-items-center">
                              <table class="table table-striped">
                                 <thead>
                                    <tr>
                                       <th scope="col">Fees ID</th>
                                       <th scope="col">Title</th>
                                       <th scope="col">Details</th>
                                       <th scope="col">Cost</th>
                                       <th scope="col">Deadline</th>
                                    </tr>
                                 </thead>
                                 <tbody id="near_deadline">

                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

            <!-- right side start-->

            <div class="col-lg-4">

               <div class="card">
                  <div class="filter">
                     <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                     <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <li class="dropdown-header text-start">
                           <h6>Filter</h6>
                        </li>
                        <li><a class="dropdown-item" href="#">Today</a></li>
                        <li><a class="dropdown-item" href="#">This Month</a></li>
                        <li><a class="dropdown-item" href="#">This Year</a></li>
                     </ul>
                  </div>
                  <div class="card-body">
                     <h5 class="card-title">Recent Activity <span>| Today</span></h5>
                     <div id="activity" class="activity">
                        Loading...
                     </div>

                     <div id="moreLogs" class="mt-3 container-fluid d-flex justify-content-center align-items-center custom-container">
                        <a href="<?php if($_SESSION['userType'] != 1){echo 'client_logs.php';}else{echo 'logs.php';}?>" class="btn btn-primary block">View All Logs</a>
                     </div>
                  </div>
               </div>


            </div>
            <!-- right side end -->
         </div>
      </section>
   </main>
   <?php
   include_once 'assets/includes/footer.php';
   require_once 'assets/includes/script.php';
   ?>


   <div class="modal fade" id="view_students" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
         <div class="modal-content">

            <div class="modal-header">
               <h1 class="modal-title fs-5" id="staticBackdropLabel">Unpaid Students</h1>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <table class="table table-striped">
                  <thead>
                     <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Year And Section</th>
                        <th scope="col">Balance</th>
                     </tr>
                  </thead>
                  <tbody id="unpaid_students">

                  </tbody>
               </table>
            </div>

         </div>
      </div>
   </div>

</body>

</html>
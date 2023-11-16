<?php
$page = 'Home';
require_once 'lib/databaseHandler/connection.php';
require_once 'lib/init.php';
require_once 'lib/no_session_bypass.php';
require_once 'lib/authentication/paypal.php';


$paypal = new Paypal('sb-wccoz26819420_api1.business.example.com', 'QNHBUMAU8WCKK6EV', 'AErUJZx.Btq3.dnDQaYLyX-ypnZAAuIxEG4xJmtDpoxgdB.JpM6cFyx0', 'sandbox');

// Make an API call to get balance
$response = $paypal->call('GetBalance');

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
      <section class="section dashboard">
         <div class="row">
            <div class="col-lg-8">
               <div class="row">
                  <div class="col-xxl-12 col-md-12">
                     <div class="card info-card revenue-card">
                        <div class="card-body">
                           <h5 class="card-title">Balance <span>| Today</span></h5>
                           <div class="d-flex align-items-center">
                              <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"> <i class="bi bi-wallet2"></i></div>
                              <div class="ps-3">
                                 <h6>
                                    <?php $balance = $response['L_AMT0'] * 55.88;
                                    $amount = number_format($balance, 2, '.', ',');
                                    $amountUSD = number_format($response['L_AMT0'], 2, '.', ',');
                                    echo $amount; ?> PHP (<?php echo $amountUSD; ?> USD)
                                 </h6>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-xxl-4 col-xl-12">
                     <div class="card info-card customers-card">
                        <div class="card-body">
                           <h5 class="card-title">Customers <span>| This Year</span></h5>
                           <div class="d-flex align-items-center">
                              <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"> <i class="bi bi-people"></i></div>
                              <div class="ps-3">
                                 <h6>1244</h6>
                                 <span class="text-danger small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">decrease</span>
                              </div>
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

</body>

</html>
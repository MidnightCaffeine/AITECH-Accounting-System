<?php
$page = 'Logs';
require_once 'lib/databaseHandler/connection.php';
require_once 'lib/init.php';
require_once 'lib/no_session_bypass.php';

?>

<!DOCTYPE html>
<html lang="en">
<?php include_once 'assets/includes/head.php'; ?>
<script type="text/javascript" src="assets/js/dashboard.js"></script>
<script>
   $(document).ready(function() {
      var log_count = 10;

      $("#logs").load("lib/log/fetch_log.php", {
         "datas[]": [log_count]
      });

      $(document).on("click", ".fetch_more", function() {

      });

   });
</script>
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
               <li class="breadcrumb-item active">Logs</li>
            </ol>
         </nav>
      </div>
      <section class="section dashboard">
         <div class="card">
            <div class="card-body">
               <h5 class="card-title">Recent Activity</h5>
               <div id="logs" class="activity">
                  Loading...
               </div>

               <button class="btn btn-primary block mt-4" class="fetch_more">Fetch more Logs</button>

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
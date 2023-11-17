<?php
$page = 'Logs';
require_once 'lib/databaseHandler/connection.php';
require_once 'lib/init.php';
require_once 'lib/no_session_bypass.php';
require_once 'assets/includes/time_relative.php';

?>

<!DOCTYPE html>
<html lang="en">
<?php include_once 'assets/includes/head.php'; ?>
<script>
   $(document).ready(function() {
      var log_count = 10;

      $("#fetch_more").click(function() {
         log_count = log_count + 10;
         console.log(log_count);
         $("#logs").load("lib/log/fetch_log.php", {
            "datas[]": [log_count]
         });

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
                  <?php

                  $statement = $pdo->prepare(
                     "SELECT * FROM logs ORDER BY log_id DESC LIMIT 10"
                  );
                  $statement->execute();
                  $result = $statement->fetchAll();
                  foreach ($result as $row) {
                  ?>
                     <div class="row mb-2">
                        <div class="col-md-2">
                           <div class="activite-label">
                              <?php echo time2str($row['log_date']); ?>
                           </div>
                        </div>
                        <div class="col-md-9">
                           <div class="activity-content"><strong><?php echo $row['user_email']; ?> </strong><?php echo $row['action']; ?></div>
                        </div>
                     </div>
                  <?php
                  }
                  ?>
               </div>

               <button class="btn btn-primary mt-4" id="fetch_more" class="fetch_more">View more</button>

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
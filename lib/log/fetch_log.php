<?php

session_start();
date_default_timezone_set('Asia/Manila');
include_once '../databaseHandler/connection.php';
require_once '../../assets/includes/time_relative.php';

$log_count = $_POST['datas'][0];

$statement = $pdo->prepare(
    "SELECT * FROM logs ORDER BY log_id DESC LIMIT $log_count"
);
$statement->execute();
$result = $statement->fetchAll();
foreach ($result as $row) {
?>
    <!-- <div class="activity-item d-flex">
        <div class="activite-label">
            <?php //echo time2str($row['log_date']); ?>
        </div>
        <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
        <div class="activity-content"><strong><?php //echo $row['user_email']; ?> </strong><?php //echo $row['action']; ?></div>
    </div> -->

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
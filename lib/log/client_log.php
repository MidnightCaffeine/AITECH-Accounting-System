<?php

session_start();
date_default_timezone_set('Asia/Manila');
include_once '../databaseHandler/connection.php';
require_once '../../assets/includes/time_relative.php';

$log_count = $_POST['datas'][0];
$id = $_SESSION['myid'];;

$statement = $pdo->prepare(
    "SELECT * FROM logs WHERE user_id = $id ORDER BY log_id DESC LIMIT $log_count"
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
            <div class="activity-content"><strong>You </strong><?php echo $row['action']; ?></div>
        </div>
    </div>
<?php
}
?>
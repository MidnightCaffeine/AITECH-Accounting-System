<?php

session_start();
date_default_timezone_set('Asia/Manila');
include_once '../databaseHandler/connection.php';
require_once '../../assets/includes/time_relative.php';

$id = $_SESSION['student_id'];

$statement = $pdo->prepare(
    "SELECT * FROM logs WHERE user_id = $id  ORDER BY log_id DESC LIMIT 6"
);
$statement->execute();
$result = $statement->fetchAll();
if (count($result) > 0) {

    foreach ($result as $row) {
?>

        <div class="row">
            <div class="col-md-4">
                <div class="activite-label">
                    <?php echo time2str($row['log_date']); ?>
                </div>
            </div>
            <div class="col-md-1">
                <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
            </div>
            <div class="col-md-7">
                <div class="activity-content"><strong><?php echo $row['user_email']; ?> </strong><?php echo $row['action']; ?></div>
            </div>
        </div>
    <?php
    }
} else {
    ?>
    <div class="row">
        <div class="col-md-4">
        </div>
        <div class="col-md-4">
        <div class="activity-content">
                <h5>No Data</h5>
            </div>
        </div>
        <div class="col-md-4">
            
        </div>
    </div>
<?php

}
?>
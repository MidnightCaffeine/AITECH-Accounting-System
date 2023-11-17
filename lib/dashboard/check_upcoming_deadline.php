<?php
include_once '../databaseHandler/connection.php';
session_start();

// Get the current date and time and 10 days from now
$currentDate = date('Y-m-d H:i:s');
$tenDaysLater = date('Y-m-d H:i:s', strtotime('+10 days'));

// Prepare and execute the query to fetch fees with a 10-day deadline
$query = "SELECT * FROM fees_list WHERE deadline BETWEEN :currentDate AND :tenDaysLater";
$statement = $pdo->prepare($query);
$statement->bindParam(':currentDate', $currentDate);
$statement->bindParam(':tenDaysLater', $tenDaysLater);
$statement->execute();

// Fetch the results
$feesWithTenDaysDeadline = $statement->fetchAll(PDO::FETCH_ASSOC);

// Process the fetched fees
if ($feesWithTenDaysDeadline) {
    foreach ($feesWithTenDaysDeadline as $fee) {
        // Process each fee record (e.g., display or manipulate data)
        // Access data like $fee['column_name']

        if ($_SESSION['userType'] != 1 && $fee['year_included'] == 5 || $fee['year_included'] == $_SESSION['year_level']) {
?>
            <tr>
                <th><?php echo $fee['fees_id'] ?></th>
                <th><?php echo $fee['fees_title'] ?></th>
                <th><?php echo $fee['fees_description'] ?></th>
                <th><?php echo $fee['cost'] ?></th>
                <th><?php echo date('jS M Y', strtotime($fee['deadline'])) ?></th>
            </tr>
        <?php
        } elseif ($_SESSION['userType'] == 1) {
        ?>
            <tr>
                <th><?php echo $fee['fees_id'] ?></th>
                <th><?php echo $fee['fees_title'] ?></th>
                <th><?php echo $fee['fees_description'] ?></th>
                <th><?php echo $fee['cost'] ?></th>
                <th><?php echo date('jS M Y', strtotime($fee['deadline'])) ?></th>
                <th><button type="button" id="<?php echo $fee['fees_id'] ?>" class="btn btn-primary view" name="<?php echo $fee['year_included'] ?>"><i class="bi bi-person-circle"></i> View Unpaid Students</button></th>
            </tr>
    <?php
        }
    }
} else {
    ?>
    <th scope="row">No fees found with a 10-day deadline.</th>
<?php
}

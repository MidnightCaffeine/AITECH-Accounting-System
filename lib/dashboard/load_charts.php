<?php
include_once '../databaseHandler/connection.php';
session_start();

if (isset($_POST["fetch"])) {


    // Get the current date and time and 10 days from now
    $currentDate = date('Y-m-d H:i:s');
    $tenDaysLater = date('Y-m-d H:i:s', strtotime('+10 days'));

    // Prepare and execute the query to fetch fees with a 10-day deadline
    $query = "SELECT * FROM fees_list WHERE deadline BETWEEN :currentDate AND :tenDaysLater LIMIT 1";
    $statement = $pdo->prepare($query);
    $statement->bindParam(':currentDate', $currentDate);
    $statement->bindParam(':tenDaysLater', $tenDaysLater);
    $statement->execute();

    // Fetch the results
    $feesWithTenDaysDeadline = $statement->fetchAll(PDO::FETCH_ASSOC);

    // Process the fetched fees
    if ($feesWithTenDaysDeadline) {
        foreach ($feesWithTenDaysDeadline as $fee) {
            $title = $fee['fees_title'];
            $description = $fee['fees_description'];
            $included = $fee['year_included'];
        }
    } else {
        $title = "no data";
        $description = "no data";
    }

    $output = array();

    array_push($output, (object)[
        'title' => $title
    ]);
    array_push($output, (object)[
        'description' => $description
    ]);


    echo json_encode($output);
}

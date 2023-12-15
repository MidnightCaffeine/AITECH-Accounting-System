<?php
session_start();
include_once 'databaseHandler/connection.php';


if(isset($_POST["student_id"]))
{
    $output = array();
    $statement = $pdo->prepare(
        "SELECT * FROM students WHERE student_id = '".$_POST["student_id"]."'"
    );
    $statement->execute();
    $result = $statement->fetchAll();
    foreach($result as $row)
    {
        $output["title"] = $row["firstname"] .' '.$row["lastname"].' Details';
        $output["firstname"] = $row["firstname"];
        $output["lastname"] = $row["lastname"];
        $output["middlename"] = $row["middlename"];
        $output["year"] = $row["year_group"];
        $output["section"] = $row["section"];
    }
    echo json_encode($output);
}
?>
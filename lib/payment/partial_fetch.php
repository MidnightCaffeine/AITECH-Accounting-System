<?php
session_start();
include_once '../databaseHandler/connection.php';

$year_level = $_SESSION['year_level'];
$id = $_SESSION['student_id'];
$fees_id = $_POST["fees_id"];
$cost;

if(isset($_POST["fees_id"]))
{
    $output = array();
    $statement = $pdo->prepare(
        "SELECT * FROM fees_list WHERE fees_id = '$fees_id'"
    );
    $statement->execute();
    $result = $statement->fetchAll();
    foreach($result as $row)
    {
        $output["title"] = $row["fees_title"];
        $output["descripton"] = $row["fees_description"];
        $output["cost"] = $row["cost"];
        $cost = $row["cost"];
        $output["deadline"] = $row["deadline"];
    }
    $statement = $pdo->prepare(
        "SELECT * FROM payment_list WHERE fees_id = '$fees_id' AND student_id = '$id'"
    );
    $statement->execute();
    $result = $statement->fetchAll();
    foreach($result as $row)
    {
        $output["payment_id"] = $row["payment_id"];
        $output["payed"] = $cost - $row["cost"];
    }
    echo json_encode($output);
}
?>
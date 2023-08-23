<?php
session_start();
include_once '../databaseHandler/connection.php';

$year_level = $_SESSION['year_level'];
$id = $_SESSION['student_id'];


if(isset($_POST["member_id"]))
{
    $output = array();
    $statement = $pdo->prepare(
        "SELECT * FROM fees_list WHERE year_included = '$year_level' OR  year_included = 5 ORDER BY fees_id ASC"
    );
    $statement->execute();
    $result = $statement->fetchAll();
    foreach($result as $row)
    {
        $output["title"] = $row["fees_title"];
        $output["descripton"] = $row["fees_description"];
        $output["year"] = $row["year_included"];
        $output["cost"] = $row["cost"];
        $output["deadline"] = $row["deadline"];
    }
    echo json_encode($output);
}
?>
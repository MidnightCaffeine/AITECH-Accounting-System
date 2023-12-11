<?php
session_start();
include_once '../databaseHandler/connection.php';


if(isset($_POST["fees_id"]))
{
    $output = array();
    $statement = $pdo->prepare(
        "SELECT * FROM students"
    );
    $statement->execute();
    $result = $statement->fetchAll();
    $output["students"] = $select->rowCount();

    echo json_encode($output);
}
?>
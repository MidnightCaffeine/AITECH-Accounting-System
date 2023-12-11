<?php
session_start();
include_once '../databaseHandler/connection.php';

if (isset($_POST["user_id"])) {
    $statement = $pdo->prepare(
        "DELETE FROM students WHERE user_id = :id"
    );
    $result = $statement->execute(

        array(':id' =>   $_POST["user_id"])

    );
    $delete = $pdo->prepare(
        "DELETE FROM users WHERE user_id = :id"
    );
    $result = $delete->execute(

        array(':id' =>   $_POST["user_id"])

    );
}

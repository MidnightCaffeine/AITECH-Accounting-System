<?php
session_start();
include_once '../databaseHandler/connection.php';


if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $delete = $pdo->prepare("DELETE FROM `fees_list` WHERE fees_id='$id' ");
    if ($delete->execute()) {
        $_SESSION['status'] = "dsuccess";
        header("location:../../fees.php");
    } else {
        echo '<script> alert("Data Not Deleted"); </script>';
    }
}
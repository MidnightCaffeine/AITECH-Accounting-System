<?php

if (!isset($_SESSION['fullname']) || $_SESSION['status'] != 1) {
    session_unset();
    session_write_close();
    session_destroy();
    header("Location: index.php");
}

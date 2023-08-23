<?php

if (!isset($_SESSION['fullname'])) {
    session_unset();
    session_write_close();
    session_destroy();
    header("Location: index.php");
}

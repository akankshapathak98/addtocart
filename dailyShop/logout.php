<?php
session_start();
if (isset($_SESSION['userdata']['username'])) {
    session_destroy();
    header('Location:account.php');
} else {
    header('Location: account.php');
}
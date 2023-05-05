<?php
include 'connection.php';
if (!isset($_SESSION['user_log'])) {
    header('location:' . SITEURL . 'enter.php');
} else {
    session_start();
    session_destroy();
    header('location:' . SITEURL . 'main.php');
    exit;
}

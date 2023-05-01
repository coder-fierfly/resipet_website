<?php
include('connection.php');
if (!isset($_SESSION['user_log'])) {
    $_SESSION['no-log'] = '<div>плиз войди в акк</div>';
    echo $_SESSION['no-log'];
} else {
    $_SESSION['no-log'] = '<div>ты уже в акке</div>';
    echo $_SESSION['no-log'];
    $log = $_SESSION['user_log'];
    $check_admin = pg_query($con, "SELECT public.check_admin('" . $log . "')");
    $ch_admin = pg_fetch_row($check_admin);
    if ($ch_admin[0] == 't') {
        $_SESSION['admin'] = '';
        echo "господин, приказывайте";
    } else {
        echo 'где твои права халоп';
    }
}



// header('location:' . SITEURL . 'enter.php');

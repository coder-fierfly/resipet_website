<?php
include('connection.php');
if (isset($_SESSION['user_log'])) {
    $log = $_SESSION['user_log'];
    $check_admin = pg_query($con, "SELECT public.check_admin('" . $log . "')");
    $ch_admin = pg_fetch_row($check_admin);
    if ($ch_admin[0] == 't') {
        $_SESSION['admin'] = True;
    } else {
        $_SESSION['admin'] = False;
    }
}

<?php
include 'connection.php';

if (isset($_POST['user_log']) && isset($_POST['delite']) && !empty($_POST['delite'])) {
    $query = pg_query($con, "DELETE FROM public.users WHERE user_log='" . $_POST['user_log'] . "'");
    $query_check = pg_query($con, "SELECT public.check_login('" . $_POST['user_log'] . "')");
    if (pg_fetch_assoc($query_check) == false) {
        echo "Пользователь не существует";
    } else {
        echo "Пользователь существует";
        $sql = "DELETE FROM public.users WHERE user_log='" . $_POST['user_log']  . "'";
        $ret = pg_query($con, $sql);
        if ($ret) {
            echo "Пользователь удален";
        } else {

            echo "Что-то пошло не так";
        }
    }
}

if (isset($_POST['user_log']) && isset($_POST['rules']) && !empty($_POST['rules'])) {
    // выдать права админа
    $query = pg_query($con, "SELECT add_admin('" . $_POST['user_log'] . "');");
    $query_check = pg_query($con, "SELECT public.check_login('" . $_POST['user_log'] . "')");
    if (pg_fetch_assoc($query_check) == false) {
        echo "Пользователь не существует";
    } else {
        $sql = "SELECT public.add_admin('" . $_POST['user_log']  . "')";
        $ret = pg_query($con, $sql);
        if ($ret) {
            echo "Пользователь выданы права";
        } else {
            echo "Что-то пошло не так";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>PHP PostgreSQL Registration & Login Example </title>
    <meta name="keywords" content="PHP,PostgreSQL,Insert,Login">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>
    <?php include('header.php') ?>
    <div class="container">
        <h2>Register Here </h2>
        <form method="post">
            <div class="form-group">
                <label for="user_log">Логин удаляемого:</label>
                <input type="text" class="form-control" maxlength="10" id="user_log" placeholder="Введите логин" name="user_log">
            </div>
            <input type="submit" name="delite" class="btn btn-primary" value="delite">
            <input type="submit" name="rules" class="btn btn-primary" value="rules">
        </form>
    </div>
</body>

</html>
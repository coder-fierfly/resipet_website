<?php
include 'connection.php';
if (isset($_POST['submit']) && !empty($_POST['submit'])) {
    // $hashpassword = md5($_POST['pwd']);
    $salt = 'mYsAlT!';
    $p = crypt($_POST['pwd'], $salt);
    $query = pg_query($con, "SELECT public.check_login_pass('" . $_POST['user_log'] . "','" . $p . "')");
    $row = pg_fetch_row($query);
    // TODO проверить здесь
    $check = pg_query($con, "SELECT public.check_entering('" . $_POST['user_log'] . "')");
    $ch = pg_fetch_row($check);
    if ($ch[0] == 'f') {
        echo "превышено количество попыток входа";
    } else {
        if ($row[0] == 't') {
            pg_query($con, "SELECT public.try_to_enter_null('" . $_POST['user_log'] . "')");
            $_SESSION["user_log"] = $_POST['user_log'];
            echo "Вы вошли";
        } else {
            echo "Не верный логин";
            pg_query($con, "SELECT public.try_to_enter_func('" . $_POST['user_log'] . "')");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Recipe Website </title>
    <meta name="keywords" content="PHP,PostgreSQL,Insert,Login">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>


<body>
    <?php include('header.php') ?>
    <div class="container">
        <h2>Login Here </h2>
        <form method="post">
            <div class="form-group">
                <label for="user_log">Login:</label>
                <input type="text" class="form-control" id="user_log" placeholder="Enter Login" name="user_log">
            </div>
            <div class="form-group">
                <label for="pwd">Password:</label>
                <input type="pass" class="form-control" id="pwd" placeholder="Enter pass" name="pwd">
            </div>
            <input type="submit" name="submit" class="btn btn-primary" value="Войти">
        </form>
    </div>
</body>

</html>
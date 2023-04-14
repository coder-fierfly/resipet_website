<?php
$host = "localhost";
$user = "postgres";
$password = "8915lena";
$dbname = "kurs_work";

$connection_string = "host={$host} dbname={$dbname} user={$user} password={$password} ";
$dbconn = pg_connect($connection_string);
if (isset($_POST['submit']) && !empty($_POST['submit'])) {
    // $hashpassword = md5($_POST['pwd']);
    $sql = "select *from public.users where user_log = '" . ($_POST['user_log']) . "' and pass ='" . ($_POST['pwd']) . "'";
    $data = pg_query($dbconn, $sql);
    $login_check = pg_num_rows($data);
    if ($login_check > 0) {

        echo "Login Successfully";
    } else {

        echo "Invalid Details";
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
<header>
    <h1>Recipe Website</h1>
    <nav>
        <ul>
            <li><a href="index.php">"название сайта"</a></li>
            <li><a href="recipes.php">Рецепты</a></li>
            <li><a href="add_recipe.php">Добавить рецет</a></li>
            <li><a href="register.php">Регистрация</a></li>
            <li><a href="login.php">Авторизация</a></li>
            <li><a href="allusers.php">Все пользователи</a></li>
        </ul>
    </nav>
</header>

<body>
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

            <input type="submit" name="submit" class="btn btn-primary" value="Submit">
        </form>
    </div>
</body>

</html>
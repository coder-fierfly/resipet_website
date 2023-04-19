<?php
include 'connection.php';

if (isset($_POST['user_log']) && isset($_POST['submit']) && !empty($_POST['submit'])) {
    $query = pg_query($con, "SELECT public.check_login('" . $_POST['user_log'] . "')");
    $row = pg_fetch_row($query);
    if ($row[0] == 't') {
        echo "Пользователь с таким логином уже существует в базе данных";
    } else {
        if (empty($_POST['technologies'])) {
            $_POST['val'] = True;
        } else {
            $_POST['val'] = False;
        }
        $salt = 'mYsAlT!';
        $p = crypt($_POST['pass'], $salt);
        $sql = "insert into public.users(user_name,user_surname,user_log,pass,admin,block,soft_delete,date_of_birth)values('" .
            $_POST['user_name'] . "','" . $_POST['user_surname'] . "','" . ($_POST['user_log']) . "','" . $p . "','" .
            $_POST['val'] . "','" . "False" . "','" . "False" . "','" . $_POST['date_of_birth'] . "')";
        $ret = pg_query($con, $sql);
        if ($ret) {
            echo "Данные успешно добавлены";
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
                <label for="user_name">Имя:</label>
                <input type="text" class="form-control" id="user_name" placeholder="Введите имя" name="user_name" requuired>
            </div>

            <div class="form-group">
                <label for="user_surname">Фамилия:</label>
                <input type="text" class="form-control" id="user_surname" placeholder="Введите фамилию" name="user_surname">
            </div>

            <div class="form-group">
                <label for="user_log">Логин:</label>
                <input type="text" class="form-control" maxlength="10" id="user_log" placeholder="Введите логин" name="user_log">
            </div>

            <div class="form-group">
                <label for="pass">Пароль:</label>
                <input type="password" class="form-control" id="pass" placeholder="Введите пароль" name="pass">
            </div>

            <div class="form-group">
                <label for="date_of_birth">Дата рождения:</label>
                <input type="date" class="form-control" id="date_of_birth" placeholder="Введите дату рождения" name="date_of_birth">
            </div>
            <input type="submit" name="submit" class="btn btn-primary" value="Submit">
        </form>
    </div>
</body>

</html>
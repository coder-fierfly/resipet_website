<?php
$host = "localhost";
$user = "postgres";
$password = "8915lena";
$dbname = "kurs_work";

$connection_string = "host={$host} dbname={$dbname} user={$user} password={$password} ";
$dbconn = pg_connect($connection_string);


$query = pg_query($dbconn, "SELECT COUNT(user_id) FROM users WHERE user_log='" . $_POST['user_log'] . "'");
if (pg_num_rows($query) > 0) {
    echo "Пользователь с таким логином уже существует в базе данных";
} else {
    if (isset($_POST['submit']) && !empty($_POST['submit'])) {
        if (empty($_POST['technologies'])) {
            $_POST['val'] = True;
        } else {
            $_POST['val'] = False;
        }

        $sql = "insert into public.users(user_name,user_surname,user_log,pass,admin,block,soft_delete,date_of_birth)values('" .
            $_POST['user_name'] . "','" . $_POST['user_surname'] . "','" . ($_POST['user_log']) . "','" . $_POST['pass'] . "','" .
            $_POST['val'] . "','" . "False" . "','" . "False" . "','" . $_POST['date_of_birth'] . "')";
        $ret = pg_query($dbconn, $sql);
        if ($ret) {

            echo "Data saved Successfully";
        } else {

            echo "Soething Went Wrong";
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
    <div class="container">
        <h2>Register Here </h2>
        <form method="post">

            <div class="form-group">
                <label for="user_name">Name:</label>
                <input type="text" class="form-control" id="user_name" placeholder="Enter name" name="user_name" requuired>
            </div>

            <div class="form-group">
                <label for="user_surname">Surname:</label>
                <input type="text" class="form-control" id="user_surname" placeholder="Enter surname" name="user_surname">
            </div>

            <div class="form-group">
                <label for="user_log">Login:</label>
                <input type="text" class="form-control" maxlength="10" id="user_log" placeholder="Enter user_log" name="user_log">
            </div>

            <div class="form-group">
                <label for="pass">Password:</label>
                <input type="password" class="form-control" id="pass" placeholder="Enter password" name="pass">
            </div>

            <!-- <div class="form-group">
                <label for="admin">Admin:</label>
                <input type="boolean" class="form-control" id="admin" placeholder="Enter admin" name="admin">
            </div> -->

            <!-- <div class="form-group">
                <label for="block">Block:</label>
                <input type="boolean" class="form-control" id="block" placeholder="Enter block" name="block">
            </div> -->

            <!-- <div class="form-group">
                <label for="soft_delete">soft_delete:</label>
                <input type="boolean" class="form-control" id="soft_delete" placeholder="Enter soft_delete" name="soft_delete">
            </div> -->

            <div class="form-group">
                <label for="date_of_birth">date_of_birth:</label>
                <input type="date" class="form-control" id="date_of_birth" placeholder="Enter date_of_birth" name="date_of_birth">
            </div>

            <p>Admin: <input type="checkbox" name="technologies" value="val" /></p>
            <input type="submit" name="submit" class="btn btn-primary" value="Submit">
        </form>
    </div>
</body>

</html>
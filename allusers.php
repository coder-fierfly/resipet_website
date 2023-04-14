<?php

$host = "localhost";
$user = "postgres";
$password = "8915lena";
$dbname = "kurs_work";
$con = pg_connect("host=$host dbname=$dbname user=$user password=$password");

if (!$con) {
    die('Connection failed.');
}
try {
    $pdo = new PDO('pgsql:host=localhost;dbname=kurs_work', 'postgres', '8915lena');
} catch (PDOException $e) {
    echo "Error connecting to database: " . $e->getMessage();
    exit();
}
$sql = "SELECT * FROM users";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html>

<head>
    <title>Recipe Website </title>
    <meta name="keywords" content="PHP,PostgreSQL,Insert,Login">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>
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

    <main>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Login</th>
                    <th>Name</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $row) : ?>
                    <tr>
                        <td><?php echo $row['user_id']; ?></td>
                        <td><?php echo $row['user_log']; ?></td>
                        <td><?php echo $row['user_name']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
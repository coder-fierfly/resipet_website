<?php
include 'connection.php';

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
    <link rel="stylesheet" href="../css/admin.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>
    <?php include('header.php') ?>
    <div class="main_content">
        <div class="wrapper">
            <!-- <main> -->
            <table class="tbl_full">
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
        </div>
    </div>
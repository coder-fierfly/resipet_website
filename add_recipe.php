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
        <h2>Add Recipe</h2>
        <form method="post" action="process_recipe.php">
            <label for="recept_name">recept_name:</label>
            <input type="text" id="recept_name" name="recept_name" required><br>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea><br>

            <!-- <label for="ingredients">Ingredients:</label>
            <textarea id="ingredients" name="ingredients" required></textarea><br>

            <label for="directions">Directions:</label>
            <textarea id="directions" name="directions" required></textarea><br>

            <label for="prep_time">Preparation Time:</label>
            <input type="number" id="prep_time" name="prep_time" required><br>

            <label for="cook_time">Cooking Time:</label>
            <input type="number" id="cook_time -->
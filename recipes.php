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
        <h2>Recipes</h2>
        <?php
        // Connect to database
        $db_host = "localhost";
        $db_user = "postgres";
        $db_pass = "8915lena";
        $db_name = "kurs_work";


        $conn = pg_connect("host=$db_host dbname=$db_name user=$db_user password=$db_pass");
        if (!$conn) {
            die('Connection failed.');
        }

        // Get recipes from database
        $pg = "SELECT * FROM recept";
        $result = pg_query($conn, $pg);

        // while ($row = pg_fetch_assoc($result)) {;
        //     array_push($data, $row);
        // }
        if (!$result) {
            echo "Произошла ошибка.\n";
            exit;
        }
        if (pg_num_rows($result) > 0) {
            while ($row = pg_fetch_assoc($result)) {
                echo '<h3>' . $row["recept_name"] . '</h3>';
                echo '<p>' . $row["description"] . '</p>';
                // echo '<p>Preparation Time: ' . $row["prep_time"] . ' minutes</p>';
                // echo '<p>Cooking Time: ' . $row["cook_time"] . ' minutes</p>';
                // echo '<p><a href="recipe.php?id=' . $row["id"] . '">View Recipe</a></p>';
            }

            // while ($row = pg_fetch_assoc($result)) {
            //     echo "Автор: $row[0]  E-mail: $row[1]";
            //     echo "<br />\n";
            //   }
        } else {
            echo "<p>No recipes found.</p>";
        }
        pg_close($conn);
        ?>
    </main>

    <footer>
        <p>Recipe Website &copy; 2023</p>
    </footer>
</body>

</html>
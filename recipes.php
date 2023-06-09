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
    <?php include('header.php') ?>

    <main>
        <h2>Recipes</h2>
        <?php
        include 'connection.php';
        // Connect to database
        // $db_host = "localhost";
        // $db_user = "postgres";
        // $db_pass = "8915lena";
        // $db_name = "kurs_work";


        // $con = pg_connect("host=$db_host dbname=$db_name user=$db_user password=$db_pass");
        if (!$con) {
            die('Connection failed.');
        }

        // Get recipes from database
        $pg = "SELECT * FROM recept";
        $result = pg_query($con, $pg);

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
        pg_close($con);
        ?>
    </main>

    <footer>
        <p>Recipe Website &copy; 2023</p>
    </footer>
</body>

</html>
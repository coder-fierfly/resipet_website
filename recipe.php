<?php include('log_check.php'); ?>
<!DOCTYPE html>
<html style="font-size: 16px;" lang="ru">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="utf-8">
  <meta name="keywords" content="INTUITIVE">
  <meta name="description" content="">
  <title>рецепт</title>
  <link rel="stylesheet" href="nicepage.css" media="screen">
  <link rel="stylesheet" href="recipe.css" media="screen">
  <script class="u-script" type="text/javascript" src="jquery-1.9.1.min.js" defer=""></script>
  <script class="u-script" type="text/javascript" src="nicepage.js" defer=""></script>
  <meta name="generator" content="Nicepage 5.9.8, nicepage.com">
  <link id="u-theme-google-font" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i|Open+Sans:300,300i,400,400i,500,500i,600,600i,700,700i,800,800i">


  <script type="application/ld+json">
    {
      "@context": "http://schema.org",
      "@type": "Organization",
      "name": "",
      "logo": "images/4768598-0.png"
    }
  </script>
  <meta name="theme-color" content="#478ac9">
  <meta property="og:title" content="рецепт">
  <meta property="og:type" content="website">
  <meta data-intl-tel-input-cdn-path="intlTelInput/">
</head>

<body class="u-body u-xl-mode" data-lang="ru">
  <?php include('my_header.php') ?>
  <section class="u-align-center u-clearfix u-section-1" id="sec-d2ea">

    <div class="u-clearfix u-sheet u-valign-middle-xs u-sheet-1">
      <div class="u-container-style u-expanded-width u-product u-product-1">
        <div class="u-container-layout u-container-layout-1">
          <h2 class="u-align-left u-product-control u-text u-text-1">
            <?php
            if (isset($_POST['submit'])) {
              $us_id = '';
              if (isset($_SESSION['user_log'])) {
                $id_user = "SELECT user_id	FROM public.users WHERE user_log = '" . $_SESSION['user_log'] . "'";
                $rrr =  pg_query($con, $id_user);
                if (pg_num_rows($rrr) > 0) {
                  while ($r = pg_fetch_assoc($rrr)) {
                    $us_id = $r['user_id'];
                  }
                  $us_res = "SELECT recipe_id, user_id FROM public.favorite_recipe_of_user 
                  where user_id=" . $us_id . "and recipe_id=" .  $_GET['id'];
                  $user_res_result =  pg_query($con, $us_res);
                  if ($us_id != "" && pg_num_rows($user_res_result) == 0) {
                    $add_fav = "INSERT INTO public.favorite_recipe_of_user(recipe_id, user_id) VALUES (" . $_GET['id'] . "," . $us_id . ")";
                    $rer =  pg_query($con, $add_fav);
                  } else {
                    echo "<script>alert(\"рецепт уже в избранном\");</script>";
                  }
                } else {
                  echo "<script>alert(\"войдите в аккаунт\");</script>";
                }
              }
            }
            ?>
            <?php
            $pg = "SELECT recipe_name, description, steps, link
              FROM public.recipe
              where recipe_id ='" . $_GET['id'] . "';";
            $result = pg_query($con, $pg);
            if (!$result) {
              echo "Произошла ошибка.\n";
              exit;
            }
            if (pg_num_rows($result) > 0) {
              while ($row = pg_fetch_assoc($result)) {
                $buff_link = '';
                if (file_exists($row['link'])) {
                  $buff_link = $row['link'];
                } else {
                  $buff_link = 'images/err.jpg';
                }
                echo '<a class="u-product-title-link">'  . $row['recipe_name'] .  '</a></h2>
          <div class="u-align-left u-product-control u-product-desc u-text u-text-2">';
                echo '<p>' . $row['description'] . '</p></div>';
                echo '<img class="u-image u-image-default u-image-1" src="' . $buff_link .
                  '" alt="" data-image-width="5000" data-image-height="3981">';
            ?>
                <?php
                $ing_pg = "SELECT measure.measure_name, ingredient.ingredient_name, recipe_ingredient_measure.quantity
            FROM public.ingredient, public.measure, public.recipe_ingredient_measure
            where recipe_ingredient_measure.recipe_id = " . $_GET['id'] . " and ingredient.ingredient_id = 
            recipe_ingredient_measure.ingredient_id and measure.measure_id = recipe_ingredient_measure.measure_id";
                $res_ing = pg_query($con, $ing_pg);
                ?>
        </div>
        <form method="POST">
          <!-- <div class="u-align-center u-form-group u-form-submit">
            <a class="u-btn u-btn-submit u-button-style">В избранное</a> -->
          <input type="submit" name="submit" value="В избранное" class="u-btn">
          <br>
          <h6> Ингридиенты: </h6>
          <?php

                if (pg_num_rows($res_ing) > 0) {
                  while ($r = pg_fetch_assoc($res_ing)) {
                    // echo '<div class="u-align-center u-container-style u-products-item u-repeater-item u-white u-repeater-item-1">';
                    // echo '<div class="u-container-layout u-similar-container u-container-layout-3">';
                    // echo '<h4 class="u-product-control u-text u-text-1">';
                    // echo '<a class="u-product-title-link" href="recipe.php?id=' . $row['recipe_id'] .  '
                    echo $r['ingredient_name'] . ' ' . $r['quantity'] . ' ' . $r['measure_name'];
                    echo '<br>';
                  }
                }
          ?>
          <!-- </div> -->
        </form>
      </div>
  <?php
                echo '<p class="u-text u-text-3">' . $row['steps'] . '<br></p>';
              }
            }
  ?>
  </p>
    </div>
  </section>


  <?php include 'footer.php' ?>

</body>

</html>
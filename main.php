<?php
include('log_check.php');
?>
<!DOCTYPE html>
<html style="font-size: 16px;" lang="ru">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="utf-8">
  <meta name="keywords" content="">
  <meta name="description" content="">
  <title>main</title>
  <link rel="stylesheet" href="nicepage.css" media="screen">
  <link rel="stylesheet" href="main.css" media="screen">
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
  <meta property="og:title" content="main">
  <meta property="og:type" content="website">
  <meta data-intl-tel-input-cdn-path="intlTelInput/">
</head>

<body class="u-body u-xl-mode" data-lang="ru">
  <?php include('header.php') ?>
  <section class="u-align-center u-clearfix u-section-1" id="sec-1c6c">
    <div class="u-clearfix u-sheet u-valign-top u-sheet-1">
      <div class="u-clearfix u-expanded-width u-layout-wrap u-layout-wrap-1">
        <div class="u-layout">
          <div class="u-layout-row">
            <div class="u-container-style u-layout-cell u-size-17 u-layout-cell-1">
              <div class="u-container-layout u-container-layout-1">
                <h3>Ингридиенты:</h3>
                <br>

                <form method="POST">
                  <div class="container">

                    <?php
                    $res = pg_query($con, "SELECT * FROM  public.ingredient ORDER BY ingredient_name ASC ");

                    if (pg_num_rows($res) > 0) {
                      while ($row = pg_fetch_assoc($res)) {
                    ?>
                        <div class="list-group-item checkbox">
                          <label><input type="checkbox" class="common_selector brand" name="ing[]" value="<?php echo $row['ingredient_id']; ?>"> <?php echo $row['ingredient_name']; ?></label>
                        </div>
                    <?php
                      }
                    } else {
                      echo 'нет данных';
                    }
                    ?>
                  </div>
                  <br>

                  <select class="container-1" name="type_of">
                    <option value='-1' selected="true" disabled="disabled">Тип блюда</option>
                    <?php
                    $res = pg_query($con, "SELECT * FROM public.type_of_food
                    ORDER BY type_of_food_name ASC ");

                    if (pg_num_rows($res) > 0) {
                      while ($row = pg_fetch_assoc($res)) {
                    ?>
                        <option value='<?php echo $row["type_of_food_id"]; ?>'><?php echo $row["type_of_food_name"]; ?></option>

                    <?php
                      }
                    } else {
                      echo 'нет данных';
                    }
                    ?>
                  </select>
                  <br>
                  <br>

                  <select class="container-1" name="equipment">

                    <option value='-1' selected="true" disabled="disabled">Оборудование</option>
                    <?php
                    $res = pg_query($con, "SELECT * FROM public.equipment
                    ORDER BY equipment_name ASC ");
                    if (pg_num_rows($res) > 0) {
                      while ($row = pg_fetch_assoc($res)) {
                    ?>
                        <option value='<?php echo $row["equipment_id"]; ?>'><?php echo $row["equipment_name"]; ?></option>
                    <?php
                      }
                    } else {
                      echo 'нет данных';
                    }
                    ?>
                  </select>

                  <br>
                  <br>

                  <select class="container-1" name="cooking">

                    <option value='-1' selected="true" disabled="disabled">Метод приготовления</option>
                    <?php
                    $res = pg_query($con, "SELECT * FROM public.cooking_method
                    ORDER BY cooking_method_name ASC ");
                    if (pg_num_rows($res) > 0) {
                      while ($row = pg_fetch_assoc($res)) {
                    ?>
                        <option value='<?php echo $row["cooking_method_id"]; ?>'><?php echo $row["cooking_method_name"]; ?></option>
                    <?php
                      }
                    } else {
                      echo 'нет данных';
                    }
                    ?>
                  </select>

                  <br>
                  <br>
                  <input type="submit" name="submit" value="submit">
                </form>
              </div>
            </div>

            <div class="u-container-style u-layout-cell u-size-43 u-layout-cell-2">
              <div class="u-container-layout u-container-layout-2">
                <div class="u-expanded-width-lg u-expanded-width-md u-expanded-width-sm u-expanded-width-xs u-products u-products-1">
                  <div class="u-repeater u-repeater-1">

                    <?php
                    if (!isset($_POST['submit']) && empty($_POST['submit'])) {
                      $pg = "SELECT * FROM public.recipe
                    LIMIT 10";
                      $result = pg_query($con, $pg);
                      if (!$result) {
                        echo "Произошла ошибка.\n";
                        exit;
                      }
                    ?>
                    <?php
                      if (pg_num_rows($result) > 0) {
                        while ($row = pg_fetch_assoc($result)) {
                          echo '<div class="u-align-center u-container-style u-products-item u-repeater-item u-white u-repeater-item-1">';
                          echo '<div class="u-container-layout u-similar-container u-container-layout-3">';
                          echo '<h4 class="u-product-control u-text u-text-1">';
                          // TODO поменять href="recipe.php"
                          echo '<a class="u-product-title-link" href="recipe.php">' . $row['recipe_name'] . '</a></h4>';
                          if (file_exists($row['link'])) {
                            echo '<img alt="" class="u-expanded-width u-image-1" src="' . $row['link'] . '">';
                          } else {
                            echo '<img alt="" class="u-expanded-width u-image-1" src="images/err.jpg">';
                          }
                          echo '<blockquote class="u-text u-text-2">' . $row['description'] . '<br>';
                          echo '</blockquote></div></div>';
                        }
                      }
                    }

                    ?>
                    <?php
                    $buff = false;
                    if (isset($_POST['submit']) && !empty($_POST['submit'])) {
                      if (isset($_POST['ing']) && !empty($_POST['ing'])) {
                        $ing = $_POST["ing"];
                        $result = implode(', ', $ing);
                        $pg = "SELECT DISTINCT recipe.recipe_name, recipe.recipe_id, recipe.link, recipe.description
                            FROM recipe, recipe_cooking_method, recipe_equipment, recipe_tipe_of_food, (
                                 SELECT recipe_ingredient_measure.recipe_id, array_agg(recipe_ingredient_measure.ingredient_id) as arr
                            FROM recipe_ingredient_measure 
                            GROUP BY recipe_ingredient_measure.recipe_id
                            ) AS buff
                            where buff.recipe_id = recipe.recipe_id 
                            and buff.arr @> '{" . $result . "}'::integer[] ";
                        $buff = true;
                      } else {
                        $pg = "SELECT DISTINCT recipe.recipe_name, recipe.recipe_id, recipe.link, recipe.description
                        FROM recipe, recipe_cooking_method, recipe_equipment, recipe_tipe_of_food ";
                      }

                      if (isset($_POST["type_of"]) && !empty($_POST["type_of"])) {

                        $type_of = $_POST["type_of"];
                        if ($buff == true) {
                          $pg .= "and recipe.recipe_id = recipe_tipe_of_food.recipe_id";
                        } else {
                          $pg .= "where recipe.recipe_id = recipe_tipe_of_food.recipe_id";
                          $buff = true;
                        }
                        $pg .= " and recipe_tipe_of_food.type_of_food_id = " . $type_of;
                      }

                      if (isset($_POST["equipment"]) && !empty($_POST["equipment"])) {
                        $equipment = $_POST["equipment"];
                        if ($buff == true) {
                          $pg .= "and recipe.recipe_id = recipe_equipment.recipe_id";
                        } else {
                          $pg .= "where recipe.recipe_id = recipe_equipment.recipe_id";
                          $buff = true;
                        }
                        $pg .= " and recipe_equipment.equipment_id = " . $equipment;
                      }

                      if (isset($_POST["cooking"]) && !empty($_POST["cooking"])) {
                        $cooking = $_POST["cooking"];
                        if ($buff == true) {
                          $pg .= "and recipe.recipe_id = recipe_cooking_method.recipe_id";
                        } else {
                          $pg .= "where  recipe.recipe_id = recipe_cooking_method.recipe_id";
                          $buff = true;
                        }
                        $pg .= " and recipe_cooking_method.cooking_method_id = " . $cooking;
                      }

                      $pg .= ';';
                      $result = pg_query($con, $pg);
                      if (!$result) {
                        echo "Произошла ошибка.\n";
                        exit;
                      }
                    ?>
                    <?php
                      if (pg_num_rows($result) > 0) {
                        while ($row = pg_fetch_assoc($result)) {
                          echo '<div class="u-align-center u-container-style u-products-item u-repeater-item u-white u-repeater-item-1">';
                          echo '<div class="u-container-layout u-similar-container u-container-layout-3">';
                          echo '<h4 class="u-product-control u-text u-text-1">';
                          // TODO поменять href="recipe.php"
                          echo '<a class="u-product-title-link" href="recipe.php">' . $row['recipe_name'] . '</a></h4>';
                          echo '<img alt="" class="u-expanded-width u-image-1" src="' . $row['link'] . '">';
                          echo '<blockquote class="u-text u-text-2">' . $row['description'] . '<br>';
                          echo '</blockquote></div></div>';
                        }
                      }
                    }
                    ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
  </section>


  <?php include 'footer.php' ?>

</body>

</html>
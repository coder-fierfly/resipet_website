<?php
include_once('functions.php');
include('log_check.php');
if (!isset($_SESSION['user_log'])) {
  header('location:' . SITEURL . 'enter.php');
}
?>
<!DOCTYPE html>
<html style="font-size: 16px;" lang="ru">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="utf-8">
  <meta name="keywords" content="Добавление рецепта">
  <meta name="description" content="">
  <title>add_recipe</title>
  <link rel="stylesheet" href="nicepage.css" media="screen">
  <link rel="stylesheet" href="add_recipe.css" media="screen">
  <script class="u-script" type="text/javascript" src="jquery-1.9.1.min.js" defer=""></script>
  <script class="u-script" type="text/javascript" src="nicepage.js" defer=""></script>
  <meta name="generator" content="Nicepage 5.9.8, nicepage.com">
  <meta name="referrer" content="origin">
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
  <meta property="og:title" content="add_recipe">
  <meta property="og:type" content="website">
  <meta data-intl-tel-input-cdn-path="intlTelInput/">
</head>

<body class="u-body u-xl-mode" data-lang="ru">
  <?php include('my_header.php') ?>
  <section class="u-clearfix u-section-1" id="sec-994d">
    <div class="u-clearfix u-sheet u-valign-middle u-sheet-1">
      <h2 class="u-text u-text-default u-text-1">Добавте свой рецепт!</h2>
    </div>
  </section>
  <section class="u-section-2" id="sec-7f48">
    <div class="u-clearfix u-sheet u-valign-middle-xs u-sheet-1">
      <div class="u-container-style u-expanded-width u-product u-product-1">
        <div class="u-container-layout u-container-layout-1">
          <div class="" data-interval="2000">
            <form method="POST" id="upload-container" enctype="multipart/form-data">
              <img id="upload-image" src="upload.svg">
              <div>
                <input id="file" type="file" name="file" multiple>
                <label for="file">Выберите файл</label>
              </div>
              <input type="submit" value="Загрузить файл!">
            </form>
          </div>

          <?php
          if (isset($_FILES['file'])) {
            // проверяем, можно ли загружать изображение
            $check = can_upload($_FILES['file']);
            if ($check === true) {
              // загружаем изображение на сервер
              $buff_name = make_upload($_FILES['file']);
              $_SESSION['file'] =  $buff_name;
              echo "<strong>Файл загружен!</strong>";
            } else {
              // выводим сообщение об ошибке
              echo "<script>alert(\"$check\");</script>";
            }
          }
          if (isset($_POST['sub']) && !empty($_POST['sub'])) {
            if (
              !empty($_POST['name']) && isset($_POST['desctiption']) && !empty($_POST['desctiption'])
              && isset($_POST['step']) && !empty($_POST['step'] && ($_SESSION['file'] != '') && isset($_POST['ing']) && !empty($_POST['ing']))
            ) {
              $pg = "INSERT INTO public.recipe(
                recipe_name, description, steps, link)
               VALUES ('" . $_POST['name'] . "', '" . $_POST['desctiption'] . "', '" . $_POST['step'] . "', '" .  $_SESSION['file'] . "') RETURNING recipe_id;";
              $result = pg_query($con, $pg);
              $ans = "select user_id from users where users.user_log = '" . $_SESSION['user_log'] .  "'";
              $result_log = pg_query($con, $ans);
              if (!$result) {
                echo "<script>alert(\"Произошла ошибка.\");</script>";
                exit;
              } else {
                while ($row = pg_fetch_assoc($result)) {
                  if ($result_log) {
                    while ($id = pg_fetch_assoc($result_log)) {
                      $buff_recipe = $row['recipe_id'];
                      $insert_user = "INSERT INTO public.recipe_users(
                        recipe_id, user_id)
                        VALUES (" . $buff_recipe . ", " . $id['user_id'] . ");";
                      $res_user = pg_query($con, $insert_user);
                      if (isset($_POST["type_of"]) && !empty($_POST["type_of"])) {
                        $insert_tipe = "INSERT INTO recipe_tipe_of_food(
                        recipe_id, type_of_food_id)
                        VALUES (" . $buff_recipe . ", " . $_POST["type_of"] . ");";
                        $res_tipe = pg_query($con, $insert_tipe);
                      }
                      if (isset($_POST["cooking"]) && !empty($_POST["cooking"])) {
                        $insert_met = "INSERT INTO public.recipe_cooking_method(
                        cooking_method_id, recipe_id)
                        VALUES (" . $_POST["cooking"] . ", " . $buff_recipe . ");";
                        $res_met = pg_query($con, $insert_met);
                      }

                      if (isset($_POST["equipment"]) && !empty($_POST["equipment"])) {
                        $insert_eq = "INSERT INTO public.recipe_equipment(
                        equipment_id, recipe_id)
                        VALUES (" . $_POST["equipment"] . ", " . $buff_recipe . ");";
                        $res_eq = pg_query($con, $insert_eq);
                      }

                      $arr_ing = [];
                      $arr_ing = $_POST['ing'];
                      $arr_m = [];
                      $arr_m = $_POST['mea'];
                      $length = count($arr_ing);
                      $arr_t = [];
                      $arr_t = $_POST['my_text'];
                      $new_arr = [];
                      $l = count($arr_t);
                      $b = 0;
                      for ($i = 0; $i < $l; $i++) {
                        if ($arr_t[$i] != '') {
                          $new_arr[$b] = $arr_t[$i];
                          $b += 1;
                        }
                      }
                      for ($i = 0; $i < $length; $i++) {
                        $buff_rim = $id['user_id'];
                        if (empty($arr_m[$i])) {
                          $arr_m[$i] = 6;
                        }
                        if (empty($new_arr[$i])) {
                          $new_arr[$i] = 12;
                        }
                        $insert_rim = "INSERT INTO public.recipe_ingredient_measure(
                          ingredient_id, recipe_id, measure_id, quantity)
                          VALUES (" . $arr_ing[$i] . "," . $row['recipe_id'] . ", " . $arr_m[$i] . ", " . $new_arr[$i] . ");";
                        $res_user = pg_query($con, $insert_rim);
                      }
                    }
                  }
                }
                $_SESSION['file'] = '';
              }
            } else {
              if ($_SESSION['file'] != '') {
                unlink($_SESSION['file']);
              }
            }
          }
          ?>

          <div class="u-form u-form-1">
            <form action="" method="POST" style="padding: 15px;">
              <div class="u-form-group u-form-textarea">
                <label for="message-6797" class="u-label"></label>
                <input type="text" maxlength="30" placeholder="Название" id="message-6797" name="name" required="" class="u-input u-input-rectangle">
              </div>
              <br>
              <div class="u-form-group u-form-textarea">
                <label for="message-6797" class="u-label"></label>
                <textarea type="text" maxlength="100" placeholder="Описание" rows="4" cols="50" id="message-6797" name="desctiption" class="u-input u-input-rectangle" required="" maxlength="200"></textarea>
              </div>
              <br>
              <div class="u-form-group u-form-textarea">
                <label for="textarea-2476" class="u-label"></label>
                <textarea type="text" maxlength="2000" rows="4" placeholder="Шаги" cols="50" id="textarea-2476" name="step" class="u-input u-input-rectangle" required=""></textarea>
              </div>
              <br>

              <div class="container_sc">

                <?php
                $res = pg_query($con, "SELECT * FROM  public.ingredient Where ingredient_id != 12 ORDER BY ingredient_name ASC");
                if (pg_num_rows($res) > 0) {
                  while ($row = pg_fetch_assoc($res)) {
                ?>
                    <div class="list-group-item checkbox">
                      <label><input type="checkbox" class="common_selector" name="ing[]" value="<?php echo $row['ingredient_id']; ?>"> <?php echo $row['ingredient_name']; ?>
                        <input type="number" min="0" step="0.01" max="9999" class="right" name="my_text[]"></label>
                      <select class="container_little" name="mea[]">
                        <option value='-1' selected="true" disabled="disabled">Измерение</option>
                        <?php
                        $res_m = pg_query($con, "SELECT * FROM public.measure  Where measure_id != 6
                        ORDER BY measure_name ASC ");
                        if (pg_num_rows($res_m) > 0) {
                          while ($row = pg_fetch_assoc($res_m)) {
                        ?>
                            <option value='<?php echo $row["measure_id"]; ?>'><?php echo $row["measure_name"]; ?></option>
                        <?php
                          }
                        }
                        ?>
                      </select>

                    </div>
                <?php
                  }
                }
                ?>
              </div>
              <br>

              <select class="container-add" name="type_of">
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
                }
                ?>
              </select>
              <br>
              <br>

              <select class="container-add" name="equipment">
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
                }
                ?>
              </select>
              <br>
              <br>

              <select class="container-add" name="cooking">
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
                }
                ?>
              </select>

              <br>
              <br>
              <div class="u-align-center u-form-group u-form-submit">
                <a class="u-btn u-btn-submit u-button-style">Добавить</a>
                <input type="submit" name="sub" value="sub" class="u-form-control-hidden">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
  <?php include 'footer.php' ?>
</body>

</html>
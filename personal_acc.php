<?php include('log_check.php');
if (!isset($_SESSION['user_log'])) {
  header('location:' . SITEURL . 'enter.php');
}
?>
<!DOCTYPE html>
<html style="font-size: 16px;" lang="ru">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="utf-8">
  <meta name="keywords" content="ник">
  <meta name="description" content="">
  <title>personal_acc</title>
  <link rel="stylesheet" href="nicepage.css" media="screen">
  <link rel="stylesheet" href="personal_acc.css" media="screen">
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
  <meta property="og:title" content="personal_acc">
  <meta property="og:type" content="website">
  <meta data-intl-tel-input-cdn-path="intlTelInput/">
</head>

<body class="u-body u-xl-mode" data-lang="ru">

  <?php include('my_header.php') ?>
  <section class="u-align-center u-clearfix u-section-1" id="sec-78ce">
    <div class="u-clearfix u-sheet u-sheet-1">
      <div alt="" class="u-image u-image-circle u-image-1" data-image-width="722" data-image-height="752"></div>
      <h2 class="u-text u-text-default u-text-1"><?php echo (string) $_SESSION['user_log'] ?></h2>
      <a href="add_recipe.php" class="u-active-grey-75 u-black u-border-none u-btn u-btn-round u-button-style u-hover-grey-75 u-radius-50 u-text-body-alt-color u-btn-1">Добавить
        рецепт</a>
      <a href="edit.php" class="u-active-grey-75 u-black u-border-none u-btn u-btn-round u-button-style u-hover-grey-75 u-radius-50 u-text-body-alt-color u-btn-2">Редактировать</a>
      <a href="destroy.php" class="u-active-grey-75 u-black u-border-none u-btn u-btn-round u-button-style u-hover-grey-75 u-radius-50 u-text-body-alt-color u-btn-3">Выйти</a>
      <?php
      if (isset($_POST['logout'])) {
        session_destroy();
        header('location:' . SITEURL . 'enter.php');
      }
      ?>

      <form method="post">
        <?php
        if (isset($_SESSION['admin'])) {
          if ($_SESSION['admin'] == True) {
            echo ' <a href="admin.php" class="u-active-grey-75 u-black u-border-none u-btn u-btn-round 
          u-button-style u-hover-grey-75 u-radius-50 u-text-body-alt-color u-btn-4" name="logout">Управление</a>';
          }
        }
        ?>
      </form>
    </div>
  </section>
  <section class="u-align-center u-clearfix u-section-2" id="sec-06ac">
    <div class="u-clearfix u-sheet u-valign-middle u-sheet-1">

      <div class="u-repeater u-repeater-1">
        <?php
        $pg = "SELECT DISTINCT recipe.recipe_name, recipe.recipe_id, recipe.link, recipe.description
        FROM recipe,favorite_recipe_of_user, users
        where recipe.recipe_id = favorite_recipe_of_user.recipe_id
        and users.user_id = favorite_recipe_of_user.user_id
        and users.user_log = '" . $_SESSION['user_log'] . "';";
        $result = pg_query($con, $pg);
        if (!$result) {
          echo "Произошла ошибка.\n";
          exit;
        }
        if (pg_num_rows($result) > 0) {
          while ($row = pg_fetch_assoc($result)) {
            echo '<div class="u-align-center u-container-style u-products-item u-repeater-item u-white u-repeater-item-1">';
            echo '<div class="u-container-layout u-similar-container u-container-layout-3">';
            echo '<h4 class="u-product-control u-text u-text-1">';
            echo '<a class="u-product-title-link" href="recipe.php?id=' . $row['recipe_id'] .  '"?>' . $row['recipe_name'] . '</a></h4>';
            echo '<img alt="" class="u-expanded-width u-image-1" src="' . $row['link'] . '">';
            echo '<blockquote class="u-text u-text-2">' . $row['description'] . '<br>';
            echo '</blockquote></div></div>';
          }
        }

        ?>
      </div>
    </div>
    </div>
  </section>


  <?php include 'footer.php' ?>

</body>

</html>
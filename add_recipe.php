<?php
include_once('functions.php');
include('log_check.php');
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
  <?php include('header.php') ?>
  <section class="u-clearfix u-section-1" id="sec-994d">
    <div class="u-clearfix u-sheet u-valign-middle u-sheet-1">
      <h2 class="u-text u-text-default u-text-1">Добавте свой рецепт!</h2>
    </div>
  </section>
  <section class="u-section-2" id="sec-7f48">
    <div class="u-clearfix u-sheet u-valign-middle-xs u-sheet-1"><!--product--><!--product_options_json--><!--{"source":""}--><!--/product_options_json--><!--product_item-->
      <div class="u-container-style u-expanded-width u-product u-product-1">
        <div class="u-container-layout u-container-layout-1"><!--product_gallery--><!--options_json--><!--{"maxItems":""}--><!--/options_json-->
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
              // make_upload($_FILES['file']);
              $buff_name = make_upload($_FILES['file']);

              $_SESSION['file'] =  $buff_name;


              echo "<strong>Файл загружен!</strong>";
            } else {
              // выводим сообщение об ошибке
              echo "<strong>$check</strong>";
            }
          }
          if (isset($_POST['sub']) && !empty($_POST['sub'])) {
            if (
              isset($_POST['name']) && !empty($_POST['name']) && isset($_POST['desctiption']) && !empty($_POST['desctiption'])
              && isset($_POST['step']) && !empty($_POST['step'] && $_SESSION['file'] != '')
            ) {
              echo 'все ок';
              echo '<br>';
              // echo $_SESSION['file'];
              unlink($_SESSION['file']);
              $_SESSION['file'] =  '';
            } else {
              echo 'вы забыли загрузить фото';
            }
          }

          ?>
          <?php
          // если была произведена отправка формы


          ?>
          <div class="u-form u-form-1">
            <form action="" method="POST" style="padding: 15px;">
              <div class="u-form-group u-form-textarea">
                <label for="message-6797" class="u-label"></label>
                <input type="text" placeholder="Название" id="message-6797" name="name" required="" class="u-input u-input-rectangle">
              </div>
              <br>
              <div class="u-form-group u-form-textarea">
                <label for="message-6797" class="u-label"></label>
                <textarea type="text" placeholder="Описание" rows="4" cols="50" id="message-6797" name="desctiption" class="u-input u-input-rectangle" required="" maxlength="200"></textarea>
              </div>
              <br>
              <div class="u-form-group u-form-textarea">
                <label for="textarea-2476" class="u-label"></label>
                <textarea type="text" rows="4" placeholder="Шаги" cols="50" id="textarea-2476" name="step" class="u-input u-input-rectangle" required=""></textarea>
              </div>
              <br>
              <div class="u-align-center u-form-group u-form-submit">
                <a class="u-btn u-btn-submit u-button-style">Войти</a>
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
<?php include('log_check.php');
include_once('functions.php'); ?>
<!DOCTYPE html>
<html style="font-size: 16px;" lang="ru">
<!-- TODO доделать регистрацию -->

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="utf-8">
  <meta name="keywords" content="Регистрация">
  <meta name="description" content="">
  <title>регистрация</title>
  <link rel="stylesheet" href="nicepage.css" media="screen">
  <link rel="stylesheet" href="reg.css" media="screen">
  <script class="u-script" type="text/javascript" src="jquery-1.9.1.min.js" defer=""></script>
  <script class="u-script" type="text/javascript" src="nicepage.js" defer=""></script>
  <meta name="generator" content="Nicepage 5.9.8, nicepage.com">
  <meta name="referrer" content="origin">

  <script type="application/ld+json">
    {
      "@context": "http://schema.org",
      "@type": "Organization",
      "name": "",
      "logo": "images/4768598-0.png"
    }
  </script>

  <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>

  <meta name="theme-color" content="#478ac9">
  <meta property="og:title" content="регистрация">
  <meta property="og:type" content="website">
  <meta data-intl-tel-input-cdn-path="intlTelInput/">
</head>

<body class="u-body u-xl-mode" data-lang="ru">
  <?php include('my_header.php');
  $value1 = ''; ?>
  <section class="u-align-center u-clearfix u-section-1" id="sec-2df4">
    <div class="u-clearfix u-sheet u-sheet-1">
      <h2 class="u-text u-text-default u-text-1">Регистрация</h2>
      <?php
      if (isset($_POST['send'])) {
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
      }
      if (isset($_POST['sub'])) {
        if (isset($_POST['passw']) && !empty($_POST['passw']) && isset($_POST['text-3']) && !empty($_POST['text-3'])) {
          if ($_POST['passw'] != $_POST['text-3']) {
            $value1 = "Пароли не совпадают";
          } else {
            $ch_log = "SELECT public.check_login('" . $_POST['login'] . "')";
            $res = pg_query($con, $ch_log);
            $row = pg_fetch_row($res);
            if ($row[0] == 't') {
              $value1 = "Пользователь с таким логином уже существует";
            } else {
              $buff = '';
              if (isset($buff_name_f)) {
                if ($buff_name_f != '') {
                  $buff = $buff_name_f;
                }
              }

              $salt = 'mYsAlT!';
              $p = crypt($_POST['passw'], $salt);
              if (!isset($_SESSION['file'])) {
                $_SESSION['file'] = '';
              }
              $pg = "INSERT INTO public.users(
                             user_name, user_surname, user_log, pass, admin, block, soft_delete, date_of_birth, try_to_enter, user_link)
                            VALUES ('" . $_POST['name'] . "', '" . $_POST['subname'] . "', '" . $_POST['login'] . "', '" .  $p
                .  "','" . "False" . "','" . "False" . "','" . "False" . "','" . $_POST['date'] . "','" . "0" . "','" . $_SESSION['file'] . "') ;";
              $result = pg_query($con, $pg);

              if (!$result) {
                echo "<script>alert(\"Произошла ошибка\");</script>";
                $_SESSION['file'] = '';
                exit;
              } else {
                $_SESSION['user_log'] = $_POST['login'];
                if (isset($_SESSION['file'])) {
                  if ($_SESSION['file'] != '') {
                    $_SESSION['file'] != '';
                  }
                }
                $value1 = "Пользователь зарегистрирован";
              }
            }
          }
        }
      }
      ?>
      <div class="filik">
        <form method="POST" id="upload-container" enctype="multipart/form-data">
          <img id="upload-image" src="upload.svg" style="width:200px; ">
          <div>
            <input id="file" type="file" name="file" multiple>
            <label for="file">Выберите аватар</label>
          </div>
          <input type="submit" name='send' value="Загрузить файл!">
        </form>
      </div>

      <div class="u-form u-form-1">
        <!-- <form action="add.php" method="POST" style="padding: 10px"> -->
        <form method="post" id="my-form">
          <div class="lable">
            <label for="text-aefe"></label><?php echo $value1; ?></label>
          </div>
          <!-- TODO сделать обязательный ввод в некоторые поля -->
          <div class="u-form-group u-form-name u-label-none">
            <label for="name-3b9a" class="u-label">Name</label>
            <input type="text" maxlength="30" placeholder="Введите имя" id="name-3b9a" name="name" class="u-input u-input-rectangle" required="">
          </div>
          <div class="u-form-group u-label-none u-form-group-2">
            <label for="text-a6ea" class="u-label">Поле ввода</label>
            <input type="text" maxlength="30" placeholder="Введите фамилию" id="text-a6ea" name="subname" class="u-input u-input-rectangle">
          </div>
          <div class="u-form-group u-label-none u-form-group-3">
            <label for="text-d4a8" class="u-label">Поле ввода</label>
            <input type="text" minlength="5" maxlength="30" placeholder="Введите логин" id="text-d4a8" name="login" class="u-input u-input-rectangle" required="required">
          </div>
          <div class="u-form-group u-label-none u-form-group-4">
            <label for="text-b0f1" class="u-label">Поле ввода</label>
            <input type="password" minlength="5" maxlength="30" placeholder="Пароль" id="text-b0f1" name="passw" class="u-input u-input-rectangle" required="required">
          </div>
          <div class="u-form-group u-label-none u-form-group-5">
            <label for="text-245c" class="u-label">Поле ввода</label>
            <input type="password" maxlength="30" placeholder="Повторите пароль" id="text-245c" name="text-3" class="u-input u-input-rectangle" required="required">
          </div>
          <div class="u-form-group u-label-none u-form-group-6">
            <label for="text-aefe" class="u-label">Поле ввода</label>
            <input type="date" maxlength="30" placeholder="Дата рождения" id="text-aefe" name="date" class="u-input u-input-rectangle" required="required">
          </div>
          <div class="u-align-center u-form-group u-form-submit">
            <a class="u-btn u-btn-submit u-button-style">Регистрация</a>
            <input type="submit" name="sub" value="sub" class="u-form-control-hidden">
          </div>
        </form>
      </div>
    </div>
  </section>
  <?php include 'footer.php' ?>
</body>

</html>
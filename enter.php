<?php
include 'log_check.php';
if (isset($_POST['user_log']) && isset($_POST['pwd']) && !empty($_POST['pwd']) && !empty($_POST['user_log'])) {
  echo 'asdasd';
  if (
    isset($_POST['user_log']) && !empty($_POST['pwd']) && !empty($_POST['user_log'])
    && isset($_POST['submit']) && !empty($_POST['submit'])
  ) {
    $check_log = pg_query($con, "SELECT public.check_login('" . $_POST['user_log'] . "')");
    $ch_log = pg_fetch_row($check_log);
    //проверка на существование логина
    if ($ch_log[0] == 't') {
      $check_entering = pg_query($con, "SELECT public.check_entering('" . $_POST['user_log'] . "')");
      $ch_enter = pg_fetch_row($check_entering);
      $check_block = pg_query($con, "SELECT public.check_block('" . $_POST['user_log'] . "')");
      $ch_block = pg_fetch_row($check_block);
      $check_soft_del = pg_query($con, "SELECT public.check_soft_del('" . $_POST['user_log'] . "')");
      $ch_soft_del = pg_fetch_row($check_soft_del);
      //проверка на блокировку или мягкое удаление пользователя
      if ($ch_block[0] == 't' && $ch_soft_del[0] == 't') {
        echo "пользователь заблокирован";
        $_SESSION['login'] = "пользователь заблокирован";
        header('Location:' . SITEURL . 'enter.php');
      } else {
        echo 'еей';
        $salt = 'mYsAlT!';
        $p = crypt($_POST['pwd'], $salt);
        $query = pg_query($con, "SELECT public.check_login_pass('" . $_POST['user_log'] . "','" . $p . "')");
        $row = pg_fetch_row($query);
        if ($ch_enter[0] == 'f') {

          $_SESSION['login'] = "Превышено количество попыток входа";
          header('Location:' . SITEURL . 'enter.php');
        } else {
          // session_start();
          if ($row[0] == 't') {
            pg_query($con, "SELECT public.try_to_enter_null('" . $_POST['user_log'] . "')");

            //TODO передавать логин в личный
            $_SESSION['login'] = "Login sucsess";
            //TODO сделать с личном выход по логину
            $_SESSION['user_log'] = $_POST['user_log'];
            header('location:' . SITEURL . 'personal_acc.php');
          } else {
            $_SESSION['login'] = "Проверьте пароль";
            header('Location:' . SITEURL . 'enter.php');
          }
        }
      }
    } else {
      $_SESSION['login'] = "Пользователь с таким логином не существует";
      header('Location:' . SITEURL . 'enter.php');
    }
  }
}
?>

<!DOCTYPE html>
<html style="font-size: 16px;" lang="ru">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="utf-8">
  <meta name="keywords" content="enter">
  <meta name="description" content="">
  <title>Войти</title>
  <link rel="stylesheet" href="nicepage.css" media="screen">
  <link rel="stylesheet" href="enter.css" media="screen">
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
  <meta property="og:title" content="Войти">
  <meta property="og:type" content="website">
  <meta data-intl-tel-input-cdn-path="intlTelInput/">
</head>

<body class="u-body u-xl-mode" data-lang="ru">
  <?php
  if (isset($_SESSION['user_log'])) {
    header('Location: personal_acc.php');
  }
  ?>
  <?php include('header.php') ?>
  <section class="u-align-center u-clearfix u-section-1" id="sec-9678">
    <div class="u-clearfix u-sheet u-sheet-1">
      <h2 class="u-text u-text-default u-text-1">Войти</h2>

      <div class="u-form u-form-1">
        <form action="" method="POST" style="padding: 10px">
          <div class="u-form-group u-form-name u-label-none">
            <label for="user_log" class="u-label"></label>
            <input type="text" placeholder="Введите логин" id="user_log" name="user_log" class="u-input u-input-rectangle" required="">
          </div>
          <br>
          <div class="u-form-group u-label-none u-form-group-2">
            <label for="pwd" class="u-label"></label>
            <input type="password" placeholder="Введите пароль" id="pwd" name="pwd" class="u-input u-input-rectangle">
          </div>
          <div class="u-align-center u-form-group u-form-submit">
            <a class="u-btn u-btn-submit u-button-style">Войти</a>
            <input type="submit" name="submit" value="submit" class="u-form-control-hidden">
          </div>
          <input type="hidden" value="" name="recaptchaResponse">
          <input type="hidden" name="formServices" value="7639b4c114e84de5ca88a56c5b316c88">
        </form>
      </div>
      <a href="reg.php" class="u-btn u-btn-round u-button-style u-hover-palette-1-light-2 u-palette-1-base u-radius-2 u-btn-2">Регистрация</a>
    </div>
  </section>


  <?php include 'footer.php' ?>

</body>

</html>
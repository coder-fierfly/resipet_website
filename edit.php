<?php include('log_check.php'); ?>
<!DOCTYPE html>
<html style="font-size: 16px;" lang="ru">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="keywords" content="Админская панель">
    <meta name="description" content="">
    <title>админ</title>
    <link rel="stylesheet" href="nicepage.css" media="screen">
    <link rel="stylesheet" href="admin.css" media="screen">
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
    <meta property="og:title" content="админ">
    <meta property="og:type" content="website">
    <meta data-intl-tel-input-cdn-path="intlTelInput/">
</head>

<body class="u-body u-xl-mode" data-lang="ru">
    <?php include('my_header.php') ?>
    <section class="u-align-center u-clearfix u-section-1" id="sec-ff39">
        <div class="u-clearfix u-sheet u-sheet-1">
            <h2 class="u-text u-text-default u-text-1">Изменение данных</h2>
            <?php
            if (isset($_POST['user_submit'])) {
                $query_check = pg_query($con, "SELECT public.check_login('" . $_POST['user_log'] . "')");
                $ch_log = pg_fetch_row($query_check);
                if ($ch_log[0] == 'f') {
                    echo "<script>alert(\"Пользователь не существует\");</script>";
                } else {
                    $a = (int)$_POST['user_select'];
                    switch ($a) {
                        case 1:
                            $sql = "DELETE FROM public.users WHERE user_log='" . $_POST['user_log']  . "'";
                            $ret = pg_query($con, $sql);
                            if ($ret) {
                                echo "<script>alert(\"Пользователь удален\");</script>";
                            } else {
                                echo "<script>alert(\"Что-то пошло не так\");</script>";
                            }
                            break;
                        case 6:
                            $salt = 'mYsAlT!';
                            if (!isset($_POST['pass'])) {
                                echo "<script>alert(\"Вы забыли ввести пароль\");</script>";
                            } else {
                                $p = crypt($_POST['pass'], $salt);
                                $query_change = pg_query($con, "SELECT public.change_pass('" . $_POST['user_log'] . "','" . $p . "')");
                                $change = pg_fetch_row($query_change);
                                if ($change[0] == 't') {
                                    echo "<script>alert(\"Пароль изменен\");</script>";
                                } else {
                                    echo "<script>alert(\"Что-то пошло не так\");</script>";
                                }
                            }
                            break;
                    }
                }
            }
            ?>
            <div class="u-form u-form-1">
                <form method="POST" class="u-form-horizontal1 u-form-spacing-151" style="padding: 15px">
                    <div class="u-form-group u-form-name u-label-none">
                        <label for="name-558c" class="u-label"></label>
                        <input type="text" placeholder="Логин" id="name-558c" name="user_log" value="<?php echo $_SESSION['user_log'] ?>" class="u-input u-input-rectangle" readonly>
                    </div>
                    <div class="u-form-email u-form-group u-label-none">
                        <label for="email-558c" class="u-label"></label>
                        <input type="text" placeholder="Пароль" id="email-558c" name="pass" class="u-input u-input-rectangle">
                    </div>
                    <div class="u-form-group u-form-select u-label-none u-form-group-3">
                        <label for="select-aeae" class="u-label"></label>
                        <div class="u-form-select-wrapper">
                            <select id="select-aeae" name="user_select" class="u-input u-input-rectangle" required>
                                <option value="" selected="true" disabled="disabled">Действие</option>
                                <option value="1">Удалить аккаунт</option>
                                <option value="6">Сменить пароль</option>
                            </select>
                            <svg class="u-caret u-caret-svg" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="16px" height="16px" viewBox="0 0 16 16" style="fill:currentColor;" xml:space="preserve">
                                <polygon class="st0" points="8,12 2,4 14,4 "></polygon>
                            </svg>
                        </div>
                    </div>
                    <div class="u-form-group u-form-submit u-label-none">
                        <a class="u-btn u-btn-submit u-button-style">Применить</a>
                        <input type="submit" value="user_submit" name="user_submit" class="u-form-control-hidden">
                    </div>
                </form>
            </div>
        </div>
    </section>
</body>

</html>
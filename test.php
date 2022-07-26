<?php
    session_start();
?>
<?php
    if (isset($_SESSION["userSession"])) : ?>
        <link rel="stylesheet" type="text/css" href="style.css">
        <p>Авторизован! <br>
    Добро пожаловать, <?php echo $_SESSION["userSession"]; ?> !</p>
        <br>
        <a href="logout.php">Выйти</a>
<?php else : ?>
    <link rel="stylesheet" type="text/css" href="style.css">
    <div class="start">
        <p>Добро пожаловать на сайт ..... <a href="login.php">войдите на сайт</a> или пройдите <a href="reg.php">регистрацию</a></p>
    </div>
<?php endif; ?>
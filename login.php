<?php
    session_start();
    $dataLog = $_POST;
    $salt = "reg297";

    if (isset($dataLog["doLog"])) {
        $errorLog = array();
        $userLog = array(
            "login" => $dataLog["login"], 
            "password" => $dataLog["password"],
        );
        $check = file_get_contents("db.json");
        $oldUser = json_decode($check, true);
        if ($oldUser["login"] != $dataLog["login"]) {
            $errorLog[] = "Логин введен не верно!<br>";
        } 
        if ($oldUser["password"] != md5($dataLog["password"] . $salt)) {
            $errorLog[] = "Пароль введен не верно!<br>";
        }
        if (empty($errorLog)) {
            setcookie("loggedUser", $userLog["login"], time() + (3600*24*7));
            $_SESSION["userSession"] = $userLog["login"];
            echo '<div class="showReg"> Вход выполнен!<br> 
            Можете перейти на <a href="test.php"> главную страницу</a></div>';
        } else {
            echo '<div class="showError">'.array_shift($errorLog).'</div>';
        }
    }
?>
<link rel="stylesheet" type="text/css" href="style.css">
<noscript>
   <meta http-equiv="refresh" content="0; url=nojs.php">
</noscript> 
<div class="login-wrapper">
    <form action="login.php" method="POST">
    <div>
            <p>Логин:</p>
            <input type="text" name="login" value="<?php echo @$dataLog["login"]?>">
        </div>
        <div>
            <p>Пароль:</p>
            <input type="password" name="password" value="<?php echo @$dataLog["password"]?>">
        </div>
        <div>
            <br>
            <button type="submit" name="doLog">Войти</button>
        </div>
    </form>
</div>
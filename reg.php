<?php
    session_start();
    $data = $_POST;
    $salt = "reg297";
    $oldUser = json_decode(file_get_contents("db.json"), true);

    if (isset($data["doReg"])) {
        $error = array();
        if (strlen($data["login"]) < 6) {
            $error[] = "Логин слишком короткий!<br>";
        }
        if (preg_match('/[\s]+/', $data["login"])) {
         $error[] = "Логин не должен содержать пробелов!<br>";
        }
        if ($data["login"] === $oldUser["login"]) {
         $error[] = "Пользователь с таким логином уже существует!<br>";
        }
        if (strlen($data["password"]) < 6) {
            $error[] = "Пароль должен содержать 6 символов! (включая цифры и буквы)<br>";
        }
        if (!preg_match('/[A-zА-я]+/', $data["password"])) {
            $error[] = "В вашем пароле не хвататет букв!<br>";
        }
        if (!preg_match('/[0-9]+/', $data["password"])) {
            $error[] = "В вашем пароле не хвататет цифр!<br>";
        }
        if (preg_match('/[!@#$%^&*\s]/', $data["password"])) {
            $error[] = "В вашем пароле не должно быть символов и пробелов!<br>";
        }
        if ($data["confPass"] != $data["password"]) {
            $error[] = "Не верно введён повторный пароль!<br>";
        }
        if ($data["email"] === "") {
            $error[] = "Введите Email!<br>";
        }
        if ($data["email"] === $oldUser["email"]) {
            $error[] = "Пользователь с таким Email уже существует!<br>";
        }
        if (!preg_match("#.*^(?=.{2,})(?=.*[a-zA-Z\d]).*$#", $data["name"]) ) {
            $error[] = "Имя должно содержать только буквы!<br>";
        }
        if (preg_match('/[0-9]+/', $data["name"])) {
            $error[] = "Имя должно содержать только буквы!<br>";
        }
        if (preg_match('/[!@#$%^&*\s]/', $data["name"])) {
            $error[] = "Имя должно содержать только буквы, без пробелов!<br>";
        }
        if (empty($error)) {
            $user = array(
                "login" => $data["login"], 
                "password" => md5($data["password"] . $salt), 
                "email" => $data["email"], 
                "name" => $data["name"]
            );
            '<script type="text/javascript" src="ajax.js"></script>';
            $userReg = json_encode($user, JSON_FORCE_OBJECT);
            file_put_contents('db.json', $userReg);
            echo '<div class="showReg">Регистарция прошла успешно, войдите в аккаунт <a href="\login.php">на этой</a> странице</div>';
        } else {
            echo '<div class="showError">'.array_shift($error).'</div>';
        }
    }
?>

<link rel="stylesheet" type="text/css" href="style.css">
<script type="text/javascript" src="ajax.js"></script> 
<noscript>
   <meta http-equiv="refresh" content="0; url=nojs.php">
</noscript> 
<div class="reg-wrapper">
    <form action="reg.php" method="POST" name="myForm">
        <div>
            <p>Логин:</p>
            <input type="text" name="login" value="<?php echo @$data["login"]?>">
        </div>
        <div>
            <p>Пароль:</p>
            <input type="password" name="password" value="<?php echo @$data["password"]?>">
        </div>
        <div>
            <p>Повторите пароль:</p>
            <input type="password" name="confPass" value="<?php echo @$data["confPass"]?>">
        </div>
        <div>
            <p>Email:</p>
            <input type="email" name="email" value="<?php echo @$data["email"]?>">
        </div>
        <div>
            <p>Имя:</p>
            <input type="text" name="name" value="<?php echo @$data["name"]?>">
        </div>
        <div>
            <br>
            <input value="Регистарция" name="doReg" type="submit">
        </div>
    </form>
</div
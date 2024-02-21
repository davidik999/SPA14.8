<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Обработка отправленной формы
    $login = $_POST['login'];
    
    // Проверка наличия даты рождения в массиве $_POST
    $birthdate = isset($_POST['birthdate']) ? $_POST['birthdate'] : null;

    $password = $_POST['password'];

    // Хеширование пароля
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Сохранение в файл
    $data = "$login|$birthdate|$hashedPassword\n";
    file_put_contents('users.txt', $data, FILE_APPEND);

    echo "Пользователь зарегистрирован!";

    // Перенаправление через 2 секунды на index.php
    header("refresh:2;url=index.php");
    exit();
} else {
    // Отображение формы
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
    </head>
    <body>
        <h2>Регистрация</h2>
        <form method="post" action="login.php">
            <label for="login">Логин:</label>
            <input type="text" name="login" required><br>

            <label for="birthdate">Дата рождения:</label>
            <input type="date" name="birthdate" required><br>

            <label for="password">Пароль:</label>
            <input type="password" name="password" required><br>

            <input type="submit" value="Зарегистрироваться">
        </form>
    </body>
    </html>
    <?php
}
?>

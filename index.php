<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Обработка отправленной формы для авторизации
    $login = $_POST['login'];
    $password = $_POST['password'];

    // Здесь вам нужно считать пользователей из файла или базы данных
    // Пример функции checkCredentials
    function checkCredentials($login, $password) {
        $usersData = file_get_contents('users.txt');
        $users = explode("\n", trim($usersData));

        foreach ($users as $user) {
            $userData = explode("|", $user);
            if (count($userData) === 3) {
                list($storedLogin, $birthdate, $hashedPassword) = $userData;

                if ($login === $storedLogin && password_verify($password, $hashedPassword)) {
                    // Авторизация успешна
                    $_SESSION['user'] = ['login' => $login, 'birthdate' => $birthdate];
                    header("Location: index.php");
                    exit();
                }
            }
        }

        // Если авторизация не удалась, вы можете вывести сообщение об ошибке
        echo "Неверные логин или пароль";
    }

    // Вызываем функцию для проверки авторизации
    checkCredentials($login, $password);
}

// Включаем всплывающее окно в любом случае
?>





<!DOCTYPE html>
<!-- 
-->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Демо Спа Салон</title>
	<!-- Всплывающее окно -->
    <?php include 'popup.php'; ?>
    <style>
        /* Стилизация всплывающего окна */
        #popup {
			z-index: 1000; /* что бы гарантированно был сверху */
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }
    </style>
	
    <link rel="stylesheet" href="./css/style-catalog.css" />
	<link rel="stylesheet" href="./css/header-footer.css">
	<link rel="stylesheet" href="styles.css">
		

	





	<style>
		
       body {
            margin: 0;
            padding: 0;
            background-color: #F8F8EE;
        }
		
		
        header, footer {
            background-color: #F8F8EE;
            padding: 20px;
            text-align: center;
            display: flex;
            justify-content: space-around;
            align-items: center;
            flex-wrap: wrap;
        }
		
	.all-text {
        font-size: 20px;
        color: #2C97CC;
        margin-bottom: 5px;
    }
		
	.text {
        font-size: 50px;
        color: #2C97CC;
        margin-bottom: 5px;
		text-align: center;
    }
	
	
	.goods-label h2 {
        color: white;
    }
	
	
	</style>	
		
</head>


<body>



  <header>

		<a href="login.php" class="all-text"><img src="logo.png" alt="Image 1"><br>Регистрация</a>

    <!-- Основной контент страницы -->
	<div class="all-text">
    <?php
    // Если пользователь авторизован, показываем приветствие и информацию о днях до дня рождения
    if (isset($_SESSION['user'])) {
        $user = $_SESSION['user'];

        // Проверяем, установлена ли дата рождения
        if (isset($user['birthdate'])) {
            // Используем DateTimeImmutable::createFromFormat
            $birthdate = DateTimeImmutable::createFromFormat('Y-m-d', $user['birthdate'])->setTime(0, 0);

            // Проверяем, успешно ли создан объект DateTimeImmutable
            if ($birthdate instanceof DateTimeImmutable) {
                $today = new DateTimeImmutable();

                // Проверяем, является ли сегодня днем рождения
                $nextBirthday = $birthdate->setDate($today->format('Y'), $birthdate->format('m'), $birthdate->format('d'));
                if ($today > $nextBirthday) {
                    $nextBirthday = $nextBirthday->modify('+1 year');
                }

                $daysUntilBirthday = $today->diff($nextBirthday)->days;

                echo "Привет, {$user['login']}!<br>";

                if ($daysUntilBirthday > 0) {
                    echo "До дня рождения осталось {$daysUntilBirthday} дней.";
                } elseif ($daysUntilBirthday === 0) {
                    echo "С днем рождения, {$user['login']}! Специальная скидка 5% на все услуги! ";
                } else {
                    echo "День рождения уже прошел. С днем рождения, {$user['login']}!";
                }

            } else {
                echo "Ошибка: Неверный формат даты рождения.";
            }
        } else {
            echo "Ошибка: Дата рождения пользователя не установлена в сессии.";
        }
        ?>
		</div>
        <form method="post" action="logout.php">
            <input type="submit" value="Выйти">
        </form>
        <?php
    } else {
        // Если пользователь не авторизован, выводим форму авторизации
        ?>
        <h2>Авторизация</h2>
        <form method="post" action="index.php">
            <label for="login">Логин:</label>
            <input type="text" name="login" required><br>

            <label for="password">Пароль:</label>
            <input type="password" name="password" required><br>

            <input type="submit" value="Войти">
        </form>
        <?php
    }
    ?>
    <!-- JavaScript для отображения всплывающего окна -->
    <script>
        // Функция для отображения всплывающего окна
        function showPopup() {
            document.getElementById('popup').style.display = 'block';
        }

        // Функция для закрытия всплывающего окна
        function closePopup() {
            document.getElementById('popup').style.display = 'none';
        }

        // Вызываем функцию showPopup после определенного времени (например, 5000 мс = 5 секунд)
        setTimeout(showPopup, 5000);
    </script>
    </header>


    <main class="main">
        <div class="wrapper">
             <div class="catalog">
			 <div class="text">Список Спа-программ</div>

            <div class="catalog-goods">
			
                <div class="goods element-animation">
                    <a href="./index.php">
                        <div class="goods-photo">
                            <img src="01.png" alt="" class="img">
                        </div>
                        <div class="goods-label">
                            <h2>Расслабление - 3000 Р.</h2>
                        </div>

                    </a>
                </div>
				
                 <div class="goods element-animation">
                    <a href="./index.php">
                        <div class="goods-photo">
                            <img src="02.png" alt="" class="img">
                        </div>
                        <div class="goods-label">
                            <h2>Восстановление - 3000 Р.</h2>
                        </div>

                    </a>
                </div>
				
                 <div class="goods element-animation">
                    <a href="./index.php">
                        <div class="goods-photo">
                            <img src="03.png" alt="" class="img">
                        </div>
                        <div class="goods-label">
                            <h2>Заряд - 3000 Р.</h2>
                        </div>
  
                    </a>
                </div>
				
				                <div class="goods element-animation">
                    <a href="./index.php">
                        <div class="goods-photo">
                            <img src="01.png" alt="" class="img">
                        </div>
                        <div class="goods-label">
                            <h2>Расслабление - 3000 Р.</h2>
                        </div>

                    </a>
                </div>
				
                 <div class="goods element-animation">
                    <a href="./index.php">
                        <div class="goods-photo">
                            <img src="02.png" alt="" class="img">
                        </div>
                        <div class="goods-label">
                            <h2>Восстановление</h2>
                        </div>

                    </a>
                </div>
				
                 <div class="goods element-animation">
                    <a href="./index.php">
                        <div class="goods-photo">
                            <img src="03.png" alt="" class="img">
                        </div>
                        <div class="goods-label">
                            <h2>Заряд - 3000 Р.</h2>
                        </div>
  
                    </a>
                </div>
				
				                <div class="goods element-animation">
                    <a href="./index.php">
                        <div class="goods-photo">
                            <img src="01.png" alt="" class="img">
                        </div>
                        <div class="goods-label">
                            <h2>Расслабление - 3000 Р.</h2>
                        </div>

                    </a>
                </div>
				
                 <div class="goods element-animation">
                    <a href="./index.php">
                        <div class="goods-photo">
                            <img src="02.png" alt="" class="img">
                        </div>
                        <div class="goods-label">
                            <h2>Восстановление</h2>
                        </div>

                    </a>
                </div>
				
                 <div class="goods element-animation">
                    <a href="./index.php">
                        <div class="goods-photo">
                            <img src="03.png" alt="" class="img">
                        </div>
                        <div class="goods-label">
                            <h2>Заряд - 3000 Р.</h2>
                        </div>
  
                    </a>
                </div>
				
				                <div class="goods element-animation">
                    <a href="./index.php">
                        <div class="goods-photo">
                            <img src="01.png" alt="" class="img">
                        </div>
                        <div class="goods-label">
                            <h2>Расслабление - 3000 Р.</h2>
                        </div>

                    </a>
                </div>
				
                 <div class="goods element-animation">
                    <a href="./index.php">
                        <div class="goods-photo">
                            <img src="02.png" alt="" class="img">
                        </div>
                        <div class="goods-label">
                            <h2>Восстановление</h2>
                        </div>

                    </a>
                </div>
				
                 <div class="goods element-animation">
                    <a href="./index.php">
                        <div class="goods-photo">
                            <img src="03.png" alt="" class="img">
                        </div>
                        <div class="goods-label">
                            <h2>Заряд - 3000 Р.</h2>
                        </div>
  
                    </a>
                </div>
				
				                <div class="goods element-animation">
                    <a href="./index.php">
                        <div class="goods-photo">
                            <img src="01.png" alt="" class="img">
                        </div>
                        <div class="goods-label">
                            <h2>Расслабление - 3000 Р.</h2>
                        </div>

                    </a>
                </div>
				
                 <div class="goods element-animation">
                    <a href="./index.php">
                        <div class="goods-photo">
                            <img src="02.png" alt="" class="img">
                        </div>
                        <div class="goods-label">
                            <h2>Восстановление</h2>
                        </div>

                    </a>
                </div>
				
                 <div class="goods element-animation">
                    <a href="./index.php">
                        <div class="goods-photo">
                            <img src="03.png" alt="" class="img">
                        </div>
                        <div class="goods-label">
                            <h2>Заряд - 3000 Р.</h2>
                        </div>
  
                    </a>
                </div>
				
				                <div class="goods element-animation">
                    <a href="./index.php">
                        <div class="goods-photo">
                            <img src="01.png" alt="" class="img">
                        </div>
                        <div class="goods-label">
                            <h2>Расслабление - 3000 Р.</h2>
                        </div>

                    </a>
                </div>
				
                 <div class="goods element-animation">
                    <a href="./index.php">
                        <div class="goods-photo">
                            <img src="02.png" alt="" class="img">
                        </div>
                        <div class="goods-label">
                            <h2>Восстановление</h2>
                        </div>

                    </a>
                </div>
				
                 <div class="goods element-animation">
                    <a href="./index.php">
                        <div class="goods-photo">
                            <img src="03.png" alt="" class="img">
                        </div>
                        <div class="goods-label">
                            <h2>Заряд - 3000 Р.</h2>
                        </div>
  
                    </a>
                </div>
		
				
				
				
                
            </div>

        </div>

        </div>
       

    </main>

       <footer>
		<a href="index.php" class="all-text"><img src="logo.png" alt="Image 1"><br>СПА САЛОН</a>
    </footer>
	

	
    <script src="./js/coming.js"></script>
	
	
	<script src="script.js"></script>
	<script>
    document.addEventListener("DOMContentLoaded", function () {
        var body = document.querySelector('body');
        body.style.marginTop = '200px'; // 
    });
	</script>


</body>
</html>
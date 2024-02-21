<!-- popup.php -->
<div class="all-text">
<div id="popup">
	<img src="logo.png" alt="Image 1"></a>
    <p>Позвони менеджеру прямо сейчас и получи скидку 10%!</p>
    <p id="countdown">Осталось: 5:00</p>
    <button onclick="closePopup()">Закрыть</button>
</div>
</div>

<script>
    // Устанавливаем время обратного отсчета в секундах (5 минут)
    var countdownTime = 5 * 60;

    // Функция для форматирования времени в формат "мм:сс"
    function formatTime(seconds) {
        var minutes = Math.floor(seconds / 60);
        var remainingSeconds = seconds % 60;

        // Добавляем ведущий ноль, если секунды меньше 10
        if (remainingSeconds < 10) {
            remainingSeconds = "0" + remainingSeconds;
        }

        return minutes + ":" + remainingSeconds;
    }

    // Функция для обновления отображаемого времени
    function updateCountdown() {
        document.getElementById("countdown").innerHTML = "Осталось: " + formatTime(countdownTime);

        if (countdownTime > 0) {
            countdownTime--;
            setTimeout(updateCountdown, 1000); // Вызываем функцию каждую секунду
        } else {
            closePopup(); // Закрываем всплывающее окно по истечении времени
        }
    }

    // Начинаем обратный отсчет при загрузке окна
    updateCountdown();
</script>

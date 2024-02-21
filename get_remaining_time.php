<?php
// get_remaining_time.php

// Функция для получения оставшегося времени (время на сервере)
function getRemainingTime() {
    $startTime = strtotime('now'); // Время начала таймера
    $endTime = strtotime('+5 minutes'); // Время окончания таймера

    $remainingSeconds = $endTime - $startTime;

    $minutes = floor($remainingSeconds / 60);
    $seconds = $remainingSeconds % 60;

    return sprintf("%02d:%02d", $minutes, $seconds);
}

// Возвращаем оставшееся время в формате "мм:сс"
echo getRemainingTime();
?>
